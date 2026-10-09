{{-- The settings section: its own sub-navigation, inside the app's layout. --}}
<x-layouts.app :title="$title">
    <div class="settings">
        <nav>
            <a href="/settings/profile" nitro:navigate nitro:current="active">Profile</a>
            <a href="/settings/billing" nitro:navigate nitro:current="active">Billing</a>
        </nav>

        {{-- Where the settings pages go. --}}
        <section nitro:layout="settings">
            {{ $slot }}
        </section>
    </div>
</x-layouts.app>
