@extends('layouts.app')

@section('title', 'Internship Recommendations')

@section('content')
<div class="p-6">

    <h3 class="text-3xl font-bold text-center text-gray-800 mb-8">
        Internship Offers from Industries
    </h3>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 text-center font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if(in_array($role, ['student']))
    <div class="mt-8 flex justify-end gap-y-2">
        <a href="{{ route('recommendations.matched') }}"
        class="inline-flex items-center px-4 py-2 my-2 rounded-md
                bg-blue-300 text-black text-sm font-medium
                hover:bg-blue-400 transition shadow-sm">
            View Matching Internship Opportunities
        </a>
    </div>
    @endif

    @if(!empty($internship_industries))
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            @foreach($internship_industries as $item)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition 
            p-6 flex flex-col justify-between 
            overflow-hidden break-words">

                <div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">{{ $item['internship_title'] }}</h4>
                    <p class="text-gray-600 mb-1"><span class="font-medium">Company:</span> {{ $item['company_name'] ?? '-' }}</p>
                    <p class="text-gray-600 mb-1"><span class="font-medium">Industry:</span> {{ $item['industry_type'] ?? '-' }}</p>
                    <p class="text-gray-600 mb-1"><span class="font-medium">Location:</span> {{ $item['location'] ?? '-' }}</p>
                    <p class="text-gray-600 mb-1"><span class="font-medium">Duration:</span> {{ $item['duration'] ?? '-' }}</p>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @if(($item['status'] ?? 'pending') === 'approved') bg-green-100 text-green-800
                        @elseif(($item['status'] ?? '') === 'rejected') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $item['status'] ?? 'pending' }}
                    </span>

                    @if(in_array($role, ['admin','coordinator']))
                        <a href="{{ route('recommendations.show', $item['id']) }}" 
                           class="bg-blue-600 text-white px-4 py-1 rounded-md hover:bg-blue-700 transition">
                            Review
                        </a>
                    @endif
                </div>

            </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 py-10 text-lg">No internship records found.</p>
    @endif

</div>
@endsection
