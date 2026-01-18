<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class PersonalityTestController extends Controller
{
    protected $db;

    public function __construct()
    {
        // Initialize Firebase Realtime Database
        $firebase = (new Factory)
            ->withServiceAccount(base_path('firebase_credentials.json'))
            ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->db = $firebase->createDatabase();
    }

    private function getRole()
{
    return session('role', 'guest');
}

    protected function checkAdminOrCoordinator()
    {
        $role = session('role', 'guest');
        if (!in_array($role, ['admin', 'coordinator'])) {
            abort(403, 'Unauthorized');
        }
    }


    protected function checkStudent()
    {
        $role = session('role', 'guest');
        if ($role !== 'student') {
            abort(403, 'Unauthorized');
        }
    }


    // ================= STUDENT =================

        // View list of questions (start page)
    public function index()
    {
        $this->checkStudent();

        $uid = session('uid');

        // Fetch all questions
        $questions = $this->db->getReference('personality_questions')->getValue() ?? [];

        // Fetch student's last attempt (if any)
        $latest = null;
        if ($uid) {
            $attempts = $this->db->getReference("personality_answers/{$uid}")->getValue();
            if ($attempts) {
                // Get last attempt
                $lastKey = array_key_last($attempts);
                $lastAttempt = $attempts[$lastKey];

                // Compute type if not saved already
                $type = $lastAttempt['type'] ?? $this->calculatePersonalityType($lastAttempt['answers'] ?? []);

                $latest = [
                    'type' => $type,
                    'completed_at' => $lastAttempt['completed_at'] ?? now()->format('Y-m-d H:i:s'),
                    'recommended_internships' => $this->getRecommendedInternship($type)
                ];
            }
        }

        return view('assessments.index', compact('questions', 'latest'));
    }

    // Start test (maybe select a question subset)
    public function start()
    {
        $this->checkStudent();

        $questions = $this->db->getReference('personality_questions')->getValue() ?? [];
        return view('assessments.start', compact('questions'));
    }

    // Submit answers
    public function submit(Request $request)
    {
        $this->checkStudent();

        $uid = session('uid');
        if (!$uid) abort(403);

        $answers = $request->input('answers', []);

        // Calculate personality type
        $type = $this->calculatePersonalityType($answers);

        // Save with timestamp
        $this->db->getReference("personality_answers/{$uid}")->push([
            'answers' => $answers,
            'type' => $type,
            'completed_at' => now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('assessments.index')->with('success', 'Test submitted.');
    }

    // ================= ADMIN =================

    // View all personality questions
    public function adminIndex()
{
    $this->checkAdminOrCoordinator();

    // Get all questions
    $questions = $this->db->getReference('personality_questions')->getValue() ?? [];

    // Sort them by "number"
    uasort($questions, function($a, $b) {
        return ($a['number'] ?? 0) <=> ($b['number'] ?? 0);
    });

    return view('assessments.adminIndex', [
    'questions' => $questions,
    'role' => $this->getRole()
]);
}

    // Show create question form
    public function adminCreate()
    {
        $this->checkAdminOrCoordinator();
        return view('assessments.create', [
    'role' => $this->getRole()
]);
    }

    // Store new question
    public function adminStore(Request $request)
{
    $this->checkAdminOrCoordinator();

    // Get total existing questions to auto-generate next number
    $existing = $this->db->getReference('personality_questions')->getValue() ?? [];
    $nextNumber = count($existing) + 1;

    $data = [
        'number'   => $nextNumber, // AUTO ASSIGN QUESTION NUMBER
        'question' => $request->input('question'),

        'options' => [
            'A' => ['text' => $request->input('A_text'), 'type' => $request->input('A_type')],
            'B' => ['text' => $request->input('B_text'), 'type' => $request->input('B_type')],
            'C' => ['text' => $request->input('C_text'), 'type' => $request->input('C_type')],
            'D' => ['text' => $request->input('D_text'), 'type' => $request->input('D_type')],
        ],
    ];

    // Push new question into Firebase
    $this->db->getReference('personality_questions')->push($data);

    return redirect()->route('personality.index')->with('success', 'Question added.');
}

    // Show edit question form
    public function adminEdit($id)
    {
        $this->checkAdminOrCoordinator();

        $question = $this->db->getReference("personality_questions/{$id}")->getValue();
        if (!$question) abort(404);

        return view('assessments.edit', [
    'id' => $id,
    'question' => $question,
    'role' => $this->getRole()
]);
    }

    // Update question
    public function adminUpdate(Request $request, $id)
{
    $this->checkAdminOrCoordinator();

    // Build options exactly like adminStore()
    $options = [];

    foreach(['A','B','C','D'] as $letter) {
        $text = $request->input("{$letter}_text");
        $type = $request->input("{$letter}_type");

        if ($text && $type) {
            $options[$letter] = [
                'text' => $text,
                'type' => $type,
            ];
        }
    }

    $data = [
        'question' => $request->input('question'),
        'options'  => $options,
    ];

    // Update question in Firebase
    $this->db->getReference("personality_questions/{$id}")->update($data);

    return redirect()->route('personality.index')
                     ->with('success', 'Question updated.');
}

    // Delete question
    public function adminDelete($id)
    {
        $this->checkAdminOrCoordinator();

        $this->db->getReference("personality_questions/{$id}")->remove();

        return redirect()->route('personality.index')->with('success', 'Question deleted.');
    }


    // ================= HELPER =================
    // HELPER: Calculate personality type
    private function calculatePersonalityType($answers)
{
    // Holland order for tie-breaking
    $hollandOrder = ['R','I','A','S','E','C'];

    // Step 1: Count occurrences for each type
    $typesCount = array_fill_keys($hollandOrder, 0);
    foreach ($answers as $index => $ans) {
        if (isset($typesCount[$ans])) {
            $typesCount[$ans] += 1;

            // Step 2: Apply Q1 primary boost (optional)
            if ($index > 0 && isset($answers[0]) && $answers[0] === $ans) {
                $typesCount[$ans] += 1; // +1 bonus
            }
        }
    }

    // Step 3: Sort types by score descending, then Holland order
    uasort($typesCount, function($aScore, $bScore) use ($typesCount, $hollandOrder) {
        if ($aScore === $bScore) return 0;
        return $bScore <=> $aScore; // Descending by score
    });

    // Step 4: Resolve tie using Holland order
    $sortedTypes = [];
    foreach ($hollandOrder as $t) {
        if (isset($typesCount[$t]) && $typesCount[$t] > 0) {
            $sortedTypes[$t] = $typesCount[$t];
        }
    }

    // Step 5: Pick top 3 types
    $topTypes = array_slice(array_keys($sortedTypes), 0, 3);

    return implode('', $topTypes); // e.g., "RI", "RIA"
}

    // HELPER: Recommended internships
    public function getRecommendedInternship($type)
{
    // Single-type recommendations
    $singleMapping = [
        'R' => ['Engineering Technician', 'Architecture Assistant', 'Lab Technician'],
        'I' => ['Data Analyst', 'Research Assistant', 'Software Developer'],
        'A' => ['Graphic Designer', 'Content Creator', 'Multimedia Designer'],
        'S' => ['Teaching Assistant', 'HR Support', 'Counseling Support'],
        'E' => ['Business Trainee', 'Marketing Executive', 'Sales Coordinator'],
        'C' => ['Admin Clerk', 'Finance Assistant', 'Database Clerk'],
    ];

    // Special combinations (manual mapping)
    $comboMapping = [
        'AE' => ['Creative Marketing', 'Brand Assistant', 'Digital Media Designer'],
        'IS' => ['EdTech Research', 'Psychology Research Intern'],
        'RC' => ['Quality Control Support', 'Industrial Operations Intern'],
        'IE' => ['Tech Entrepreneurship', 'Startup Product Intern'],
        'AS' => ['Educational Content UI/UX', 'Community Arts Coordinator'],
        // You can add more special combos here
    ];

    // Step 1: Check if exact combo exists in special mapping
    if (isset($comboMapping[$type])) {
        return $comboMapping[$type];
    }

    // Step 2: Otherwise, dynamically merge single-type recommendations
    $types = str_split($type);
    $internships = [];

    foreach ($types as $t) {
        if (isset($singleMapping[$t])) {
            $internships = array_merge($internships, $singleMapping[$t]);
        }
    }

    // Step 3: Remove duplicates
    $internships = array_unique($internships);

    // Step 4: Fallback if no mapping found
    if (empty($internships)) {
        $internships = ['General Internship Opportunities'];
    }

    return $internships;
}
}
