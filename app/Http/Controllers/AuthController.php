<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\Auth\InvalidPassword;
use App\Http\Controllers\PersonalityTestController;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    // 🔹 Show Register Page
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 🔹 Register New User
    public function register(Request $request)
    {
    $validated = $request->validate([
    'name' => 'required|string',
    'email' => 'required|email',
    'password' => 'required|min:6',
    'phone' => 'required|string',
    'programme' => 'required|string',
    'cgpa' => 'required|numeric|min:0|max:4',
    'year_of_study' => 'required|integer|min:1|max:5',
    ]);

    $firebase = (new Factory)
        ->withServiceAccount(base_path('firebase_credentials.json'))
        ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $auth = $firebase->createAuth();
    $database = $firebase->createDatabase();

    // ✅ Always create STUDENT
    $user = $auth->createUser([
        'email' => $validated['email'],
        'password' => $validated['password'],
        'displayName' => $validated['name'],
    ]);

    $database->getReference('users/' . $user->uid)->set([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => 'student',
        'created_at' => now()->toDateTimeString(),
        'profile' => [
        'phone' => $validated['phone'],
        'programme' => $validated['programme'],
        'cgpa' => $validated['cgpa'],
        'year_of_study' => $validated['year_of_study'],
        ]
    ]);

    return redirect()->route('login')
        ->with('success', 'Student account created successfully!');
    }

    public function showLoginForm()
    {
    return view('auth.login');
    }  

    // 🔹 Login with Firebase
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $firebase = (new Factory)
            ->withServiceAccount(base_path('firebase_credentials.json'))
            ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $auth = $firebase->createAuth();

        try {
            // Login
            $signInResult = $auth->signInWithEmailAndPassword(
                $validated['email'],
               $validated['password']
            );

            // Get Firebase user
            $uid = $signInResult->firebaseUserId();
            $firebaseUser = $auth->getUser($uid);

            // Get role from DB
            $role = $this->getUserRole($uid);

            if (!$role) {
                return back()->with('error', 'No role found for this user.');
            }

            // Save session
            session([
                'uid' => $uid,
                'role' => $role,
                'firebase_user' => [
                    'name' => $firebaseUser->displayName,
                    'email' => $firebaseUser->email,
                ],
            ]);

            session()->save();

            // Redirect
            if ($role === 'student') {
                return redirect()->route('student.dashboard');
            }

            if ($role === 'coordinator') {
                return redirect()->route('coordinator.dashboard');
            }

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return back()->with('error', 'Invalid role.');


        } catch (InvalidPassword $e) {
            return back()->with('error', 'Wrong password.');
        } catch (UserNotFound $e) {
            return back()->with('error', 'User does not exist in Firebase Auth.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Login failed: '.$e->getMessage());
        }
    }

    private function getUserRole($uid)
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path('firebase_credentials.json'))
            ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');
        $database = $firebase->createDatabase();

        $userData = $database->getReference('users/' . $uid)->getValue();
        return $userData['role'] ?? 'guest';
    }

    // 🔹 Logout
    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    // 🔹 Dashboards
    // ================= DASHBOARDS =================

public function studentDashboard()
{
    $firebaseUser = session('firebase_user');
    $uid = session('uid');

    $firebase = (new Factory)
        ->withServiceAccount(base_path('firebase_credentials.json'))
        ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $database = $firebase->createDatabase();

    // ================= PERSONALITY TEST RESULT =================
    $latestAttempt = $database->getReference("personality_answers/{$uid}")->getValue() ?? [];
    $latestKey = !empty($latestAttempt) ? array_key_last($latestAttempt) : null;
    $latestResult = $latestKey ? $latestAttempt[$latestKey] : null;

    $personalityType = $latestResult['type'] ?? null;
    $hasTakenTest = !is_null($personalityType);
    $recommended_internships = [];

    if ($personalityType) {
        $personalityController = new PersonalityTestController();
        $recommended_internships = $personalityController
            ->getRecommendedInternship($personalityType);
    }

    // ================= GUIDELINES =================
    $guidelines = $database->getReference('guidelines')->getValue() ?? [];

    return view('dashboard.student', [
        'firebaseUser'          => $firebaseUser,
        'personalityType'       => $personalityType,
        'hasTakenTest'           => $hasTakenTest,
        'recommended_internships'=> $recommended_internships,
        'guidelines'            => $guidelines,
    ]);
}

public function coordinatorDashboard()
{
    $uid = session('uid');

    $firebase = (new Factory)
        ->withServiceAccount(base_path('firebase_credentials.json'))
        ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $database = $firebase->createDatabase();

    // ================= USERS =================
    $users = $database->getReference('users')->getValue() ?? [];

    $studentsCount = collect($users)->where('role', 'student')->count();

    // ================= INTERNSHIPS =================
    $internships = $database->getReference('internship_industries')->getValue() ?? [];

    $totalInternships = count($internships);

    $approvedInternships = collect($internships)
        ->where('status', 'approved')
        ->count();

    $pendingInternships = collect($internships)
        ->where('status', 'pending')
        ->count();

    // ================= GUIDELINES =================
    $guidelines = $database->getReference('guidelines')->getValue() ?? [];
    

    return view('dashboard.coordinator', [
        'studentsCount'        => $studentsCount,
        'totalInternships'     => $totalInternships,
        'approvedInternships'  => $approvedInternships,
        'pendingInternships'   => $pendingInternships,
        'guidelines'           => $guidelines,
    ]);
}

public function adminDashboard()
{
    if (session('role') !== 'admin') {
        abort(403, 'Unauthorized');
    }

    $firebase = (new Factory)
        ->withServiceAccount(base_path('firebase_credentials.json'))
        ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $database = $firebase->createDatabase();

    // ================= USERS =================
    $users = $database->getReference('users')->getValue() ?? [];

    $studentsCount = collect($users)->where('role', 'student')->count();
    $coordinatorsCount = collect($users)->where('role', 'coordinator')->count();

    // ================= INTERNSHIPS =================
    $internships = $database->getReference('internship_industries')->getValue() ?? [];

    $totalInternships = count($internships);

    $approvedInternships = collect($internships)
        ->where('status', 'approved')
        ->count();

    $pendingInternships = collect($internships)
        ->where('status', 'pending')
        ->count();

    // ================= GUIDELINES =================
    $guidelines = $database->getReference('guidelines')->getValue() ?? [];

    return view('dashboard.admin', [
        'studentsCount'        => $studentsCount,
        'coordinatorsCount'    => $coordinatorsCount,
        'totalInternships'     => $totalInternships,
        'approvedInternships'  => $approvedInternships,
        'pendingInternships'   => $pendingInternships,
        'guidelines'           => $guidelines,
    ]);
}

    public function showCreateCoordinatorForm()
    {

    return view('auth.createCoordinator');
    }

    public function storeCoordinator(Request $request)
    {
   
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $firebase = (new Factory)
        ->withServiceAccount(base_path('firebase_credentials.json'))
        ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $auth = $firebase->createAuth();
    $database = $firebase->createDatabase();

    // 🔒 CREATE COORDINATOR ACCOUNT
    $user = $auth->createUser([
        'email' => $validated['email'],
        'password' => $validated['password'],
        'displayName' => $validated['name'],
    ]);

    $database->getReference('users/' . $user->uid)->set([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => 'coordinator', // 🔐 HARD CODED
        'created_at' => now()->toDateTimeString(),
    ]);

    return redirect()->route('admin.dashboard')
        ->with('success', 'Coordinator account created successfully.');
    }

}
