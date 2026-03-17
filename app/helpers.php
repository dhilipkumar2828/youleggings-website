<?php

if (!function_exists('image_url')) {
    /**
     * Resolve image URL from uploads, photos, or storage directories.
     */
    function image_url($path) {
        if (empty($path)) {
            return asset('frontend/images/logo-new.png');
        }
        
        $originalPath = $path;

        // 1. Handle nested/double URLs (e.g. domain.com/uploads/http://domain.com/...)
        $lastHttpPos = strrpos($path, 'http');
        if ($lastHttpPos !== false && $lastHttpPos > 8) {
            $path = substr($path, $lastHttpPos);
        }

        // 2. Remove ANY full URL prefixes for known local/demo domains to make it relative
        $path = preg_replace('#^https?://(you\.oceansoftwares\.in|127\.0\.0\.1|localhost)(:(\d+))?(/demo)?(/public)?/#', '', $path);

        // 3. Remove common relative prefixes to get just the filename or subpath
        $path = str_replace([
            'public/storage/',
            'public/uploads/',
            'public/photos/',
            'storage/',
            'uploads/',
            'photos/',
            'public/',
        ], '', $path);

        $path = ltrim($path, '/');
        
        // 4. If it's STILL a full URL, it's truly external
        if (filter_var($path, FILTER_VALIDATE_URL) && strpos($path, 'you.oceansoftwares.in') === false && strpos($path, '127.0.0.1') === false && strpos($path, 'localhost') === false) {
            return $path;
        }

        // 5. Try to find the file locally with various folder prefixes
        $toCheck = [
            $path,
            'uploads/' . $path,
            'photos/' . $path,
            'storage/' . $path,
            'uploads/photos/' . $path,
        ];

        // Handle extension mismatches (jpg vs png vs jpeg)
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
            $baseName = substr($path, 0, - (strlen($ext) + 1));
            $alts = ['png', 'jpg', 'jpeg', 'webp'];
            foreach ($alts as $a) {
                if (strtolower($a) == strtolower($ext)) continue;
                $altPath = $baseName . '.' . $a;
                $toCheck[] = $altPath;
                $toCheck[] = 'uploads/photos/' . $altPath;
                $toCheck[] = 'uploads/' . $altPath;
                $toCheck[] = 'photos/' . $altPath;
            }
        }

        foreach ($toCheck as $p) {
            if (file_exists(public_path($p))) {
                return asset($p);
            }
        }

        // 6. Fallback if not found: try to guess the most likely location if it was from our domains
        $isInternal = (strpos($originalPath, 'you.oceansoftwares.in') !== false || strpos($originalPath, '127.0.0.1') !== false || strpos($originalPath, 'localhost') !== false);
        
        if ($isInternal) {
            // Check if it already has a common prefix
            if (preg_match('#^(photos|uploads|storage)/#', $path)) {
                return asset($path);
            }
            // Default to uploads/photos for variant images
            return asset('uploads/photos/' . $path);
        }

        return asset($path);
    }
}
