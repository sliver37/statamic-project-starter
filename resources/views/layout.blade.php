<!doctype html>
<html lang="{{ $site->shortLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? $site->name() }}</title>
        <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
    </head>
    <body class="bg-gray-100 font-sans leading-normal text-grey-800">
        <div class="mx-auto px-2 h-screen flex items-center justify-center">
            @yield('template_content')
        </div>
        <script src="{{ mix('js/site.js') }}"></script>
    </body>
</html>
