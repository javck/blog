@extends('layouts.grandba')

@section('top_content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','HomePage')</title>
</head>
<body>
    這裡寫內容....

    @yield('content')

    @include('include')

    @section('js')
        <script src="app.js" />
    @show
</body>
</html>

@endsection

