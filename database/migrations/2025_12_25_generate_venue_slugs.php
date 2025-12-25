<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Venue;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Generate slugs for existing venues that don't have one
        $venues = Venue::whereNull('slug')->orWhere('slug', '')->get();

        foreach ($venues as $venue) {
            if (!$venue->slug || $venue->slug === '') {
                $venue->slug = $this->slugify($venue->name);
                $venue->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: reset slugs to null
        // Venue::update(['slug' => null]);
    }

    private function slugify($text)
    {
        if (!$text) return '';
        $normalized = preg_replace('/[^\x{0021}-\x{007E}]/u', '', $text);
        return strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $normalized), '-'));
    }
};
