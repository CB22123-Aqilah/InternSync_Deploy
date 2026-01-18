@extends('layouts.app')

@section('title', 'Personality Test')

@section('content')
<h2 class="text-xl font-bold mb-4">🧠 Personality Test</h2>

@if(session('success'))
    <div class="p-4 mb-4 bg-green-100 border border-green-300 rounded">
        {{ session('success') }}
    </div>
@endif

@if(!empty($latest))
    <div class="p-4 bg-blue-50 border rounded mb-4">
        <p class="font-semibold">Your Last Result:</p>
        <p class="text-lg">Type: <strong>{{ $latest['type'] }}</strong></p>
        <p>Date: {{ $latest['completed_at'] }}</p>
        @if(!empty($latest['recommended_internships']))
            <p>Recommended Internships:</p>
            <ul class="list-disc ml-5">
                @foreach($latest['recommended_internships'] as $intern)
                    <li>{{ $intern }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif

<a href="{{ route('assessments.start') }}"
   class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">
   Start Assessment
</a>
@endsection
