<!-- resources/views/logviewer.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Log Viewer</title>
    <style>
        body {
            font-family: monospace;
            background: #1e1e1e;
            color: #ccc;
            padding: 20px;
        }

        pre {
            white-space: pre-wrap;
            background: #222;
            padding: 10px;
            border: 1px solid #444;
            overflow-x: auto;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            color: #0bf;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <h2>Laravel Log Viewer</h2>
    <p>Page {{ $page }} of {{ $totalPages }}</p>
    <pre>{{ implode('', $logContent) }}</pre>

    <div class="pagination">
        @if ($page > 1)
            <a href="?page=1">&laquo; First</a>
            <a href="?page={{ $page - 1 }}">&lt; Prev</a>
        @endif

        @if ($page < $totalPages)
            <a href="?page={{ $page + 1 }}">Next &gt;</a>
            <a href="?page={{ $totalPages }}">Last &raquo;</a>
        @endif
    </div>
</body>

</html>
