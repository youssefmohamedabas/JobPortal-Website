<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
</head>
<body>
    <h1>Hello {{ $maildata['user']->name }}</h1>
    <h1>The Job category {{ $maildata['job']->categoryType->name }}</h1>
    <h1>The Job Job Nature {{ $maildata['job']->jobType->name }}</h1>
    <h1>The Job description {{ $maildata['job']->description }}</h1>
</body>
</html>