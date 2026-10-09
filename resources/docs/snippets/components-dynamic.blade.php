{{-- resources/views/nitro/components/settings.blade.php --}}
<div>
    <nav>
        <button nitro:click="$set('tab', 'settings.profile')">Profile</button>
        <button nitro:click="$set('tab', 'settings.billing')">Billing</button>
        <button nitro:click="$set('tab', 'settings.notifications')">Notifications</button>
    </nav>

    {{-- The component $tab names; '' renders nothing. Another name, another component. --}}
    <nitro:dynamic-component :is="$tab" />
</div>
