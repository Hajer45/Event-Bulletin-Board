<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Event Details -->
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $event->title }}</h3>

                        <!-- Status Badge -->
                        <div class="mb-4">
                            @if($event->status === 'published')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Published
                                </span>
                            @elseif($event->status === 'draft')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Draft
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Cancelled
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="prose max-w-none mb-6">
                            <p class="text-gray-700 whitespace-pre-line">{{ $event->description }}</p>
                        </div>

                        <!-- Event Info Grid -->
                        <div class="grid md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg">
                            <div>
                                <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Event Date
                                </h4>
                                <p class="text-gray-600">{{ $event->formatted_event_date }}</p>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Location
                                </h4>
                                <p class="text-gray-600">{{ $event->location }}</p>
                            </div>

                            @if($event->registration_deadline)
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Registration Deadline
                                    </h4>
                                    <p class="text-gray-600">{{ $event->formatted_registration_deadline }}</p>
                                </div>
                            @endif

                            @if($event->max_participants)
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        Max Participants
                                    </h4>
                                    <p class="text-gray-600">{{ $event->max_participants }}</p>
                                </div>
                            @endif

                            <div>
                                <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Organizer
                                </h4>
                                <p class="text-gray-600">{{ $event->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between border-t pt-6">
                        <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-900">
                            ← Back to Events
                        </a>

                        @auth
                            @can('update', $event)
                                <div class="flex gap-4">
                                    <a href="{{ route('events.edit', $event) }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                        Edit Event
                                    </a>

                                    <form method="POST" action="{{ route('events.destroy', $event) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this event?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                            Delete Event
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>