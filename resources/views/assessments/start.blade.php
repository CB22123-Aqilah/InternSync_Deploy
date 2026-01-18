@extends('layouts.app')

@section('title', 'Start Personality Test')

@section('content')
<h2 class="text-xl font-bold mb-4">Answer All Questions</h2>

<form method="POST" action="{{ route('assessments.submit') }}">
    @csrf

    @foreach($questions as $id => $q)
        <div class="mb-6 p-4 bg-gray-100 rounded border">
            <p class="font-semibold text-gray-800">{{ $q['question'] }}</p>

            @foreach($q['options'] as $key => $opt)
                <label class="block mt-2 cursor-pointer">
                    <input type="radio"
                        name="answers[{{ $id }}]"
                        value="{{ $opt['type'] }}"
                        required>
                    {{ $key }}. {{ $opt['text'] }}
                </label>
            @endforeach
        </div>
    @endforeach

    <button class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700">
        Submit Assessment
    </button>
</form>
@endsection
