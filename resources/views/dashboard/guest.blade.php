@extends('layouts.app')

@section('title', 'Guest Dashboard')

@section('content')
    <div class="p-6" style="background: linear-gradient(180deg, #ebffab 30%, #ffffff 75%); min-height: 100vh;">
    <h2 class="text-3xl font-bold mb-6 text-center" style="color: #000000;">🌐 Internship Opportunities</h2>

    <div class="flex justify-end mb-6">
        <a href="{{ route('guest.form') }}" 
           class="px-4 py-2 font-semibold rounded bg-[#dfdf50] text-black hover:bg-[#99f8a8] transition">
           + Add New Internship
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-3 rounded border border-green-300 bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="pt-6 border-t">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium">
                ← Back
            </a>
        </div>

    @if(!empty($recommendations))
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach($recommendations as $rec)
        @php
            $status = $rec['status'] ?? 'pending';
            $statusClasses = [
                'approved' => 'bg-green-100 text-green-800',
                'rejected' => 'bg-red-100 text-red-800',
                'pending' => 'bg-yellow-100 text-yellow-800',
            ];
        @endphp

        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-6 flex flex-col justify-between overflow-hidden break-words">

            <div>
                <h4 class="text-xl font-semibold text-gray-800 mb-2">{{ $rec['internship_title'] ?? '-' }}</h4>
                <p class="text-gray-600 mb-1"><span class="font-medium">Company:</span> {{ $rec['company_name'] ?? '-' }}</p>
                <p class="text-gray-600 mb-1"><span class="font-medium">Industry:</span> {{ $rec['industry_type'] ?? '-' }}</p>
                <p class="text-gray-600 mb-1"><span class="font-medium">Location:</span> {{ $rec['location'] ?? '-' }}</p>
                <p class="text-gray-600 mb-1"><span class="font-medium">Duration:</span> {{ $rec['duration'] ?? '-' }}</p>
                
                <p class="text-gray-600 mb-2">
                    <span class="font-medium">Description:</span>
                    <span class="block max-h-24 overflow-y-auto p-2 border border-gray-200 rounded">
                        {{ $rec['internship_description'] ?? '-' }}
                    </span>
                </p>
                
                <p class="text-gray-600 mb-1"><span class="font-medium">Contact:</span> {{ $rec['contact_email'] ?? '-' }}</p>
            </div>

            <div class="mt-4">
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses[$status] ?? $statusClasses['pending'] }}">
                    {{ ucfirst($status) }}
                </span>
            </div>

        </div>
    @endforeach

</div>
@else
<p class="text-center text-gray-500 py-10 text-lg">No internship offers available yet.</p>
@endif

</div>
@endsection
