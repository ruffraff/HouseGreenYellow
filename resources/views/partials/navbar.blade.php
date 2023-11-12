<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><a class="nav-link" href="{{ route('home', ['lang' => App::getLocale()]) }}">RR</a></a>
 
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('houses.index', ['lang' => App::getLocale()]) }}">{{ __('messages.houses') }}</a>
            </li>
            @if (auth::check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('bookings.index', ['lang' => App::getLocale()]) }}">{{ __('messages.booking') }}</a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contacts.index', ['lang' => App::getLocale()]) }}">{{ __('messages.contacts') }}</a>
            </li>
            @if (auth::check())
            <li class="nav-item dropdown">
                <a id="navbarDropdown1" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li> 
           
            @endif
        </ul>
    </div>
   
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('messages.language') }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="?lang=it">{{ __('messages.italian') }}</a>
                    <a class="dropdown-item" href="?lang=en">{{ __('messages.english') }}</a>
                    <a class="dropdown-item" href="?lang=de">{{ __('messages.german') }}</a>
                    <a class="dropdown-item" href="?lang=es">{{ __('messages.spanish') }}</a>
                    <a class="dropdown-item" href="?lang=fr">{{ __('messages.french') }}</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
