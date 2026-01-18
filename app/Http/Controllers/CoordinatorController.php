<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class CoordinatorController extends Controller
{
    protected $database;
    protected $table = 'users'; // assuming your Firebase stores user info under 'users'

    public function __construct()
    {
        // Initialize Firebase connection
        $firebase = (new Factory)
            ->withServiceAccount(base_path('firebase_credentials.json'))
            ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->database = $firebase->createDatabase();
    }

    /**
     * Show all students to coordinator
     */
    public function studentsIndex()
    {
        $allUsers = $this->database->getReference($this->table)->getValue() ?? [];

        // Filter only users with role 'student'
        $students = [];
        foreach ($allUsers as $uid => $user) {
            if (isset($user['role']) && $user['role'] === 'student') {
                $user['uid'] = $uid; // store UID for link
                $students[] = $user;
            }
        }

        return view('coordinator.students.index', compact('students'));
    }

    /**
     * View one student’s detailed profile
     */
    public function studentShow($uid)
    {
        $student = $this->database->getReference($this->table . '/' . $uid)->getValue();

        if (!$student) {
            return redirect()->route('coordinator.students')->with('error', 'Student not found.');
        }

        return view('coordinator.students.show', compact('student'));
    }
}
