@php
    $isLoginPage = request()->routeIs('login') || request()->routeIs('password.request') || request()->routeIs('password.reset');
    $logoFile = $isLoginPage ? 'logo1.png' : 'logo2.png';
@endphp

<img src="{{ asset('images/logos/' . $logoFile) }}" alt="EZRent Logo" {{ $attributes }}>
