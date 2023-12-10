<a href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"
    >
    <i class="fas fa-door-open text-light text-center fa-2x"></i>
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
