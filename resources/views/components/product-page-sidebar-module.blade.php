<div>
    <div class="border-b border-primary pb-3 mb-4 text-primary flex items-center">
        <{{ $headingLevel }} class="mb-0 font-bold">{{ $heading }}</{{ $headingLevel }}>
        @isset($headingButton)
            {!! $headingButton !!}
        @endisset
    </div>
    {!! $slot !!}
</div>
