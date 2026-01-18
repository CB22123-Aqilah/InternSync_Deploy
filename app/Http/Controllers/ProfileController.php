<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class ProfileController extends Controller
{
    protected function db()
    {
        return (new Factory)
            ->withServiceAccount(base_path('firebase_credentials.json'))
            ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/')
            ->createDatabase();
    }

    // ============================================================
    // STUDENT: VIEW OWN PROFILE
    // ============================================================
    public function myProfile()
    {
        $uid = session('uid');
        $role = session('role');

        if ($role !== 'student') {
            return back()->with('error', 'You cannot access this page.');
        }

        $profile = $this->db()->getReference("users/$uid")->getValue();
        $profile['uid'] = $uid;

        return view('profiles.show', compact('profile'));
    }

    // ============================================================
    // STUDENT: UPDATE OWN PROFILE
    // ============================================================
    public function updateMyProfile(Request $request)
{
    $uid = session('uid');

    if (!$uid) {
        return back()->with('error', 'User not logged in');
    }

    $ref = $this->db()->getReference("users/$uid");

    $ref->update([
        'name'  => $request->name,
        'email' => $request->email,
        'profile' => [
            'phone'         => $request->phone,
            'address'       => $request->address,
            'programme'     => $request->programme,
            'cgpa'          => $request->cgpa,
            'year_of_study' => $request->year_of_study,
        ]
    ]);

    return redirect()->route('profile.index')->with('success', 'Profile updated!');
}

public function edit()
{
    $uid = session('uid');
    $role = session('role');

    if ($role !== 'student') {
        return back()->with('error', 'Access denied.');
    }

    $profile = $this->db()->getReference("users/$uid")->getValue();
    $profile['uid'] = $uid;

    return view('profiles.edit', compact('profile'));
}

    // ============================================================
    // COORDINATOR: VIEW STUDENT LIST
    // ============================================================
    public function allStudents()
    {
        if (session('role') !== 'coordinator') {
            return back()->with('error', 'Access denied.');
        }

        $allUsers = $this->db()->getReference('users')->getValue(); // fetch all users

        $students = [];
        if (!empty($allUsers)) {
            foreach ($allUsers as $uid => $user) {
                if (isset($user['role']) && $user['role'] === 'student') {
                    $students[$uid] = $user;
                }
            }
        }

        return view('profiles.index', [
            'profiles' => $students,
            'viewType' => 'coordinator'
        ]);
    }

    // Coordinator view specific student
    public function viewStudent($uid)
    {
        if (session('role') !== 'coordinator') {
            return back()->with('error', 'Access denied.');
        }

        $profile = $this->db()->getReference("users/$uid")->getValue();
        $profile['uid'] = $uid;
        return view('profiles.show', compact('profile'));
    }

    // ============================================================
    // ADMIN ACCESS
    // ============================================================
    public function adminList()
    {
        if (session('role') !== 'admin') {
            return back()->with('error', 'Access denied.');
        }

        $allUsers = $this->db()->getReference('users')->getValue();

        $students = [];
        if (!empty($allUsers)) {
            foreach ($allUsers as $uid => $user) {
                if (isset($user['role']) && $user['role'] === 'student') {
                    $students[$uid] = $user;
                }
            }
        }

        return view('profiles.index', [
            'profiles' => $students,
            'viewType' => 'admin'
        ]);
    }

    public function adminView($uid)
    {
        if (session('role') !== 'admin') return back();

        $profile = $this->db()->getReference("users/$uid")->getValue();
        $profile['uid'] = $uid;

        return view('profiles.show', [
            'profile' => $profile,
            'admin' => true
        ]);
    }

    // ============================================================
    // ADMIN: UPDATE ANY USER
    // ============================================================
    public function adminUpdate(Request $request, $uid)
{
    $ref = $this->db()->getReference("users/$uid");

    $ref->update([
        'name'  => $request->name,
        'email' => $request->email,
        'profile' => [
            'phone'         => $request->phone,
            'address'       => $request->address,
            'programme'     => $request->programme,
            'cgpa'          => $request->cgpa,
            'year_of_study' => $request->year_of_study,
        ]
    ]);
    return back()->with('success', 'Student profile updated!');
}



    // ============================================================
    // ADMIN: DELETE ANY USER
    // ============================================================
    public function adminDelete($uid)
    {
        if (session('role') !== 'admin') return back();

        $this->db()->getReference("users/$uid")->remove();

        return redirect()
            ->route('admin.students')
            ->with('success', 'User deleted successfully!');
    }

}
