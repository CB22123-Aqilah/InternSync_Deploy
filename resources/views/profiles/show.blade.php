@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Page Header -->
    <div class="mb-5">
        <h2 class="text-xl font-semibold text-slate-800">
            Student Profile
        </h2>
        <p class="text-sm text-slate-500 mt-1">
            Detailed information of the selected student
        </p>
    </div>

    <!-- Profile Card -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 md:p-7">

    <!-- Basic Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Name -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                Full Name
            </label>
            <div class="px-4 py-2.5 bg-slate-50 rounded-md text-slate-800">
                {{ $profile['name'] ?? 'N/A' }}
            </div>
        </div>

        <!-- Email -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                Email Address
            </label>
            <div class="px-4 py-2.5 bg-slate-50 rounded-md text-slate-800">
                {{ $profile['email'] ?? 'N/A' }}
            </div>
        </div>

        <!-- Phone -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                Phone Number
            </label>
            <div class="px-4 py-2.5 bg-slate-50 rounded-md text-slate-800">
                {{ $profile['profile']['phone'] ?? 'N/A' }}
            </div>
        </div>

        <!-- Address -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                Address
            </label>
            <div class="px-4 py-2.5 bg-slate-50 rounded-md text-slate-800">
                @php
                    $address = $profile['profile']['address'] ?? 'N/A';
                    if (is_array($address)) {
                        $address = implode(', ', $address); // convert array to string
                    }
                @endphp
                {{ $address }}
            </div>
        </div>

        <!-- Programme -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                Programme
            </label>
            <div class="px-4 py-2.5 bg-slate-50 rounded-md text-slate-800">
                {{ $profile['profile']['programme'] ?? 'N/A' }}
            </div>
        </div>

    </div>

    <!-- Divider -->
    <hr class="my-6">

    <!-- Academic Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- CGPA -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                CGPA
            </label>
            <div class="px-4 py-2.5 bg-slate-50 rounded-md text-slate-800">
                {{ $profile['profile']['cgpa'] ?? 'N/A' }}
            </div>
        </div>

        <!-- Year / Semester -->
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">
                Year of Study
            </label>
            <div class="px-4 py-2.5 bg-slate-50 rounded-md text-slate-800">
                {{ $profile['profile']['year_of_study'] ?? 'N/A' }}
            </div>
        </div>

    </div>

</div>

<!-- Action -->
<div class="mt-8 flex justify-end space-x-2">
    @if(session('role') === 'admin' || session('role') === 'coordinator')
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center px-4 py-2 rounded-md bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200">
            Back
        </a>
    @endif

    @if(session('role') === 'student')
        <a href="{{ route('profile.edit') }}"
           class="inline-flex items-center px-4 py-2 rounded-md bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200">
            Edit Profile
        </a>
    @endif
</div>

    </div>

</div>
@endsection
