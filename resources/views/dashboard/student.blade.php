@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')

{{-- ================= PAGE HEADER ================= --}}
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Student Dashboard</h1>
    <p class="text-sm muted">Personality test result & internship guidelines</p>
</div>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">

    {{-- Personality Type --}}
    <div class="card p-5">
        <div class="text-sm muted mb-1">Personality Type</div>
        <div class="text-3xl font-bold">
            {{ $personalityType ?? '-' }}
        </div>
    </div>

    {{-- Recommended Internships --}}
    <div class="card p-5">
        <div class="text-sm muted mb-1">Recommended Internship Fields</div>

        @if(!empty($recommended_internships))
            <ul class="list-disc pl-5 text-sm mt-2">
                @foreach($recommended_internships as $internship)
                    <li>{{ $internship }}</li>
                @endforeach
            </ul>
        @else
            -
        @endif
    </div>

    {{-- Test Status --}}
    <div class="card p-5">
        <div class="text-sm muted mb-1">Personality Test Status</div>
        <div class="text-3xl font-bold">
            {{ $hasTakenTest ? 'Completed' : 'Not Taken' }}
        </div>
    </div>

</div>

{{-- ================= GUIDELINES ================= --}}
<div class="card p-6">

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Internship Guidelines</h2>
        <p class="text-sm muted">Rules & instructions provided by faculty</p>
    </div>

    @if(empty($guidelines))
        <p class="text-sm muted">No guidelines available.</p>
    @else
        <div class="space-y-6">
            @foreach($guidelines as $guide)
                <div class="border rounded-xl p-5 bg-white shadow-sm">

                    <h3 class="text-lg font-semibold mb-3">
                        {{ $guide['title'] }}
                    </h3>

                    @foreach($guide['sections'] ?? [] as $section)
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-700">
                                {{ $section['heading'] }}
                            </h4>

                            <p class="text-sm text-gray-600 whitespace-pre-line mt-1">
                                {{ $section['content'] }}
                            </p>
                        </div>
                    @endforeach

                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
