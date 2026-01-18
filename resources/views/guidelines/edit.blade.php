@extends('layouts.app')

@section('title', 'Edit Guideline')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">

    <h2 class="text-2xl font-semibold mb-6">
        Edit Internship Guideline
    </h2>

    <form action="{{ route('guidelines.update', $id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Guideline Title --}}
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">
                Guideline Title
            </label>
            <input
                type="text"
                name="title"
                value="{{ $guideline['title'] }}"
                required
                class="w-full border rounded-lg px-4 py-3"
            >
        </div>

        {{-- Guideline Sections --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">
                Guideline Sections
            </label>

            <div id="sections" class="space-y-4">
                @foreach($guideline['sections'] ?? [] as $index => $section)
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <input
                            type="text"
                            name="sections[{{ $index }}][heading]"
                            value="{{ $section['heading'] }}"
                            class="w-full mb-2 border p-2 rounded"
                            required
                        >

                        <textarea
                            name="sections[{{ $index }}][content]"
                            rows="6"
                            class="w-full border p-2 rounded resize-y"
                            required
                        >{{ $section['content'] }}</textarea>
                    </div>
                @endforeach
            </div>

            <button type="button"
                    onclick="addSection()"
                    class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                + Add Section
            </button>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('guidelines.index') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg">
                Cancel
            </a>

            <button
                type="submit"
                class="px-5 py-2 bg-green-600 text-white rounded-lg">
                Update Guideline
            </button>
        </div>

    </form>
</div>

<script>
let sectionIndex = {{ count($guideline['sections'] ?? []) }};

function addSection() {
    document.getElementById('sections').insertAdjacentHTML('beforeend', `
        <div class="border rounded-lg p-4 bg-gray-50">
            <input
                type="text"
                name="sections[${sectionIndex}][heading]"
                class="w-full mb-2 border p-2 rounded"
                placeholder="Section Title"
                required
            >

            <textarea
                name="sections[${sectionIndex}][content]"
                rows="6"
                class="w-full border p-2 rounded resize-y"
                required
            ></textarea>
        </div>
    `);

    sectionIndex++;
}
</script>
@endsection
