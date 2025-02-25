<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('css')
</head>
<body class="font-sans antialiased">

{{-- The navbar with `sticky` and `full-width` --}}
<x-mary-nav full-width>

    <x-slot:brand>
        {{-- Drawer toggle for "main-drawer" --}}
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-mary-icon name="o-bars-3" class="cursor-pointer"/>
        </label>

        {{-- Brand --}}
        <div>App</div>
    </x-slot:brand>

    {{-- Right side actions --}}
    <x-slot:actions>
        <x-mary-button label="Messages" icon="o-envelope" link="###" class="btn-ghost btn-sm" responsive/>
        <x-mary-button label="Notifications" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
    </x-slot:actions>
</x-mary-nav>

{{-- The main content with `full-width` --}}
<x-mary-main with-nav full-width>

    {{-- This is a sidebar that works also as a drawer on small screens --}}
    {{-- Notice the `main-drawer` reference here --}}
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">

        {{-- User --}}
        @if($user = auth()->user())
            <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
                <x-slot:actions>
                    <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                                   no-wire-navigate link="/logout"/>
                </x-slot:actions>
            </x-mary-list-item>

            <x-mary-menu-separator/>
        @endif

        {{-- Activates the menu item when a route matches the `link` property --}}
        <x-mary-menu activate-by-route>
            <x-mary-menu-item title="Home" icon="o-home" link="/dashboard"/>
            <x-mary-menu-item title="Articles" icon="o-document" link="{{ route('articles.index') }}"/>
            <x-mary-menu-item title="Users Mary" icon="o-user" link="{{ route('mary-ui.users.index') }}"/>
            <x-mary-menu-item title="Users Daisy" icon="o-user" link="{{ route('daisy-ui.users.index') }}"/>
            {{--            <x-mary-menu-item title="Users" icon="o-users" link="{{ route('users.index') }}"/>--}}
            {{--            <x-mary-menu-item title="Users2" icon="o-home" link="{{ route('users.index2') }}"/>--}}
        </x-mary-menu>
    </x-slot:sidebar>

    {{-- The `$slot` goes here --}}
    <x-slot:content class="bg-base-200">
        {{ $slot }}
    </x-slot:content>
</x-mary-main>

{{--  TOAST area --}}
<x-mary-toast/>
@stack('footer')
@livewireScripts
</body>
</html>
