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
            <div class="flex gap-4 mb-6">
                <!-- Total Events -->
                <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Events</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->events()->count() }}</p>
                </div>

                <!-- Published Events -->
                <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Published</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ Auth::user()->events()->where('status', 'published')->count() }}
                    </p>
                </div>
            </div>
            <!-- Quick Actions -->
            <div class="mb-6 mt-12">
                <h2 class="text-2xl font-bold text-gray-900">Quick Actions</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                <!-- Browse Events -->
                <a href="{{ route('events.index') }}"
                    class="block bg-white rounded-lg p-4 border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Browse Events</h3>
                    <p class="text-gray-500 text-xs">Explore upcoming events</p>
                </a>

                <!-- Post Event -->
                <a href="{{ route('events.create') }}"
                    class="block bg-white rounded-lg p-4 border border-gray-200 shadow-sm hover:shadow-md hover:border-green-300 hover:bg-green-50 transition-all duration-200 group">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Post Event</h3>
                    <p class="text-gray-500 text-xs">Share your new event</p>
                </a>

                <!-- Manage Events -->
                <a href="{{ route('events.index') }}"
                    class="block bg-white rounded-lg p-4 border border-gray-200 shadow-sm hover:shadow-md hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 group">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Manage Events</h3>
                    <p class="text-gray-500 text-xs">Update your events</p>
                </a>

                <!-- Export XML -->
                <a href="{{ route('events.export') }}"
                    class="block bg-white rounded-lg p-4 border border-gray-200 shadow-sm hover:shadow-md hover:border-orange-300 hover:bg-orange-50 transition-all duration-200 group">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Export XML</h3>
                    <p class="text-gray-500 text-xs">Download event data</p>
                </a>

                <!-- Import XML -->
                <a href="{{ route('events.import') }}"
                    class="block bg-white rounded-lg p-4 border border-gray-200 shadow-sm hover:shadow-md hover:border-cyan-300 hover:bg-cyan-50 transition-all duration-200 group">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center group-hover:bg-cyan-200 transition-colors">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Import XML</h3>
                    <p class="text-gray-500 text-xs">Restore from backup</p>
                </a>

                <!-- Settings -->
                <a href="{{ route('profile.edit') }}"
                    class="block bg-white rounded-lg p-4 border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 group">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Settings</h3>
                    <p class="text-gray-500 text-xs">Manage your profile</p>
                </a>

            </div>

        </div>
    </div>

    <!-- Toast Notification Container -->
    <div x-data="notificationHandler()" x-init="initListener()" class="fixed top-4 right-4 z-50 space-y-2">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-show="notification.show" x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" :class="{
                     'bg-green-500': notification.type === 'created',
                     'bg-blue-500': notification.type === 'updated',
                     'bg-red-500': notification.type === 'deleted'
                 }" class="max-w-sm w-full shadow-lg rounded-lg pointer-events-auto overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg x-show="notification.type === 'created'" class="h-6 w-6 text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <svg x-show="notification.type === 'updated'" class="h-6 w-6 text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <svg x-show="notification.type === 'deleted'" class="h-6 w-6 text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1">
                            <p class="text-sm font-medium text-white" x-text="notification.title"></p>
                            <p class="mt-1 text-sm text-white opacity-90" x-text="notification.message"></p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="removeNotification(notification.id)"
                                class="inline-flex text-white hover:text-gray-200 focus:outline-none">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <script>
        function notificationHandler() {
            return {
                notifications: [],
                notificationId: 0,

                initListener() {
                    // Listen for event created
                    window.Echo.channel('events')
                        .listen('.event.created', (e) => {
                            this.addNotification('created', 'New Event Created', `${e.title} by ${e.user_name}`);
                        })
                        .listen('.event.updated', (e) => {
                            this.addNotification('updated', 'Event Updated', `${e.title} has been updated`);
                        })
                        .listen('.event.deleted', (e) => {
                            this.addNotification('deleted', 'Event Deleted', `${e.title} has been deleted`);
                        });

                    console.log('Pusher notification listener initialized');
                },

                addNotification(type, title, message) {
                    const id = this.notificationId++;
                    const notification = {
                        id,
                        type,
                        title,
                        message,
                        show: true
                    };

                    this.notifications.push(notification);

                    // Auto-remove after 5 seconds
                    setTimeout(() => {
                        this.removeNotification(id);
                    }, 5000);
                },

                removeNotification(id) {
                    const index = this.notifications.findIndex(n => n.id === id);
                    if (index !== -1) {
                        this.notifications[index].show = false;
                        setTimeout(() => {
                            this.notifications.splice(index, 1);
                        }, 200);
                    }
                }
            }
        }
    </script>
</x-app-layout>