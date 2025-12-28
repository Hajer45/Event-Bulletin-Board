<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- Hero Section -->
            <div class="mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">
                    Welcome back, {{ explode(' ', Auth::user()->name)[0] }}
                </h1>
                <p class="text-lg text-gray-600">Manage your events effortlessly</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                <!-- Total Events -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Events</p>
                    <p class="text-4xl font-bold text-gray-900">{{ Auth::user()->events()->count() }}</p>
                </div>

                <!-- Published Events -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Published</p>
                    <p class="text-4xl font-bold text-gray-900">
                        {{ Auth::user()->events()->where('status', 'published')->count() }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Quick Actions</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Browse Events -->
                <a href="{{ route('events.index') }}"
                    class="block bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Browse Events</h3>
                    <p class="text-gray-600 text-sm">Explore all upcoming community events</p>
                </a>

                <!-- Post Event -->
                <a href="{{ route('events.create') }}"
                    class="block bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Post Event</h3>
                    <p class="text-gray-600 text-sm">Share your new event with the community</p>
                </a>

                <!-- Manage Events -->
                <a href="{{ route('events.index') }}"
                    class="block bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Manage Events</h3>
                    <p class="text-gray-600 text-sm">Update or modify your existing events</p>
                </a>

                <!-- Export XML -->
                <a href="{{ route('events.export') }}"
                    class="block bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Export XML</h3>
                    <p class="text-gray-600 text-sm">Download a backup of your event data</p>
                </a>

                <!-- Import XML -->
                <a href="{{ route('events.import') }}"
                    class="block bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Import XML</h3>
                    <p class="text-gray-600 text-sm">Restore events from an XML backup file</p>
                </a>

                <!-- Settings -->
                <a href="{{ route('profile.edit') }}"
                    class="block bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Settings</h3>
                    <p class="text-gray-600 text-sm">Manage your account and profile settings</p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>