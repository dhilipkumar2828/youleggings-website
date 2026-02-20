<?php
// app/Http/Controllers/LogViewerController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class LogViewerController extends Controller
{
    public function view(Request $request)
    {
        $filepath = storage_path('logs/laravel.log');
        $linesPerPage = 100;
        $page = (int) $request->get('page', 1);
        if ($page < 1) $page = 1;

        if (!file_exists($filepath)) {
            abort(404, "Log file not found.");
        }

        $logContent = $this->getLinesFromFile($filepath, $linesPerPage, $page);
        $totalLines = $this->countLines($filepath);
        $totalPages = (int) ceil($totalLines / $linesPerPage);

        return view('logviewer', [
            'logContent' => $logContent,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    // Read N lines from a specific page (offset)
    private function getLinesFromFile($filepath, $linesPerPage, $page)
    {
        $start = ($page - 1) * $linesPerPage;
        $lines = [];

        $handle = fopen($filepath, 'r');
        if (!$handle) {
            return ["Unable to open log file."];
        }

        $currentLine = 0;
        while (!feof($handle)) {
            $line = fgets($handle);
            if ($currentLine >= $start && count($lines) < $linesPerPage) {
                $lines[] = $line;
            }
            $currentLine++;
            if (count($lines) >= $linesPerPage) break;
        }

        fclose($handle);
        return $lines;
    }

    private function countLines($filepath)
    {
        $lines = 0;
        $handle = fopen($filepath, 'r');
        while (!feof($handle)) {
            fgets($handle);
            $lines++;
        }
        fclose($handle);
        return $lines;
    }

}
