@extends('layouts.app')

@section('title', 'Events Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manage Events</h1>
            <p class="text-gray-600">Create and manage your premium events</p>
        </div>
        <a href="{{ route('events.create') }}"
            class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-gradient-to-r from-purple-700 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-purple-700/30 hover:shadow-xl hover:scale-105 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Event
        </a>
    </div>

    <!-- Events Grid -->
    <div id="eventsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Loading State -->
        <div class="col-span-full flex items-center justify-center py-20">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-purple-200 border-t-purple-700 mb-4"></div>
                <p class="text-gray-500">Loading events...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add/Edit Event -->
<div id="eventModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closeModalOnBackdrop(event)">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto transform transition-all" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-gradient-to-r from-purple-700 to-purple-600 px-6 py-5 rounded-t-2xl">
            <h2 id="modalTitle" class="text-2xl font-bold text-white">Add New Event</h2>
        </div>

        <!-- Modal Body -->
        <form onsubmit="saveEvent(event)" class="p-6 space-y-5">
            <!-- Event Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Event Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="eventName"
                    required
                    placeholder="e.g., Corporate Annual Gala"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all outline-none"/>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="eventDescription"
                    required
                    rows="4"
                    placeholder="Describe your event in detail..."
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all outline-none resize-none"></textarea>
            </div>

            <!-- Price -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Price (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                    <input
                        type="number"
                        id="eventPrice"
                        required
                        min="0"
                        step="1000"
                        placeholder="0"
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all outline-none"/>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    class="flex-1 bg-gradient-to-r from-purple-700 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300">
                    Save Event
                </button>
                <button
                    type="button"
                    onclick="closeEventModal()"
                    class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const API_URL = window.location.origin + '/api';
    let editingEventId = null;

    // Get token from session or localStorage
    function getAuthToken() {
        return window.AUTH_TOKEN || localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
    }

    // Check authentication
    function checkAuth() {
        const token = getAuthToken();
        if (!token) {
            console.error('No authentication token found');
            window.location.href = '/';
            return false;
        }
        return true;
    }

    // Load events
    async function loadEvents() {
        const token = getAuthToken();
        const eventsGrid = document.getElementById('eventsGrid');

        try {
            const response = await fetch(`${API_URL}/events`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });

            if (!response.ok) throw new Error('Failed to fetch events');
            const json = await response.json();
            const events = json.data || json || [];

            if (!Array.isArray(events) || events.length === 0) {
                eventsGrid.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center py-20">
                        <svg class="w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No Events Yet</h3>
                        <p class="text-gray-500 mb-6">Start by creating your first event</p>
                        <a href="{{ route('events.create') }}" class="bg-gradient-to-r from-purple-700 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all">
                            Create Event
                        </a>
                    </div>
                `;
                return;
            }

            eventsGrid.innerHTML = events.map(event => `
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group">
                    <!-- Event Image/Icon -->
                    <div class="h-48 bg-gradient-to-br from-purple-100 via-purple-50 to-indigo-50 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-700/10 to-indigo-600/10 group-hover:scale-110 transition-transform duration-500"></div>
                        <svg class="w-20 h-20 text-purple-300 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <!-- Event Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1 line-clamp-1">${event.title || event.name || 'Untitled'}</h3>
                        <p class="text-sm text-gray-500 mb-2">${event.organizer_name || 'Unknown Organizer'}</p>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">${event.description || 'No description'}</p>

                        <!-- Date Badge -->
                        <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold mb-3">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            ${event.start_date ? new Date(event.start_date).toLocaleDateString('id-ID') : 'TBD'}
                        </div>

                        <!-- Status Badge -->
                        <div class="inline-flex ml-2 items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold mb-3 ${
                            event.status === 'published' ? 'bg-green-50 text-green-700' :
                            event.status === 'cancelled' ? 'bg-red-50 text-red-700' :
                            event.status === 'finished' ? 'bg-gray-50 text-gray-700' :
                            'bg-yellow-50 text-yellow-700'
                        }">
                            ${event.status || 'draft'}
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-4 border-t border-gray-100">
                            <a href="/dashboard/events/${event.slug}/edit"
                                class="flex-1 flex items-center justify-center gap-2 bg-purple-50 text-purple-700 py-2.5 rounded-lg font-medium hover:bg-purple-100 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <button
                                onclick="deleteEvent(${event.id})"
                                class="flex-1 flex items-center justify-center gap-2 bg-red-50 text-red-600 py-2.5 rounded-lg font-medium hover:bg-red-100 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');

        } catch (error) {
            console.error('Error loading events:', error);
            eventsGrid.innerHTML = `
                <div class="col-span-full flex flex-col items-center justify-center py-20">
                    <svg class="w-20 h-20 text-red-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Error Loading Events</h3>
                    <p class="text-gray-500 mb-4">${error.message}</p>
                    <button onclick="loadEvents()" class="bg-purple-700 text-white px-6 py-2 rounded-lg hover:bg-purple-800 transition-all">
                        Retry
                    </button>
                </div>
            `;
        }
    }

    // Close modal on backdrop click
    function closeModalOnBackdrop(event) {
        if (event.target.id === 'eventModal') {
            closeEventModal();
        }
    }

    // Close modal
    function closeEventModal() {
        document.getElementById('eventModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Delete event
    async function deleteEvent(id) {
        if (!confirm('Are you sure you want to delete this event?')) return;

        const token = getAuthToken();

        try {
            const res = await fetch(`${API_URL}/events/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': `Bearer ${token}` }
            });

            if (!res.ok) throw new Error('Failed to delete');
            alert('Event deleted successfully!');
            loadEvents();
        } catch (error) {
            alert('Error deleting event: ' + error.message);
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        if (checkAuth()) {
            loadEvents();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeEventModal();
        }
    });
</script>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
