<li class="nav-item">
    <a class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}" href="{{ url('/') }}">
        Home
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/plans') ? 'active fw-bold' : '' }}" href="{{ route('plans.index') }}">
        Plan
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/users') ? 'active fw-bold' : '' }}" href="{{ route('users.index') }}">
        User
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/subscriptions') ? 'active fw-bold' : '' }}" href="{{ route('subscriptions.index') }}">
        Subscription
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/contact') ? 'active fw-bold' : '' }}" href="{{ route('contacts.index') }}">
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