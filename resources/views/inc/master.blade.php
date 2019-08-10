<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@isset($headTitle){{ $headTitle }} -@endisset {{ asw('title') }}</title>
    @isset($headDescription)<meta name="description" content="{{ $headDescription }}">@endisset
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
</head>
<body>
@include('inc/header')
<?php
    if( isset($cclass) ){
        $classes = explode(' ', $cclass);
        if( in_array('game', $classes) ){
?>
@include('inc/tags');
<?php
        }
    }
?>
<div class="container @isset($cclass){{ $cclass }} @endisset">
<div id="wrapper">
@yield('content')
</div>
</div>
@include('inc/footer')
<script type="text/javascript" src="{{ url('js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/script.js') }}"></script>
@yield('end')
</body>
</html>
