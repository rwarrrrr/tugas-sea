<li class="nav-item">
    <a class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}" href="{{ url('/') }}">
        Home
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('menu') ? 'active fw-bold' : '' }}" href="{{ url('/menu') }}">
        Plan
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('menu') ? 'active fw-bold' : '' }}" href="{{ url('/menu') }}">
        User
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('menu') ? 'active fw-bold' : '' }}" href="{{ url('/menu') }}">
        Subscription
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('contact') ? 'active fw-bold' : '' }}" href="{{ url('/contact') }}">
        Contact
    </a>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        {{ Auth::user()->name }}
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item" type="submit">Logout</button>
            </form>
        </li>
    </ul>
</li>