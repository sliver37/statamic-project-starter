<!DOCTYPE html>
<html class="h-full" lang="{{ $site->shortLocale() }}">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ $csrf_token }}" />
        <title>{{ $title ?? $site->name() }}</title>
        <link rel="icon" type="image/svg+xml" href="#" />

        @stack('pre-styles')

        {{-- <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}"> --}}

        @buildamicStyles
        {{-- @antlers('@{{ buildamicStyles }}') --}}
        {{-- <link rel="stylesheet" href="{{ asset('vendor/buildamic/css/buildamic.css') }}" /> --}}

        <link rel="stylesheet" href="{{ mix('css/styles.css') }}" />

        {{-- This will disable any of the animations for those without JS (not super important though) --}}
        <noscript>
            <style type="text/css">
                [data-sal|='fade'] {
                opacity: 1;
                }

                [data-sal|='slide'],
                [data-sal|='zoom'] {
                opacity: 1;
                transform: none;
                }

                [data-sal|='flip'] {
                transform: none;
                }
            </style>
        </noscript>

        @stack('post-styles')
    </head>
    <body class="h-full">


      <div class="h-full" id="app">
          <div class="flex flex-col gap-4" id="mobile-nav"></div>
          <noscript>
            <div class="w-full text-center bg-secondary text-white font-bold p-4">
              <p class="mb-0">
                This website requires JavaScript, please enable it to continue.
              </p>
            </div>
          </noscript>
