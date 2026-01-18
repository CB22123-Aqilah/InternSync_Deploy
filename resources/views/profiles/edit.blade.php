@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Profile</h1>
        <p class="text-gray-500 mt-1">Update your personal information</p>
    </div>

    <!-- Card -->
    <div class="bg-white shadow-md rounded-xl p-8">

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Full Name
                    </label>
                    <input type="text" name="name"
                        value="{{ $profile['name'] ?? '' }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" name="email"
                        value="{{ $profile['email'] ?? '' }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Phone Number
                    </label>
                    <input type="text" name="phone"
                        value="{{ $profile['phone'] ?? '' }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Address
                    </label>
                    <input type="text" name="address"
                        value="{{ $profile['address'] ?? '' }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- Programme -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Programme
                    </label>
                    <input type="text" name="programme"
                        value="{{ $profile['programme'] ?? '' }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- Year of Study -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Year of Study
                    </label>
                    <input type="number" name="year_of_study"
                        value="{{ $profile['year_of_study'] ?? '' }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- CGPA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        CGPA
                    </label>
                    <input type="text" name="cgpa"
                        value="{{ $profile['cgpa'] ?? '' }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('profile.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-md bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200">
                    Cancel
                </a>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200">
                    Save Changes
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
