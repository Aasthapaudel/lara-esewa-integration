<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Esewa in Laravel</title>

</head>

<body class="antialiased">


    {{-- <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="post"> --}}
    <form action="{{ route('esewa') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="1221">
        <input type="hidden" name="name" value="kailaba">
        {{-- <input type="hidden" name="email" value="kailaba@kailaba.com"> --}}
        <input type="hidden" name="amount" value="99">


        <input type="submit" value="Pay With Esewa">



    </form>
</body>

</html>
