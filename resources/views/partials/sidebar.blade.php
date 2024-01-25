<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        
        {{-- all menu --}}
        <ul class="space-y-2 font-medium">
            
            {{-- dashboard --}}
            <li>
                <a href="{{ Route('dashboard') }}" class="{{ Request::is('dashboard') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100' }} flex items-center p-2 rounded-lg dark:text-white dark:hover:bg-gray-700">
                    <svg class="{{ Request::is('dashboard') ? 'text-white hover:text-gray-900 hover:text-gray-900' : 'text-gray-500 group-hover:text-gray-900' }} w-4 h-4 transition duration-75 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21"><path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/></svg>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->hasRole('coordinator') || auth()->user()->hasRole('lecturer') || auth()->user()->hasRole('student') || auth()->user()->hasRole('kaprodi'))
                {{-- lists lecturer, student, proposal --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-sm text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-lists" data-collapse-toggle="dropdown-lists">
                        <svg class="flex-shrink-0 w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 10"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 1h10M6 5h10M6 9h10M1.49 1h.01m-.01 4h.01m-.01 4h.01"/></svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Lists & Records</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <ul id="dropdown-lists" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ Route('lecturer.read') }}" class="{{ Request::is('lecturers') || Request::is('lecturers/add') || Request::is('lecturers/*') || Request::is('lecturers/show-project-student/*') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700' }} flex items-center w-full p-2  transition duration-75 rounded-lg pl-11 group">The Lecturers</a>
                        </li>
                        <li>
                            <a href="{{ Route('student.read') }}" class="{{ Request::is('students') || Request::is('students/add') || Request::is('students/*') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700' }} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group">The Students</a>
                        </li>
                        <li>
                            <a href="{{ Route('proposal.read') }}" class="{{ Request::is('proposals') || Request::is('proposals/add') || Request::is('proposals/*') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700' }} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group">All Proposals</a>
                        </li>
                    </ul>
                </li>    
            @endif
            
            @if (auth()->user()->hasRole('coordinator') || auth()->user()->hasRole('kaprodi'))
                {{-- management user & topic --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-sm text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-managing" data-collapse-toggle="dropdown-managing">
                        <svg class="flex-shrink-0 w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18"><path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/></svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Managing</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <ul id="dropdown-managing" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ Route('user.read') }}" class="{{ Request::is('users') || Request::is('users/add') || Request::is('users/*') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700' }} flex items-center w-full p-2  transition duration-75 rounded-lg pl-11 group">User Account</a>
                        </li>
                        <li>
                            <a href="{{ Route('topic.read') }}" class="{{ Request::is('topics') || Request::is('topics/add') || Request::is('topics/*') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700' }} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group">Topics</a>
                        </li>
                    </ul>
                </li>

                {{-- check proposal  --}}
                <li>
                    <a href="{{ Route('check-proposal.read') }}" class="{{ Request::is('submissions') || Request::is('submissions/*') || Request::is('history-submission/*') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100' }} flex items-center p-2 rounded-lg dark:text-white dark:hover:bg-gray-700">
                        <svg class="{{ Request::is('submissions') || Request::is('submissions/*') || Request::is('history-submission/*') ? 'text-white group-hover:text-gray-900' : '' }} flex-shrink-0 w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v2H7V2ZM5 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-4a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm8 4H8a1 1 0 0 1 0-2h5a1 1 0 0 1 0 2Zm0-4H8a1 1 0 0 1 0-2h5a1 1 0 1 1 0 2Z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Check Proposals</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ App\Models\ProposalProcess::whereNull('comment')->whereNotNull('type')->whereNotNull('date')->count() }}</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole('kaprodi'))
                {{--  Assignment Advisor --}}
                <li>
                    <a href="{{ Route('assignment-advisor.read') }}" class="{{ Request::is('list-student-submission') || Request::is('check-student-submission/*') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100' }} flex items-center p-2 rounded-lg dark:text-white dark:hover:bg-gray-700">
                        <svg class="{{ Request::is('list-student-submission') || Request::is('check-student-submission/*') ? 'text-white group-hover:text-gray-900' : '' }} flex-shrink-0 w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Assignment Advisor</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ App\Models\Proposal::where('status', 'on_process')->doesntHave('lecturers')->count() }}
                        </span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole('student'))
                {{-- submit proposals --}}
                <li>
                    <a href="{{ Route('submit-proposal.read')}}" class="{{ Request::is('submit-proposal') || Request::is('submit-proposal/add/*') || Request::is('submit-proposal/similarity/*') || Request::is('submit-proposal/edit/*') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100' }} flex items-center p-2 rounded-lg dark:text-white dark:hover:bg-gray-700">
                        <svg class="{{ Request::is('submit-proposal') || Request::is('submit-proposal/add/*') || Request::is('submit-proposal/similarity/*') || Request::is('submit-proposal/edit/*') ? 'text-white group-hover:text-gray-900' : '' }} flex-shrink-0 w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18.017 15.002h-1.5v-1.5a1 1 0 0 0-2 0v1.5h-1.5a1 1 0 0 0 0 2h1.5v1.5a1 1 0 1 0 2 0v-1.5h1.5a1 1 0 1 0 0-2Z"/><path d="m17.74 4.758-7.476 8.409a1 1 0 0 1-.718.335h-.029a1 1 0 0 1-.707-.293l-4-4a1 1 0 0 1 1.414-1.413l3.25 3.25L16.53 3.11a9.5 9.5 0 1 0-3.885 15.355 2.495 2.495 0 0 1 .373-4.963 2.5 2.5 0 0 1 5 0c.035 0 .068.01.1.01a9.43 9.43 0 0 0-.38-8.754h.002Z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Submit Proposal</span>
                    </a>
                </li>
            @endif
            
            {{-- check similarity --}}
            <li>
                <a href="{{ Route('similarity.check') }}" class="{{ Request::is('similarity') ? 'bg-blue-700 text-white' : 'text-gray-900 hover:bg-gray-100' }} flex items-center p-2 rounded-lg dark:text-white dark:hover:bg-gray-700">
                    <svg class="{{ Request::is('similarity') ? 'text-white' : 'text-gray-500' }} flex-shrink-0 w-4 h-4 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="m7.164 3.805-4.475.38L.327 6.546a1.114 1.114 0 0 0 .63 1.89l3.2.375 3.007-5.006ZM11.092 15.9l.472 3.14a1.114 1.114 0 0 0 1.89.63l2.36-2.362.38-4.475-5.102 3.067Zm8.617-14.283A1.613 1.613 0 0 0 18.383.291c-1.913-.33-5.811-.736-7.556 1.01-1.98 1.98-6.172 9.491-7.477 11.869a1.1 1.1 0 0 0 .193 1.316l.986.985.985.986a1.1 1.1 0 0 0 1.316.193c2.378-1.3 9.889-5.5 11.869-7.477 1.746-1.745 1.34-5.643 1.01-7.556Zm-3.873 6.268a2.63 2.63 0 1 1-3.72-3.72 2.63 2.63 0 0 1 3.72 3.72Z"/></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Check Similarity</span>
                    <span class="{{ Request::is('similarity') ? 'bg-gray-100 text-gray-900' : 'text-gray-800 bg-gray-200' }} inline-flex items-center justify-center px-2 ml-3 text-xs font-medium rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                </a>
            </li>

        </ul>

        {{-- required data profile --}}
        <div id="dropdown-cta" class="p-4 mt-6 rounded-lg bg-blue-50 dark:bg-blue-900" role="alert">
            <div class="flex items-center mb-3">
                <div class="flex items-center text-blue-800">
                    <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-sm font-medium">Profile Data Required</h3>
                </div>
               <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 inline-flex justify-center items-center w-6 h-6 text-blue-900 rounded-lg focus:ring-2 focus:ring-blue-400 p-1 hover:bg-blue-200 h-6 w-6 dark:bg-blue-900 dark:text-blue-400 dark:hover:bg-blue-800" data-dismiss-target="#dropdown-cta" aria-label="Close">
                  <span class="sr-only">Close</span>
                  <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
               </button>
            </div>
            <p class="mb-3 text-sm text-blue-800 dark:text-blue-400">
                To access all menu items, please ensure your profile is complete. Profile completion is required for full access.
            </p>
            <a type="button" href="{{ route('profile.edit') }}" class="text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-xs px-3 py-1.5 mr-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="-ml-0.5 mr-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14"><path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg>
                Fill Profile Data
            </a>
        </div>

    </div>
</aside>
