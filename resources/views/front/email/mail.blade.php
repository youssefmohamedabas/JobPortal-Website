<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
    <style>
        body {
        background-color: #555
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        h1, h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>3awatly</h1>

    <p>Hello {{ $maildata['user']->name }},</p>

    @if(isset($maildata['job']))
        <h2>We are excited to inform you about a new job opportunity:</h2>
        <h2>Job Title: {{ $maildata['job']->title ?? 'Title Not Available' }}</h2>
        <h2>Job Category: {{ $maildata['job']->categoryType->name ?? 'Category Not Available' }}</h2>
        <h2>Job Description:</h2>
        <p>{{ $maildata['job']->description ?? 'Description Not Available' }}</p>
    @else
        <p>No job data available.</p>
    @endif

    <p>Thank you for being a part of 3awatly!</p>
</body>
</html>
