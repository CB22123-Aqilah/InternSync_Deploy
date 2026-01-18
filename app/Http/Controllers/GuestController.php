<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use Kreait\Firebase\Factory;

class GuestController extends Controller
{
    protected $database;
    protected $table = 'internship_industries';


    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path('firebase_credentials.json'))
            ->withDatabaseUri('https://internsync-8baad-default-rtdb.asia-southeast1.firebasedatabase.app/');
        $this->database = $firebase->createDatabase();
    }

    // Show the form page
    public function create()
    {
        return view('guest.form');
    }

    // Store the submitted internship info
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'industry_type' => 'required|string|max:255',
            'contact_email' => 'nullable|email',
            'internship_title' => 'required|string|max:255',
            'internship_description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'duration' => 'nullable|string|max:255',
        ]);

        // Store in Firebase
        $validated['status'] = 'pending';

        $this->database->getReference($this->table)->push($validated);

        return redirect()->route('dashboard.guest')->with('success', 'Internship submitted. Awaiting approval.');
    }
    

}
