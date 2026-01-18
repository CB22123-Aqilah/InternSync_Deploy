@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Page Title -->
    <div class="mb-4">
        <h2 class="text-xl font-semibold text-slate-800">
            @if($viewType === 'coordinator')
                Registered Students (Coordinator View)
            @elseif($viewType === 'admin')
                Registered Students (Admin View)
            @else
                Students
            @endif
        </h2>
        <p class="text-sm text-slate-500 mt-1">
            List of students registered in the system
        </p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 md:p-6">

        @if(empty($profiles))
            <div class="text-center text-slate-500 py-10">
                No students found.
            </div>
        @else

        <!-- Table Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 text-sm">
                        <th class="px-4 py-3 text-left font-medium w-12">#</th>
                        <th class="px-4 py-3 text-left font-medium">Name</th>
                        <th class="px-4 py-3 text-left font-medium">Email</th>
                        <th class="px-4 py-3 text-left font-medium w-40">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @php $i = 1; @endphp
                    @foreach($profiles as $uid => $student)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 text-sm text-slate-500">
                            {{ $i++ }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-800">
                                {{ $student['name'] ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $student['email'] ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($viewType === 'coordinator')
                                <a href="{{ route('coordinator.students.view', $uid) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-md bg-blue-50 text-blue-700 text-sm font-medium hover:bg-blue-100">
                                    View Profile
                                </a>
                            @elseif($viewType === 'admin')
                                <a href="{{ route('admin.students.view', $uid) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-md bg-blue-50 text-blue-700 text-sm font-medium hover:bg-blue-100">
                                    View Profile
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif
    </div>

</div>
@endsection
