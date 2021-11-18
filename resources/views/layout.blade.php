@include('template-parts/head')

    @include('template-parts/header')

        @if(isset($protected) && optional($protected)->value() && Auth::guest())
            <div class="buildamic-section">
                <div class="container">
                    <div class="buildamic-row">
                        <div class="buildamic-column col col-12">
                            <x-login-form redirect="{{ url($url) }}" />
                        </div>
                    </div>
                </div>
            </div>
        @else
            @isset($template_content)
                {!! $template_content !!}
            @else
                @yield('template_content')
            @endisset
        @endif

    @include('template-parts/footer')

@include('template-parts/foot')
