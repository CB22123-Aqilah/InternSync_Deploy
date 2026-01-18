@extends('layouts.app')

@section('title', 'Guest Dashboard')

@section('content')
    <h2 class="text-2xl font-bold mb-4 text-center">🌐 Internship Opportunities</h2>

    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('guest.form') }}" 
           class="btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           + Add New Internship
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(!empty($recommendations))
        <div class="overflow-x-auto">
            <table class="table-auto w-full border border-gray-300 text-sm">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="px-4 py-2">Company Name</th>
                        <th class="px-4 py-2">Industry</th>
                        <th class="px-4 py-2">Internship Title</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Duration</th>
                        <th class="px-4 py-2">Contact</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recommendations as $rec)
                        <tr class="border-b hover:bg-blue-50">
                            <td class="px-4 py-2">{{ $rec['company_name'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $rec['industry_type'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $rec['internship_title'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $rec['internship_description'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $rec['location'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $rec['duration'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $rec['contact_email'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-gray-500 mt-6">No internship offers available yet.</p>
    @endif
@endsection
