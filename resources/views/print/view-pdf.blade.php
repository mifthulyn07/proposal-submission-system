<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Document</title>

    {{-- favicon --}}
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-si-panjul.png') }}">

    {{-- flowbite --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
</head>
<body>
    <iframe style="width:100%;height:100vh;" @if(stripos($file_name, "requirements") !== false) src="{{ asset('storage/requirements/'.$file_name) }}" @else src="{{ asset('storage/proposals/'.$file_name) }}" @endif type="application/pdf" width="100%" height="700"></iframe>
</body>
</html>