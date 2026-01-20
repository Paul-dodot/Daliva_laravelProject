<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Games Export</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        h1 { color: #333; }
        .header { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Games Catalog Export</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        <p>Total Games: {{ $games->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Release Year</th>
                <th>Developer</th>
                <th>Publisher</th>
                <th>Platform</th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $game)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $game->title }}</td>
                <td>{{ $game->release_year }}</td>
                <td>{{ $game->developer }}</td>
                <td>{{ $game->publisher }}</td>
                <td>{{ $game->platform ? $game->platform->platform_name : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>