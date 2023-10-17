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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 text-gray-900">

                {{-- info profile data required  --}}
                <div id="alert-additional-content-1" class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-sm font-medium">Profile Data Required</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        Please fill out your profile data before submitting a proposal. Your profile data is required to complete the submission process.
                    </div>
                    <div class="sm:flex">
                        <a type="button" href="{{ route('profile.edit') }}" class="text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-xs px-3 py-1.5 mr-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="-ml-0.5 mr-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14"><path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg>
                            Fill Profile Data
                        </a>
                        <button type="button" class="text-blue-800 bg-transparent border border-blue-800 hover:bg-blue-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-blue-600 dark:border-blue-600 dark:text-blue-400 dark:hover:text-white dark:focus:ring-blue-800" data-dismiss-target="#alert-additional-content-1" aria-label="Close">
                            Dismiss
                        </button>
                    </div>
                </div>

                {{-- main jumbutron --}}
                <div class="relative bg-center bg-cover bg-gradient-to-br from-blue-200 to-blue-400 dark:from-gray-700 dark:to-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12 mb-8" style="background-image: url('/assets/img/jumbutron.jpg');">
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

                <div class="grid md:grid-cols-2 gap-8">

                    @if (auth()->user()->hasRole('student'))
                        {{-- menu submit proposal --}}
                        <div class="relative bg-cover bg-center bg-gradient-to-br from-green-200 to-green-400 dark:from-gray-700 dark:to-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12" style="background-image: url('/assets/img/main1.jpg');">
                            <a href="{{ route('submit-proposal.read') }}" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 mb-2">
                                <svg class="w-2.5 h-2.5 mr-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18"><path d="M17 11h-2.722L8 17.278a5.512 5.512 0 0 1-.9.722H17a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM6 0H1a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V1a1 1 0 0 0-1-1ZM3.5 15.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM16.132 4.9 12.6 1.368a1 1 0 0 0-1.414 0L9 3.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z"/></svg>
                                Submit Proposal
                            </a>
                            <h2 class="text-gray-900 dark:text-white text-3xl font-extrabold mb-2">Submit Proposal with Si Panjul</h2>
                            <p class="text-lg font-normal text-gray-900 dark:text-gray-400 mb-4">Submit your proposal title and make it ready for submission to your lecturers.</p>
                            <a href="{{ route('submit-proposal.read') }}" class="text-blue-600 dark:text-blue-500 hover:underline font-medium text-lg inline-flex items-center">
                                Read more
                                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                            </a>
                        </div>
                    @elseif (auth()->user()->hasRole('coordinator'))
                        {{-- menu check proposal --}}
                        <div class="relative bg-cover bg-center bg-gradient-to-br from-green-200 to-green-400 dark:from-gray-700 dark:to-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12" style="background-image: url('/assets/img/main1.jpg');">
                            <a href="{{ route('check-proposal.read') }}" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 mb-2">
                                <svg class="w-2.5 h-2.5 mr-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18"><path d="M17 11h-2.722L8 17.278a5.512 5.512 0 0 1-.9.722H17a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM6 0H1a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V1a1 1 0 0 0-1-1ZM3.5 15.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM16.132 4.9 12.6 1.368a1 1 0 0 0-1.414 0L9 3.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z"/></svg>
                                Check Student Proposals
                            </a>
                            <h2 class="text-gray-900 dark:text-white text-3xl font-extrabold mb-2">Check Student Proposals with Si Panjul</h2>
                            <p class="text-lg font-normal text-gray-900 dark:text-gray-400 mb-4">Review and assess students' proposal titles to ensure quality and originality.</p>
                            <a href="{{ route('check-proposal.read') }}" class="text-blue-600 dark:text-blue-500 hover:underline font-medium text-lg inline-flex items-center">
                                Read more
                                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                            </a>
                        </div>
                        
                    @endif
                    
                    {{-- menu check similarity --}}
                    <div class="relative bg-cover bg-center bg-gradient-to-br from-yellow-200 to-yellow-400 dark:from-gray-700 dark:to-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12" style="background-image: url('/assets/img/main2.jpg');">
                        <a href="{{ route('similarity.check') }}" class="bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-yellow-400 mb-2">
                            <svg class="w-2.5 h-2.5 mr-1.5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 17 20"><path d="M7.958 19.393a7.7 7.7 0 0 1-6.715-3.439c-2.868-4.832 0-9.376.944-10.654l.091-.122a3.286 3.286 0 0 0 .765-3.288A1 1 0 0 1 4.6.8c.133.1.313.212.525.347A10.451 10.451 0 0 1 10.6 9.3c.5-1.06.772-2.213.8-3.385a1 1 0 0 1 1.592-.758c1.636 1.205 4.638 6.081 2.019 10.441a8.177 8.177 0 0 1-7.053 3.795Z"/></svg>
                           Check Similarity
                        </a>
                        <h2 class="text-gray-900 dark:text-white text-3xl font-extrabold mb-2">Best react libraries around the web</h2>
                        <p class="text-lg font-normal text-gray-900 dark:text-gray-400 mb-4">Check the similarity of your proposal title with the Google Scholar API to ensure its uniqueness.</p>
                        <a href="{{ route('similarity.check') }}" class="text-blue-600 dark:text-blue-500 hover:underline font-medium text-lg inline-flex items-center">
                            Read more
                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

