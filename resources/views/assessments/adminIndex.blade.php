@extends('layouts.app')
@section('title', 'Personality Questions')
@section('content')
@php
    $role = $role ?? session('role', 'guest'); // fallback if not passed
    $btnColor = $role === 'admin' ? 'bg-blue-600' : 'bg-green-600';
    $editColor = $role === 'admin' ? 'text-blue-600' : 'text-green-600';
@endphp

<div class="p-6 bg-white rounded-lg shadow-md">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Personality Questions</h2>
        <a href="{{ route('personality.create') }}" class="{{ $btnColor }} text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition">
            + Add New Question
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">No</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Question</th>
                    <th class="px-4 py-2 text-center text-gray-700 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($questions as $id => $q)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 text-gray-700 text-center">{{ $q['number'] ?? '-' }}</td>
                    <td class="px-4 py-2 text-gray-800">{{ $q['question'] }}</td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('personality.edit', $id) }}" class="{{ $editColor }} font-medium hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('personality.delete', $id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 font-medium hover:underline">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                        No questions found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
