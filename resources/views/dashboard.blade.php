@extends('layouts.admin')

@section('breadcrumb')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-3 mt-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Dashboard</span>
                </div>
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="mx-6 bg-white p-4 pb-0 rounded-lg dark:border-gray-700 overflow-hidden shadow-sm rounded-lg">
        {{-- jumbutron --}}
        <div class="relative bg-center bg-cover bg-gradient-to-br from-blue-200 to-blue-400 dark:from-gray-700 dark:to-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12 mb-4" style="background-image: url('/assets/img/jumbutron.jpg');">
            <a href="#" class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-blue-400 mb-2">
                <svg class="w-2.5 h-2.5 mr-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                    <path d="M11 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm8.585 1.189a.994.994 0 0 0-.9-.138l-2.965.983a1 1 0 0 0-.685.949v8a1 1 0 0 0 .675.946l2.965 1.02a1.013 1.013 0 0 0 1.032-.242A1 1 0 0 0 20 12V2a1 1 0 0 0-.415-.811Z"/>
                </svg>
                Quick Guide
            </a>
            <h1 class="text-gray-100 dark:text-white text-3xl md:text-5xl font-extrabold mb-2">Submit & Compare Proposal Titles</h1>
            <p class="text-lg font-normal text-gray-100 dark:text-gray-200 mb-6">Welcome to our platform! We've made it super simple for you to submit your proposal titles to your lecturers and check the similarity of your titles using the Google Scholar API.</p>
            <a href="#" class="inline-flex justify-center items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover-bg-blue-800 focus-ring-4 focus-ring-blue-300 dark:focus-ring-blue-900">
                Learn More
                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        </div>
        @if (auth()->user()->hasRole('kaprodi') || auth()->user()->hasRole('coordinator'))
        {{-- users & assignment advisor --}}
        <div class="lg:grid lg:grid-cols-2 gap-4 lg:mb-4">
            <div class="mb-4 bg-white overflow-x-auto rounded-lg shadow rounded-lg">
                <div class="p-6 m-20 bg-white">
                    {!! $usersChart->container() !!}
                </div>
            </div>
            <div class="mb-4 bg-white overflow-x-auto rounded-lg shadow rounded-lg">
                <div class="p-6 m-20 bg-white">
                    {!! $studentAdvisorAssignmentChart->container() !!}
                </div>
            </div>
        </div>
        @endif
        {{-- proposal --}}
        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg mb-4">
            <div class="p-6 m-20 bg-white">
                {!! $proposalsChart->container() !!}
            </div>
        </div>
        {{-- lecturer gender & students gender --}}
        <div class="lg:grid lg:grid-cols-2 gap-4">
            <div class="mb-4 bg-white overflow-x-auto rounded-lg shadow rounded-lg">
                <div class="p-6 m-20 bg-white">
                    {!! $lecturersChart->container() !!}
                </div>
            </div>
            <div class="mb-4 bg-white overflow-x-auto rounded-lg shadow rounded-lg">
                <div class="p-6 m-20 bg-white">
                    {!! $studentsChart->container() !!}
                </div>
            </div>
        </div>
    </div>                                        
@endsection

@push('scripts')
    <script src="{{ $lecturersChart->cdn() }}"></script>
    {{ $lecturersChart->script() }}

    <script src="{{ $studentsChart->cdn() }}"></script>
    {{ $studentsChart->script() }}

    <script src="{{ $usersChart->cdn() }}"></script>
    {{ $usersChart->script() }}

    <script src="{{ $proposalsChart->cdn() }}"></script>
    {{ $proposalsChart->script() }}

    <script src="{{ $studentAdvisorAssignmentChart->cdn() }}"></script>
    {{ $studentAdvisorAssignmentChart->script() }}
@endpush
