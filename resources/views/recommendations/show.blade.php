@extends('layouts.app')

@section('title', 'Recommendation Details')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Page Title -->
    <h1 class="text-3xl font-bold mb-8 flex items-center gap-2">
        🏢 <span>Recommendation Details</span>
    </h1>

    <!-- Details Card -->
    <div class="bg-white shadow-md rounded-xl p-8 space-y-6">

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-sm text-gray-500">Company Name</p>
                <p class="font-semibold text-lg">
                    {{ $recommendation['company_name'] ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Industry Type</p>
                <p class="font-semibold text-lg">
                    {{ $recommendation['industry_type'] ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Internship Title</p>
                <p class="font-semibold text-lg">
                    {{ $recommendation['internship_title'] ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Location</p>
                <p class="font-semibold text-lg">
                    {{ $recommendation['location'] ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Duration</p>
                <p class="font-semibold text-lg">
                    {{ $recommendation['duration'] ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                    {{ ($recommendation['status'] ?? 'pending') === 'approved' ? 'bg-green-100 text-green-700' : 
                       (($recommendation['status'] ?? 'pending') === 'rejected' ? 'bg-red-100 text-red-700' : 
                       'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($recommendation['status'] ?? 'Pending') }}
                </span>
            </div>

        </div>

        <!-- Description -->
        <div>
            <p class="text-sm text-gray-500 mb-1">Description</p>
            <p class="text-gray-700 leading-relaxed">
                {{ $recommendation['internship_description'] }}
            </p>
        </div>

        @if(in_array($role, ['student']))
        <!-- Back Button -->
        <div class="pt-6 border-t">
            <a href="{{ route('recommendations.matched') }}"
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium">
                ← Back to List
            </a>
        </div>
        @endif
    </div>

    <!-- Admin / Coordinator Actions -->
    @if(in_array(session('role'), ['admin', 'coordinator']))
    <div class="mt-8 flex gap-4">

        <form method="POST" action="{{ route('recommendations.approve', $recommendation['id']) }}">
            @csrf
            <button type="submit"
                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                ✅ Approve
            </button>
        </form>

        <form method="POST" action="{{ route('recommendations.reject', $recommendation['id']) }}">
            @csrf
            <button type="submit"
                class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
                ❌ Reject
            </button>
        </form>

    </div>
    @endif

</div>
@endsection
