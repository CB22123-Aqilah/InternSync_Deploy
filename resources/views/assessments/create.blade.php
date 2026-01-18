@extends('layouts.app')
@section('title', 'Add Question')
@section('content')
<h2 class="text-xl font-bold mb-4">➕ Add Personality Question</h2>

<form method="POST" action="{{ route('personality.store') }}">
    @csrf

    <label class="block mb-2 font-semibold">Question:</label>
    <input type="text" name="question" class="w-full p-2 border mb-4" required>

    <h3 class="font-semibold mb-2">Options</h3>

    @foreach(['A','B','C','D'] as $letter)
        <div class="mb-3 p-3 border rounded bg-gray-50">
            <label class="font-semibold">Option {{ $letter }}</label>
            <input type="text" name="{{ $letter }}_text"
                   class="w-full p-2 border mb-2" required>

            <label>Personality Type</label>
            <select name="{{ $letter }}_type" class="w-full p-2 border" required>
                @foreach(['R','I','A','S','E','C'] as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
        </div>
    @endforeach

    <button class="px-4 py-2 bg-green-600 text-white rounded">
        Save Question
    </button>
</form>
@endsection
