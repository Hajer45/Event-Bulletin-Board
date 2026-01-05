<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Toast Notification Container -->
        <div x-data="notificationHandler()" x-init="initListener()" class="fixed top-4 right-4 z-50 space-y-2">
            <template x-for="notification in notifications" :key="notification.id">
                <div x-show="notification.show" 
                     x-transition:enter="transform ease-out duration-300 transition"
                     x-transition:enter-start="translate-x-full opacity-0" 
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-200" 
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0" 
                     :class="{
                         'bg-green-500': notification.type === 'created',
                         'bg-blue-500': notification.type === 'updated',
                         'bg-red-500': notification.type === 'deleted'
                     }" 
                     class="max-w-sm w-full shadow-lg rounded-lg pointer-events-auto overflow-hidden">
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
                        console.log('🎧 Initializing notification listener...');
                        
                        if (window.Echo) {
                            console.log('✅ Echo is available');
                            
                            window.Echo.channel('events')
                                .listen('.event.created', (e) => {
                                    console.log('✅ Event created received:', e);
                                    this.addNotification('created', 'New Event Created', e.message || `${e.title} by ${e.user_name}`);
                                })
                                .listen('.event.updated', (e) => {
                                    console.log('✅ Event updated received:', e);
                                    this.addNotification('updated', 'Event Updated', e.message || `${e.title} has been updated`);
                                })
                                .listen('.event.deleted', (e) => {
                                    console.log('✅ Event deleted received:', e);
                                    this.addNotification('deleted', 'Event Deleted', e.message || `${e.title} has been deleted`);
                                });

                            console.log('✅ Pusher notification listener initialized');
                        } else {
                            console.error('❌ Echo not available - make sure npm run dev is running');
                        }
                    },

                    addNotification(type, title, message) {
                        console.log('📢 Adding notification:', { type, title, message });
                        
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
    </body>
</html>