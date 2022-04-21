@if(Auth::guest())
    <a class="flex items-center gap-1" href="#">Sign In</v-icon></a>
@else
    <a href="/account">My Account</a>
@endif
