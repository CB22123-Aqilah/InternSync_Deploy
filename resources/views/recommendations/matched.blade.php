@extends('layouts.app')

@section('title', 'Matched Internship Opportunities')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">
        Internship Opportunities Matching Your Profile
    </h2>

    @if(count($opportunities) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($opportunities as $item)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-6 flex flex-col justify-between">
                    <h2 class="text-lg font-bold break-words whitespace-normal">
                        {{ $item['internship_title'] ?? 'Internship Position' }}
                    </h2>

                    <p class="break-words whitespace-normal">
                        <strong>Company:</strong>
                        <span class="break-words whitespace-normal">
                            {{ $item['company_name'] ?? '-' }}
                        </span>
                    </p>

                    <p class="break-words whitespace-normal">
                        <strong>Industry:</strong>
                        <span class="break-words whitespace-normal">
                            {{ $item['industry_type'] ?? '-' }}
                        </span>
                    </p>

                    <a href="{{ route('recommendations.show', $item['id']) }}"
                       class="text-blue-600 underline text-sm">
                        View Details
                    </a>
                </div>
            @endforeach
        </div>
        <!-- Back Button -->
        <div class="pt-6 border-t">
            <a href="{{ route('recommendations.index') }}"
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium">
                ← Back to List
            </a>
        </div>
    @else
        <p class="text-gray-500 mt-6">
            No approved internship opportunities match your profile at this time.
        </p>
    @endif
</div>
@endsection
