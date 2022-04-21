@php
    ${$handle . "_list"} = [];
@endphp

<div id="{{ $handle }}" class="nav-wrapper">
    @if($hasToggle)
        <v-hamburger></v-hamburger>
    @endif
    @if($teleMobile) <tele-mobile :order="{{ $mobileOrder }}"> @endif
        <nav class="nav nav__{{ $handle }}">
            <ul class="nav-items {{ $gap }}">
                @nav($handle, ['include_home' => $includeHome])
                    <x-nav-item :item="$item" />
                @endnav
            </ul>
        </nav>
    @if($teleMobile) </tele-mobile> @endif
</div>
