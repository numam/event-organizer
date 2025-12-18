<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // GET ALL - api/events
    public function index(Request $request)
    {
        $query = Event::with('venue');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('organizer_name', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by venue
        if ($request->has('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }

        // Order By
        $orderBy = $request->input('orderBy', 'created_at');
        $sortBy = $request->input('sortBy', 'desc');
        $query->orderBy($orderBy, $sortBy);

        // Pagination
        $limit = $request->input('limit', 10);
        $events = $query->paginate($limit);

        return response()->json($events, 200);
    }

    // GET BY ID - api/events/{id}
    public function show(string $id)
    {
        $event = Event::with('venue')->find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        return response()->json($event, 200);
    }

    // POST - api/events
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'title' => 'required|string|max:255',
            'organizer_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:events',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:now',
            'end_date' => 'required|date|after:start_date',
            'max_capacity' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published,cancelled,finished',
        ]);

        $event = Event::create($validated);
        $event->load('venue');

        return response()->json($event, 201);
    }

    // PUT/PATCH - api/events/{id}
    public function update(Request $request, string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        // Validasi untuk PATCH (semua field optional kecuali yang diisi)
        $rules = [
            'venue_id' => 'sometimes|required|exists:venues,id',
            'title' => 'sometimes|required|string|max:255',
            'organizer_name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:events,slug,' . $id,
            'description' => 'nullable|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'max_capacity' => 'nullable|integer|min:0',
            'status' => 'sometimes|in:draft,published,cancelled,finished',
        ];

        // Untuk method PUT, pastikan semua required field ada
        if ($request->isMethod('put')) {
            $rules = [
                'venue_id' => 'required|exists:venues,id',
                'title' => 'required|string|max:255',
                'organizer_name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:events,slug,' . $id,
                'description' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'max_capacity' => 'nullable|integer|min:0',
                'status' => 'required|in:draft,published,cancelled,finished',
            ];
        }

        $validated = $request->validate($rules);

        $event->update($validated);
        $event->load('venue');

        return response()->json($event, 200);
    }

    // DELETE - api/events/{id}
    public function destroy(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ], 200);
    }
}
