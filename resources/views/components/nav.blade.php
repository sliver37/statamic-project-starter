@php
    ${$handle . "_list"} = [];
@endphp

@nav($handle, ['include_home' => $includeHome])
    @php
        array_push(${$handle . "_list"}, $item);
    @endphp
@endnav

<v-nav :items="{{ collect(${$handle . "_list"})->toJson() }}"
    handle="{{ $handle }}"
    @if($isMain) to_mobile_menu @endif
    @if($includeHome) include @endif
    @if($icons) :icons="{{ $icons }}" @endif
    @if($hasToggle) has_toggle @endif
    @if($alwaysMobile) always_mobile @endif />
