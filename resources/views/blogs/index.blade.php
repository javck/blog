<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blogs Index</title>
</head>

<body>
    @foreach ($blogs as $blog)
    <ul>
        <li>{{ $blog->title }}</li>
        <li>{{ $blog->description }}</li>
    </ul>
    @endforeach
</body>

</html>
