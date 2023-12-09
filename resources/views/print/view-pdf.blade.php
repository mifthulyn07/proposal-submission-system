<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- favicon --}}
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-si-panjul.png') }}">

    {{-- flowbite --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
</head>
<body>
    <embed style="width:100%;height:100vh;" src="{{ asset('storage/proposals/'.$file_name) }}" type="application/pdf" width="100%" height="700">
</body>
</html>