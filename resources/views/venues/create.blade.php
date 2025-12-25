@extends('layouts.app')

@section('title', 'Create Venue')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold mb-6">Create Venue</h1>

    <form id="venueForm" class="space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700">Venue Name</label>
            <input id="name" type="text" required
                class="mt-1 w-full rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500 px-4 py-3"
                placeholder="Venue name">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Slug (optional)</label>
            <input id="slug" type="text"
                class="mt-1 w-full rounded-lg border-gray-200 px-4 py-3"
                placeholder="auto-generated">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <input id="address" type="text"
                class="mt-1 w-full rounded-lg border-gray-200 px-4 py-3">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">City</label>
                <input id="city" type="text"
                    class="mt-1 w-full rounded-lg border-gray-200 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Province</label>
                <input id="province" type="text"
                    class="mt-1 w-full rounded-lg border-gray-200 px-4 py-3">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Capacity</label>
            <input id="capacity" type="number" min="1"
                class="mt-1 w-full rounded-lg border-gray-200 px-4 py-3">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Price (Rp)</label>
            <input id="price" type="number" min="0"
                class="mt-1 w-full rounded-lg border-gray-200 px-4 py-3">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Facilities</label>
            <input id="facilities" type="text"
                class="mt-1 w-full rounded-lg border-gray-200 px-4 py-3"
                placeholder="Projector, Sound System">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Image (optional)</label>
            <input id="file" type="file" accept="image/jpeg,image/jpg,image/png"
                class="mt-1 w-full rounded-lg border-gray-200 px-4 py-3">
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit"
                class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-lg font-medium">
                Create Venue
            </button>
            <a href="{{ route('venues.index') }}"
                class="bg-gray-100 hover:bg-gray-200 px-6 py-3 rounded-lg">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
const API_URL = window.location.origin + '/api';

function getAuthToken() {
    return window.AUTH_TOKEN || localStorage.getItem('auth_token') || localStorage.getItem('jwt_token');
}

function slugify(text) {
    if (!text) return '';
    const normalized = text.normalize('NFKD').replace(/[\u0300-\u036f]/g, '');
    return normalized.toLowerCase().trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
}

// Auto-slug when name changes
let userEditedSlug = false;
const nameInput = document.getElementById('name');
const slugInput = document.getElementById('slug');
nameInput.addEventListener('input', (e) => {
    if (!userEditedSlug) slugInput.value = slugify(e.target.value);
});
slugInput.addEventListener('input', () => {
    userEditedSlug = true;
});

document.getElementById('venueForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const token = getAuthToken();
    if (!token) {
        alert('Not authenticated. Please login first.');
        window.location.href = '/';
        return;
    }

    // Use FormData to handle file upload
    const formData = new FormData();
    formData.append('name', document.getElementById('name').value);
    formData.append('slug', document.getElementById('slug').value || slugify(document.getElementById('name').value));
    formData.append('address', document.getElementById('address').value);
    formData.append('city', document.getElementById('city').value);
    formData.append('province', document.getElementById('province').value);
    formData.append('capacity', document.getElementById('capacity').value);
    formData.append('price', document.getElementById('price').value);
    formData.append('facilities', document.getElementById('facilities').value);

    // Add file if selected
    const fileInput = document.getElementById('file');
    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }

    console.log('FormData entries:', [...formData.entries()]);
    console.log('Token:', token);

    try {
        const res = await fetch(`${API_URL}/venues`, {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            body: formData
        });

        if (!res.ok) {
            const err = await res.json();
            alert(err.message || 'Failed to create venue');
            console.error('Error response:', err);
            return;
        }

        alert('Venue created successfully!');
        window.location.href = "{{ route('venues.index') }}";
    } catch (err) {
        console.error(err);
        alert('Error: ' + err.message);
    }
});
</script>
@endsection
