<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class RecommendationController extends Controller
{
    protected $database;
    protected $table = 'internship_industries';

    public function __construct()
    {
        // ✅ Initialize Firebase manually using your credential path
        $firebase = (new Factory)
            ->withServiceAccount(base_path('firebase_credentials.json'))
            ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->database = $firebase->createDatabase();
    }

    private function getCurrentRole()
    {
        if (session()->has('role')) {
            return session('role');
        }

        return 'guest';
    }

    // 📋 Coordinator / Admin — View all submitted internship forms
    public function index()
    {
        $role = $this->getCurrentRole();

        $internship_industries = $this->database
            ->getReference($this->table)
            ->getValue() ?? [];

        $data = [];

        foreach ($internship_industries as $id => $item) {

            // 🎓 STUDENT: only approved
            if ($role === 'student') {
                if (!isset($item['status']) || $item['status'] !== 'approved') {
                    continue;
                }
            }

            // Admin / Coordinator: see all
            $item['id'] = $id;
            $data[] = $item;
        }

        return view('recommendations.index', [
            'internship_industries' => $data,
            'role' => $role
        ]);
    }

    // 🧭 Guest dashboard — View all internship offers (no login)
    public function guestDashboard()
    {
        $recommendations = $this->database
            ->getReference($this->table)
            ->getValue() ?? [];

        // ✅ ONLY APPROVED
        $recommendations = array_filter($recommendations, function ($item) {
            return isset($item['status']) && $item['status'] === 'approved';
    });

    $recommendations = array_values($recommendations);

    return view('dashboard.guest', compact('recommendations'));
    }


    // 🔍 View details of a specific recommendation
    public function show($id)
    {
        $role = session('role', 'guest');

        $recommendation = $this->database
            ->getReference($this->table.'/'.$id)
            ->getValue();

        if (!$recommendation) {
            abort(404);
        }

        $recommendation['id'] = $id;

        return view('recommendations.show', [
            'recommendation' => $recommendation,
            'role' => $role
        ]);
    }

    public function approve($id)
    {
        if (!in_array(session('role'), ['admin', 'coordinator'])) {
            abort(403);
        }

        $this->database
            ->getReference($this->table.'/'.$id.'/status')
            ->set('approved');

        return redirect()->route('recommendations.index')
            ->with('success', 'Internship approved');
    }

    // Reject submission (Admin / Coordinator)
    public function reject($id)
    {
        if (!in_array(session('role'), ['admin', 'coordinator'])) {
            abort(403);
        }

        $this->database
            ->getReference($this->table.'/'.$id.'/status')
            ->set('rejected');

        return redirect()->route('recommendations.index')
            ->with('success', 'Internship rejected');
    }

    // 🎯 Student — View matched internship opportunities
    public function matchedOpportunities()
    {
        if (session('role') !== 'student') {
            abort(403);
        }

        $uid = session('uid');

        // 🔹 Get student profile
        $studentProfile = $this->database
            ->getReference("users/{$uid}/profile")
            ->getValue() ?? [];

        $studentCourse = strtolower(trim($studentProfile['programme'] ?? ''));

        // 🔹 Get latest personality type
        $answers = $this->database
            ->getReference("personality_answers/{$uid}")
            ->getValue() ?? [];

        $latestKey = !empty($answers) ? array_key_last($answers) : null;
        $personalityType = $latestKey ? ($answers[$latestKey]['type'] ?? null) : null;

        // 🔹 Get approved internships
        $internships = $this->database
            ->getReference($this->table)
            ->getValue() ?? [];

        $courseMap = $this->courseKeywordMap();
        $keywords = $courseMap[$studentCourse] ?? [];

        $matched = [];

        foreach ($internships as $id => $item) {

            // Only approved
            if (($item['status'] ?? '') !== 'approved') {
                continue;
            }

            // Normalize internship text
            $text = strtolower(
                preg_replace('/[^a-z0-9 ]/', ' ',
                    ($item['industry_type'] ?? '') . ' ' .
                    ($item['internship_title'] ?? '') . ' ' .
                    ($item['internship_description'] ?? '')
                )
            );

            $score = 0;

            // 🔹 Course-based scoring
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    $score++;
                }
            }

            // 🔹 Personality-based bonus scoring
            $personalityMap = [
                'R' => ['technical', 'engineer', 'developer', 'system'],
                'I' => ['data', 'analysis', 'research'],
                'A' => ['design', 'creative', 'multimedia'],
            ];

            foreach (str_split($personalityType ?? '') as $p) {
                foreach ($personalityMap[$p] ?? [] as $pKeyword) {
                    if (str_contains($text, $pKeyword)) {
                        $score++;
                    }
                }
            }

            // 🔹 Final decision
            if ($score > 0) {
                $item['id'] = $id;
                $item['match_score'] = $score;
                $matched[] = $item;
            }
        }

        // 🔹 Sort by relevance
        usort($matched, fn($a, $b) => $b['match_score'] <=> $a['match_score']);

        return view('recommendations.matched', [
            'opportunities' => $matched
        ]);
    }

    private function courseKeywordMap()
    {
        return [
            'software engineering' => [
                'software', 'developer', 'programming', 'it', 'system', 'web', 'mobile', 'tester'
            ],
            'computer science' => [
                'data', 'ai', 'machine', 'software', 'system', 'developer'
            ],
            'architecture' => [
                'architecture', 'design', 'drafter', 'assistant'
            ],
            'engineering' => [
                'engineer', 'technician', 'lab', 'maintenance'
            ],
        ];
    }


}
