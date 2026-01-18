<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class GuidelineController extends Controller
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

    public function index()
    {
        $guidelines = $this->db->getReference('guidelines')->getValue();
        return view('guidelines.index', compact('guidelines'));
    }

    public function create()
    {
        if (!in_array(session('role'), ['admin', 'coordinator'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        return view('guidelines.create');
    }

    public function store(Request $request)
    {
        if (!in_array(session('role'), ['admin', 'coordinator'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'sections' => 'required|array',
            'sections.*.heading' => 'required|string',
            'sections.*.content' => 'required|string',
        ]);

        $this->db->getReference('guidelines')->push([
            'title' => $request->title,
            'sections' => $request->sections, // ✅ THIS IS THE KEY
        ]);

        return redirect()
            ->route('guidelines.index')
            ->with('success', 'New guideline added!');
    }

    public function edit($id)
    {
        if (!in_array(session('role'), ['admin', 'coordinator'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $guideline = $this->db->getReference('guidelines/' . $id)->getValue();

        if (!$guideline) {
            abort(404);
        }

        return view('guidelines.edit', compact('guideline', 'id'));
    }

    public function update(Request $request, $id)
    {
        if (!in_array(session('role'), ['admin', 'coordinator'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'sections' => 'required|array',
            'sections.*.heading' => 'required|string',
            'sections.*.content' => 'required|string',
        ]);

        $this->db->getReference('guidelines/' . $id)->update([
            'title' => $request->title,
            'sections' => $request->sections,
        ]);

        return redirect()
            ->route('guidelines.index')
            ->with('success', 'Guideline updated!');
    }

    public function destroy($id)
    {
        if (!in_array(session('role'), ['admin', 'coordinator'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $this->db->getReference('guidelines/' . $id)->remove();

        return redirect()->back()->with('success', 'Guideline deleted!');
    }
}
