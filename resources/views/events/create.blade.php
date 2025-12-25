@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow">
    <h1 class="text-2xl font-bold mb-4">Create Event</h1>

    <form id="eventForm" onsubmit="submitCreate(event)">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Venue *</label>
            <select id="venue_id" required class="mt-1 block w-full border-gray-200 rounded-lg p-3">
                <option value="">-- Select Venue --</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Event Title *</label>
            <input id="title" type="text" required class="mt-1 block w-full border-gray-200 rounded-lg p-3" placeholder="Event title"/>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Organizer Name *</label>
            <input id="organizer_name" type="text" required class="mt-1 block w-full border-gray-200 rounded-lg p-3" placeholder="Organizer name"/>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Slug (optional)</label>
            <input id="slug" type="text" class="mt-1 block w-full border-gray-200 rounded-lg p-3" placeholder="auto-generated-from-title"/>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" rows="5" class="mt-1 block w-full border-gray-200 rounded-lg p-3"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Start Date & Time *</label>
                <input id="start_date" type="datetime-local" required class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">End Date & Time *</label>
                <input id="end_date" type="datetime-local" required class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Max Capacity</label>
            <input id="max_capacity" type="number" min="0" class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" class="mt-1 block w-full border-gray-200 rounded-lg p-3">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="cancelled">Cancelled</option>
                <option value="finished">Finished</option>
            </select>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-700 text-white px-6 py-3 rounded-lg">Create Event</button>
            <a href="{{ route('events.index') }}" class="bg-gray-100 px-6 py-3 rounded-lg">Cancel</a>
        </div>
    </form>
</div>

<script>
    const API_URL = window.location.origin + '/api';
    function getAuthToken(){ return window.AUTH_TOKEN || localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token'); }

    function slugify(text){
        if (!text) return '';
        const normalized = text.normalize('NFKD').replace(/[\u0300-\u036f]/g, '');
        return normalized.toString().toLowerCase().trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    // Load venues dropdown
    async function loadVenues() {
        try {
            const token = getAuthToken();
            const resp = await fetch(`${API_URL}/venues?limit=1000`, {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            if (!resp.ok) throw new Error('Failed to load venues');
            const json = await resp.json();
            const venues = json.data || json || [];

            const select = document.getElementById('venue_id');
            venues.forEach(venue => {
                const option = document.createElement('option');
                option.value = venue.id;
                option.textContent = venue.name;
                select.appendChild(option);
            });
        } catch (err) {
            console.error('Error loading venues:', err);
            alert('Failed to load venues');
        }
    }

    // Auto-slug when title changes
    let userEditedSlug = false;
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', (e) => {
        if (!userEditedSlug) slugInput.value = slugify(e.target.value);
    });
    slugInput.addEventListener('input', () => { userEditedSlug = true; });

    async function submitCreate(e){
        e.preventDefault();
        const token = getAuthToken();
        if (!token) {
            alert('Not authenticated. Please login first.');
            window.location.href = '/';
            return;
        }
        const data = {
            venue_id: document.getElementById('venue_id').value,
            title: document.getElementById('title').value,
            organizer_name: document.getElementById('organizer_name').value,
            slug: document.getElementById('slug').value || slugify(document.getElementById('title').value),
            description: document.getElementById('description').value,
            start_date: document.getElementById('start_date').value,
            end_date: document.getElementById('end_date').value,
            max_capacity: document.getElementById('max_capacity').value || null,
            status: document.getElementById('status').value,
        };

        try{
            const res = await fetch(`${API_URL}/events`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(data)
            });

            if (!res.ok) {
                const err = await res.json();
                alert(err.message || 'Failed to create event');
                return;
            }

            alert('Event created successfully!');
            window.location.href = '{{ route('events.index') }}';
        }catch(err){
            console.error(err);
            alert('Error: ' + err.message);
        }
    }

    // Load venues on page load
    document.addEventListener('DOMContentLoaded', loadVenues);
</script>
@endsection
