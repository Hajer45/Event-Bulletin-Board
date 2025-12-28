<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import Events from XML') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Upload Form -->
                    <form method="POST" action="{{ route('events.process-import') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div>
                            <label for="xml_file" class="block font-medium text-sm text-gray-700">
                                Select XML File <span class="text-red-500">*</span>
                            </label>
                            <input id="xml_file" name="xml_file" type="file" accept=".xml" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100" required>
                            @error('xml_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- XML Format Documentation -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">XML Format Example:</h3>
                            <pre class="text-xs bg-gray-800 text-gray-100 p-4 rounded overflow-x-auto"><code>&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;events&gt;
  &lt;event&gt;
    &lt;title&gt;Event Title&lt;/title&gt;
    &lt;description&gt;Event Description&lt;/description&gt;
    &lt;location&gt;Event Location&lt;/location&gt;
    &lt;event_date&gt;2025-12-31 18:00:00&lt;/event_date&gt;
    &lt;registration_deadline&gt;2025-12-30 23:59:59&lt;/registration_deadline&gt;
    &lt;max_participants&gt;100&lt;/max_participants&gt;
    &lt;status&gt;published&lt;/status&gt;
  &lt;/event&gt;
&lt;/events&gt;</code></pre>
                            <p class="mt-2 text-sm text-gray-600">
                                <strong>Note:</strong> <code
                                    class="bg-gray-200 px-1 rounded">registration_deadline</code> and
                                <code class="bg-gray-200 px-1 rounded">max_participants</code> are optional.
                            </p>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('events.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Import Events
                            </button>
                        </div>
                    </form>

                    <!-- Export Link -->
                    <div class="mt-8 pt-6 border-t">
                        <h3 class="font-semibold text-gray-900 mb-2">Export Your Events</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Download all your events as an XML file for backup or sharing.
                        </p>
                        <a href="{{ route('events.export') }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Export to XML
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>