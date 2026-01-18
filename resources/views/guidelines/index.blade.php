@extends('layouts.app')

@section('title', 'Guidelines')

@section('content')
<div class="p-6 max-w-5xl mx-auto">

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Add Guideline Button --}}
    @if(session('role') === 'admin' || session('role') === 'coordinator')
        <div class="mb-6">
            <a href="{{ route('guidelines.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Add Guideline
            </a>
        </div>
    @endif

    {{-- Guidelines List --}}
    @if(isset($guidelines) && count($guidelines) > 0)
        <div class="space-y-6">
            @foreach($guidelines as $id => $item)
                <div class="border p-5 bg-white shadow rounded">

                    <h3 class="font-bold text-lg mb-3">
                        {{ $item['title'] }}
                    </h3>

                    {{-- Sections --}}
                    <div class="space-y-3">
                        @foreach($item['sections'] ?? [] as $section)
                            <div class="border-l-4 border-blue-500 pl-3">
                                <h4 class="font-semibold text-sm text-gray-800">
                                    {{ $section['heading'] }}
                                </h4>
                                @php
                                    $lines = preg_split("/\r\n|\n|\r/", $section['content']);
                                @endphp

                                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                    @foreach($lines as $line)
                                        @if(trim($line) !== '')
                                            <li>{{ ltrim($line, '- ') }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                    {{-- Actions --}}
                    @if(session('role') === 'admin' || session('role') === 'coordinator')
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('guidelines.edit', $id) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form action="{{ route('guidelines.destroy', $id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No guidelines available.</p>
    @endif

</div>
@endsection
