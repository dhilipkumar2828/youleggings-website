<?php

if (!function_exists('image_url')) {
    /**
     * Resolve image URL from uploads, photos, or storage directories.
     */
    function image_url($path) {
        if (empty($path)) {
            return asset('frontend/images/logo-new.png');
        }
        
        // Strip various old domains or prefixes if they exist in the stored string
        $path = str_replace([
            'http://127.0.0.1:8000/public/storage/',
            'http://localhost:8000/public/storage/',
            'public/storage/',
            'storage/'
        ], '', $path);
        
        $path = ltrim($path, '/');
        
        // Priority 0: Check if the path itself is valid from public root
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Priority 1: Check in public/uploads
        if (file_exists(public_path('uploads/' . $path))) {
            return asset('uploads/' . $path);
        }
        
        // Priority 2: Check in public/photos (standard LFM folder)
        if (file_exists(public_path('photos/' . $path))) {
            return asset('photos/' . $path);
        }

        // Priority 3: Check in public/storage
        if (file_exists(public_path('storage/' . $path))) {
            return asset('storage/' . $path);
        }
        
        // If it's still a full URL (external), return it
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Fallback: If not found, try uploads prefix
        return asset('uploads/' . $path);
    }
}
