<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;

class AssessmentController extends Controller
{
    public function create()
    {
        return view('assessments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'type'     => 'required|string',
        ]);

        Assessment::create($request->all());
        return redirect('/assessments')->with('success', 'Assessment question added!');
    }
}
