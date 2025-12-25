@extends('layouts.app')

@section('title', 'Edit Venue')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow">
    <h1 class="text-2xl font-bold mb-4">Edit Venue</h1>

    <form id="venueForm" onsubmit="submitEdit(event)">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Venue Name</label>
            <input id="name" type="text" required class="mt-1 block w-full border-gray-200 rounded-lg p-3" placeholder="Venue name"/>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Slug</label>
            <input id="slug" type="text" class="mt-1 block w-full border-gray-200 rounded-lg p-3" placeholder="slug"/>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <input id="address" type="text" class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">City</label>
                <input id="city" type="text" class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Province</label>
                <input id="province" type="text" class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Capacity</label>
            <input id="capacity" type="number" min="1" class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Price (Rp)</label>
            <input id="price" type="number" min="0" step="1000" class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Facilities (comma separated)</label>
            <input id="facilities" type="text" class="mt-1 block w-full border-gray-200 rounded-lg p-3" placeholder="Projector, Sound System"/>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Image (optional)</label>
            <input id="file" type="file" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-200 rounded-lg p-3"/>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-700 text-white px-6 py-3 rounded-lg">Save Changes</button>
            <a href="{{ route('venues.index') }}" class="bg-gray-100 px-6 py-3 rounded-lg">Back</a>
        </div>
    </form>
</div>

<script>
    const API_URL = window.location.origin + '/api';
    const slug = '{{ $slug }}';
    let resourceId = null;
    function getAuthToken(){ return window.AUTH_TOKEN || localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token'); }

    async function loadResource(){
        try{
            const token = getAuthToken();
            const resp = await fetch(`${API_URL}/venues`, {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            if (!resp.ok) throw new Error('Failed to fetch venues');
            const json = await resp.json();
            const items = json.data || json || [];
            const item = items.find(i=>i.slug === slug || String(i.slug) === slug);
            if(!item) throw new Error('Venue not found');
            resourceId = item.id;
            document.getElementById('name').value = item.name || '';
            document.getElementById('slug').value = item.slug || '';
            document.getElementById('address').value = item.address || '';
            document.getElementById('city').value = item.city || '';
            document.getElementById('province').value = item.province || '';
            document.getElementById('capacity').value = item.capacity || 0;
            document.getElementById('price').value = item.price || 0;
            document.getElementById('facilities').value = item.facilities || '';
        }catch(err){
            alert('Error loading venue: ' + err.message);
            window.location.href = '{{ route('venues.index') }}';
        }
    }

    async function submitEdit(e){
        e.preventDefault();
        const token = getAuthToken();
        if(!resourceId){ alert('No resource loaded'); return; }
        const data = {
            name: document.getElementById('name').value,
            slug: document.getElementById('slug').value,
            address: document.getElementById('address').value,
            city: document.getElementById('city').value,
            province: document.getElementById('province').value,
            capacity: document.getElementById('capacity').value || 0,
            price: document.getElementById('price').value || 0,
            facilities: document.getElementById('facilities').value || ''
        };

        try{
            const res = await fetch(`${API_URL}/venues/${resourceId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(data)
            });
            if (!res.ok) {
                const err = await res.json();
                throw new Error(err.message || 'Failed to update venue');
            }
            alert('Venue updated');
            window.location.href = '{{ route('venues.index') }}';
        }catch(err){
            alert('Error updating venue: ' + err.message);
        }
    }

    // slug helper + auto-slug behavior
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
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', (e)=>{ if (!userEditedSlug) slugInput.value = slugify(e.target.value); });
        slugInput.addEventListener('input', ()=> userEditedSlug = true);
    }

    document.addEventListener('DOMContentLoaded', loadResource);
</script>
@endsection
