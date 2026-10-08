{{-- resources/views/fusion/components/settings.blade.php --}}
<div>
    <nav>
        <button fusion:click="$set('tab', 'settings.profile')">Profile</button>
        <button fusion:click="$set('tab', 'settings.billing')">Billing</button>
        <button fusion:click="$set('tab', 'settings.notifications')">Notifications</button>
    </nav>

    {{-- The component $tab names; '' renders nothing. Another name, another component. --}}
    <fusion:dynamic-component :is="$tab" />
</div>
