<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preview PDF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        iframe {
            border: none;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <iframe src="https://docs.google.com/gview?url={{ urlencode(asset('storage/' . $arsip->file)) }}&embedded=true">
    </iframe>
</body>
</html>
