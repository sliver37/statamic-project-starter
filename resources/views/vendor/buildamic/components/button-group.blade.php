<div class="button-group {{ $button_wrapper_classes ?? '' }}">
    @foreach($buttons as $button)
        @component('buildamic::components.button', ['data'=> $button])@endcomponent
    @endforeach
</div>
