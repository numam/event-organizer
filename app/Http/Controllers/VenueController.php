<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class VenueController extends Controller
{
    // GET ALL - api/venues
    public function index(Request $request)
    {
        $query = Venue::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
        }

        // Order By
        $orderBy = $request->input('orderBy', 'created_at');
        $sortBy = $request->input('sortBy', 'desc');
        $query->orderBy($orderBy, $sortBy);

        // Pagination
        $limit = $request->input('limit', 10);
        $venues = $query->paginate($limit);

        return response()->json($venues, 200);
    }

    // GET BY ID - api/venues/{id}
    public function show(string $id)
    {
        $venue = Venue::with('events')->find($id);

        if (!$venue) {
            return response()->json([
                'message' => 'Venue not found'
            ], 404);
        }

        return response()->json($venue, 200);
    }

    // POST - api/venues
    public function store(Request $request)
    {
        try {
            // Validasi dengan file
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'province' => 'nullable|string|max:255',
                'capacity' => 'nullable|integer|min:0',
                'facilities' => 'nullable|string',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            ]);

            // Cek ukuran file manual untuk exception custom
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileSizeInMB = $file->getSize() / 1024 / 1024;

                if ($fileSizeInMB > 5) {
                    return response()->json([
                        'message' => 'Validation failed',
                        'errors' => [
                            'file' => ['File size must be less than 5MB. Your file size is ' . number_format($fileSizeInMB, 2) . 'MB']
                        ]
                    ], 422);
                }

                // Upload file
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('venues', $fileName, 'public');
                $validated['file_path'] = $filePath;
            }

            $venue = Venue::create($validated);

            return response()->json([
                'message' => 'Venue created successfully',
                'data' => $venue
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create venue',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // PATCH/PUT - api/venues/{id}
    public function update(Request $request, string $id)
    {
        $venue = Venue::find($id);

        if (!$venue) {
            return response()->json([
                'message' => 'Venue not found'
            ], 404);
        }

        // Validasi dengan file
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string|max:255',
            'province' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'facilities' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // max 5MB
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileSizeInMB = $file->getSize() / 1024 / 1024;

            if ($fileSizeInMB > 5) {
                throw ValidationException::withMessages([
                    'file' => ['File size must be less than 5MB. Your file size is ' . number_format($fileSizeInMB, 2) . 'MB']
                ]);
            }

            // Hapus file lama jika ada
            if ($venue->file_path && Storage::disk('public')->exists($venue->file_path)) {
                Storage::disk('public')->delete($venue->file_path);
            }

            // Upload file baru
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('venues', $fileName, 'public');
            $validated['file_path'] = $filePath;
        }

        $venue->update($validated);

        return response()->json($venue, 200);
    }

    // DELETE - api/venues/{id}
    public function destroy(string $id)
    {
        $venue = Venue::find($id);

        if (!$venue) {
            return response()->json([
                'message' => 'Venue not found'
            ], 404);
        }
        $venue->delete();

        return response()->json([
            'message' => 'Venue deleted successfully'
        ], 200);
    }
}
