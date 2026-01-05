<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Events') }}
            </h2>
            @auth
                <a href="{{ route('events.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Create Event
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($events->count() > 0)
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($events as $event)
                                <div class="border rounded-lg p-6 hover:shadow-lg transition">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        {{ $event->title }}
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                        {{ $event->description }}
                                    </p>

                                    <div class="space-y-2 text-sm text-gray-500 mb-4">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ $event->formatted_event_date }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $event->location }}
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('events.show', $event) }}"
                                            class="text-indigo-600 hover:text-indigo-800 font-medium">
                                            View Details →
                                        </a>

                                        @auth
                                            @if($event->isOwnedBy(auth()->user()))
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                    Your Event
                                                </span>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $events->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No events</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new event.</p>
                            @auth
                                <div class="mt-6">
                                    <a href="{{ route('events.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                        Create Event
                                    </a>
                                </div>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>