<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;

class UrlController extends Controller
{
    public function shorten(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        $shortenedUrl = Url::generateShortUrl();
        while (Url::where('shortened_url', $shortenedUrl)->exists()) {
            $shortenedUrl = Url::generateShortUrl();
        }

        $url = Url::create([
            'original_url' => $request->url,
            'shortened_url' => $shortenedUrl
        ]);

        return response()->json(['shortened_url' => url($url->shortened_url)], 201);
    }

    public function redirect($shortenedUrl)
    {
        $url = Url::where('shortened_url', $shortenedUrl)->firstOrFail();
        return redirect($url->original_url);
    }
}

?>
