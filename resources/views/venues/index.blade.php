@extends('layouts.app')

@section('title', 'Venues')

@section('content')
    <div style="padding: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem; color: var(--heading, #000);">Manage Venues</h1>

        {{-- Button Tambah --}}
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('venues.create') }}" style="background: var(--primary, #000); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; display: inline-block; font-size: 1rem;">
                + Add Venue
            </a>
        </div>

        {{-- Table Venues --}}
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: var(--primary, #000); color: white;">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-weight: 600;">Image</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600;">Name</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600;">Capacity</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600;">Price</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody id="venuesTable">
                    <tr>
                        <td colspan="4" style="padding: 2rem; text-align: center; color: var(--text, #666);">
                            Loading venues...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Add/Edit Venue --}}
    <div id="venueModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; flex-align: center; justify-content: center;">
        <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%; margin: auto; top: 50%; position: relative; transform: translateY(-50%);">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">Add Venue</h2>

            <form onsubmit="saveVenue(event)">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Name</label>
                    <input type="text" id="venueName" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem;"/>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Capacity</label>
                    <input type="number" id="venueCapacity" required min="1" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem;"/>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Price</label>
                    <input type="number" id="venuePrice" required min="0" step="0.01" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem;"/>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" style="flex: 1; background: var(--primary, #000); color: white; border: none; padding: 0.75rem; border-radius: 6px; font-weight: 600; cursor: pointer;">
                        Save
                    </button>
                    <button type="button" onclick="closeVenueModal()" style="flex: 1; background: #e0e0e0; color: #333; border: none; padding: 0.75rem; border-radius: 6px; font-weight: 600; cursor: pointer;">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_URL = window.location.origin + '/api';
        let editingVenueId = null;

        function getAuthToken() {
            return window.AUTH_TOKEN || localStorage.getItem('auth_token') || localStorage.getItem('jwt_token');
        }

        // Check auth
        const token = getAuthToken();
        if (!token) {
            window.location.href = '/';
        }

        // Load venues
        async function loadVenues() {
            try {
                const response = await fetch(`${API_URL}/venues`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (!response.ok) throw new Error('Failed to fetch venues');
                const json = await response.json();
                const venues = json.data || json || [];
                const tbody = document.getElementById('venuesTable');

                if (!Array.isArray(venues) || venues.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" style="padding: 2rem; text-align: center; color: #999;">No venues found</td></tr>';
                    return;
                }

                tbody.innerHTML = venues.map(venue => `
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem; text-align: center;">
                            ${venue.file_path ? `<img src="/storage/${venue.file_path}" alt="${venue.name}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;"/>` : '<span style="color: #999;">No image</span>'}
                        </td>
                        <td style="padding: 1rem; color: var(--text, #000);">${venue.name}</td>
                        <td style="padding: 1rem; color: var(--text, #000);">${venue.capacity} persons</td>
                        <td style="padding: 1rem; color: var(--text, #000);">Rp ${parseInt(venue.price || 0).toLocaleString('id-ID')}</td>
                        <td style="padding: 1rem; text-align: center;">
                            <a href="/dashboard/venues/${venue.slug}/edit" style="background: #4CAF50; color: white; padding: 0.5rem 1rem; border-radius: 4px; margin-right: 0.5rem; display:inline-block; font-size: 0.9rem; text-decoration:none;">Edit</a>
                            <button onclick="deleteVenue(${venue.id})" style="background: #f44336; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem;">Delete</button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error loading venues:', error);
                document.getElementById('venuesTable').innerHTML = '<tr><td colspan="4" style="padding: 2rem; text-align: center; color: #f44336;">Error loading venues</td></tr>';
            }
        }

        async function deleteVenue(id) {
            if (!confirm('Are you sure?')) return;

            try {
                const res = await fetch(`${API_URL}/venues/${id}`, {
                    method: 'DELETE',
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (!res.ok) throw new Error('Failed to delete');
                alert('Venue deleted successfully');
                loadVenues();
            } catch (error) {
                alert('Error deleting venue: ' + error.message);
            }
        }

        // Init
        document.addEventListener('DOMContentLoaded', loadVenues);

        // Tutup modal klik background
        const modal = document.getElementById('venueModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) modal.style.display = 'none';
            });
        }
    </script>
@endsection
