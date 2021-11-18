<form method="POST" action="{{ route('statamic.login') }}">
    @csrf

    @if(! empty($redirect))
        <input type="hidden" name="_redirect" value="{{ $redirect }}">
    @endif

    <div class="mb-4">
        <label class="mb-1" for="input-email">{{ __('Email') }}</label>
        <input type="text" class="input-text input-text" name="email" value="{{ old('email') }}" autofocus id="input-email">
        @if(isset($errors) && $errors->has('email'))<div class="text-red text-xs mt-1">{{ $errors->first('email') }}</div>@endif
    </div>

    <div class="mb-4">
        <label class="mb-1" for="input-password">{{ __('Password') }}</label>
        <input type="password" class="input-text input-text" name="password" id="input-password">
        @if(isset($errors) && $errors->has('password'))<div class="text-red text-xs mt-1">{{ $errors->first('password') }}</div>@endif
    </div>

    <div class="flex justify-between items-center">
        <label for="remember-me" class="flex items-center cursor-pointer">
            <input type="checkbox" name="remember" id="remember-me">
            <span class="ml-1">{{ __('Remember me') }}</span>
        </label>
        <button type="submit" class="btn-primary">{{ __('Log in') }}</button>
    </div>

</form>
