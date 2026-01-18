@extends('layouts.app')
@section('title', 'Edit Question')
@section('content')
<h2 class="text-xl font-bold mb-4">✏️ Edit Question</h2>

<form method="POST" action="{{ route('personality.update', $id) }}">
    @csrf

    <label class="block mb-2 font-semibold">Question:</label>
    <input type="text" name="question"
           value="{{ $question['question'] }}"
           class="w-full p-2 border mb-4" required>

    <h3 class="font-semibold mb-2">Options</h3>

    @foreach(['A','B','C','D'] as $letter)
        <div class="mb-3 p-3 border rounded bg-gray-50">
            <label class="font-semibold">Option {{ $letter }}</label>

            <input type="text" name="{{ $letter }}_text"
                   value="{{ $question['options'][$letter]['text'] }}"
                   class="w-full p-2 border mb-2" required>

            <label>Personality Type</label>
            <select name="{{ $letter }}_type" class="w-full p-2 border" required>
                @foreach(['R','I','A','S','E','C'] as $t)
                    <option value="{{ $t }}"
                        {{ $question['options'][$letter]['type'] == $t ? 'selected' : '' }}>
                        {{ $t }}
                    </option>
                @endforeach
            </select>
        </div>
    @endforeach

    <button class="px-4 py-2 bg-blue-600 text-white rounded">
        Update Question
    </button>
</form>
@endsection
