@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

{{-- ================= PAGE HEADER ================= --}}
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
    <p class="text-sm muted">System overview & guideline management</p>
</div>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">

    <div class="card p-5">
        <div class="text-sm muted mb-1">Registered Students</div>
        <div class="text-3xl font-bold">{{ $studentsCount }}</div>
    </div>

    <div class="card p-5">
        <div class="text-sm muted mb-1">Coordinators</div>
        <div class="text-3xl font-bold">{{ $coordinatorsCount }}</div>
    </div>

    <div class="card p-5">
        <div class="text-sm muted mb-1">Total Internships</div>
        <div class="text-3xl font-bold">{{ $totalInternships }}</div>
    </div>

    <div class="card p-5">
        <div class="text-sm muted mb-1">Approved Internships</div>
        <div class="text-3xl font-bold">{{ $approvedInternships }}</div>
    </div>

    <div class="card p-5">
        <div class="text-sm muted mb-1">Pending Internships</div>
        <div class="text-3xl font-bold">{{ $pendingInternships }}</div>
    </div>

</div>


{{-- ================= ACTIONS ================= --}}
<div class="flex flex-wrap gap-3 mb-8">
    <a href="{{ route('admin.coordinators.create') }}"
       class="btn-accent px-4 py-2 rounded-lg font-medium shadow-sm">
        + Create Coordinator
    </a>
</div>

{{-- ================= GUIDELINE MANAGEMENT ================= --}}
<div class="card p-6">

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-lg font-semibold">Internship Guidelines</h2>
            <p class="text-sm muted">Manage internship rules & instructions</p>
        </div>
    </div>
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('guidelines.create') }}"
            class="btn-accent px-4 py-2 rounded-lg font-medium shadow-sm">
                + Add Guideline
        </a>
    </div>
    {{-- GUIDELINE LIST --}}
    @php
        $guidelines = $guidelines ?? [];
    @endphp

    @if(empty($guidelines))
        <p class="text-sm muted">No guidelines available.</p>
    @else
        <div class="space-y-6">
            @foreach($guidelines as $id => $guide)
                <div class="border rounded-xl p-5 bg-white shadow-sm">

                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold">
                            {{ $guide['title'] }}
                        </h3>

                        <div class="flex gap-2">
                            <a href="{{ route('guidelines.edit', $id) }}"
                            class="px-3 py-1 text-sm rounded border">
                                Edit
                            </a>

                            <form action="{{ route('guidelines.destroy', $id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this guideline?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 text-sm rounded border">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Sections --}}
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
