@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow">
    <h1 class="text-2xl font-bold mb-4">Edit Event</h1>

    <form id="eventForm" onsubmit="submitEdit(event)">
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
            <label class="block text-sm font-medium text-gray-700">Slug</label>
            <input id="slug" type="text" class="mt-1 block w-full border-gray-200 rounded-lg p-3" placeholder="slug"/>
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
            <button type="submit" class="bg-purple-700 text-white px-6 py-3 rounded-lg">Save Changes</button>
            <a href="{{ route('events.index') }}" class="bg-gray-100 px-6 py-3 rounded-lg">Back</a>
        </div>
    </form>
</div>

<script>
    const API_URL = window.location.origin + '/api';
    const slug = '{{ $slug }}';
    let resourceId = null;

    function getAuthToken(){
        return window.AUTH_TOKEN || localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
    }

    async function loadVenues(){
        try{
            const token = getAuthToken();
            const resp = await fetch(`${API_URL}/venues?limit=1000`, {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            if (!resp.ok) throw new Error('Failed to fetch venues');
            const json = await resp.json();
            const venues = json.data || json || [];
            const select = document.getElementById('venue_id');
            venues.forEach(venue => {
                const opt = document.createElement('option');
                opt.value = venue.id;
                opt.textContent = venue.name;
                select.appendChild(opt);
            });
        }catch(err){
            console.error('Error loading venues:', err.message);
        }
    }

    async function loadResource(){
        try{
            const token = getAuthToken();
            const resp = await fetch(`${API_URL}/events`, {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            if (!resp.ok) throw new Error('Failed to fetch events');
            const json = await resp.json();
            const items = json.data || json || [];
            const item = items.find(i=>i.slug === slug || String(i.slug) === slug);
            if(!item) throw new Error('Event not found');

            resourceId = item.id;
            document.getElementById('venue_id').value = item.venue_id || '';
            document.getElementById('title').value = item.title || '';
            document.getElementById('organizer_name').value = item.organizer_name || '';
            document.getElementById('slug').value = item.slug || '';
            document.getElementById('description').value = item.description || '';
            document.getElementById('max_capacity').value = item.max_capacity || '';
            document.getElementById('status').value = item.status || 'draft';

            // Format datetime for datetime-local input
            if(item.start_date){
                const startDate = new Date(item.start_date);
                document.getElementById('start_date').value = startDate.toISOString().substring(0, 16);
            }
            if(item.end_date){
                const endDate = new Date(item.end_date);
                document.getElementById('end_date').value = endDate.toISOString().substring(0, 16);
            }
        }catch(err){
            alert('Error loading event: ' + err.message);
            window.location.href = '{{ route('events.index') }}';
        }
    }

    async function submitEdit(e){
        e.preventDefault();
        const token = getAuthToken();
        if(!resourceId){ alert('No resource loaded'); return; }

        const data = {
            venue_id: document.getElementById('venue_id').value,
            title: document.getElementById('title').value,
            organizer_name: document.getElementById('organizer_name').value,
            slug: document.getElementById('slug').value,
            description: document.getElementById('description').value,
            start_date: document.getElementById('start_date').value,
            end_date: document.getElementById('end_date').value,
            max_capacity: document.getElementById('max_capacity').value || 0,
            status: document.getElementById('status').value || 'draft',
        };

        try{
            const res = await fetch(`${API_URL}/events/${resourceId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(data)
            });
            if (!res.ok) {
                const text = await res.text();
                console.error('API Error Response:', text);
                try {
                    const err = JSON.parse(text);
                    throw new Error(err.message || 'Failed to update event');
                } catch(e) {
                    throw new Error('Server error: ' + res.status);
                }
            }
            const json = await res.json();
            alert('Event updated successfully!');
            window.location.href = '{{ route('events.index') }}';
        }catch(err){
            alert('Error updating event: ' + err.message);
        }
    }

    // Slug helper
    function slugify(text){
        if (!text) return '';
        const normalized = text.normalize('NFKD').replace(/[\u0300-\u036f]/g, '');
        return normalized.toString().toLowerCase().trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    let userEditedSlug = false;
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', (e)=>{ if (!userEditedSlug) slugInput.value = slugify(e.target.value); });
        slugInput.addEventListener('input', ()=> userEditedSlug = true);
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadVenues();
        loadResource();
    });
</script>
@endsection
