{{-- resources/views/nitro/components/team.blade.php --}}
<div>
    <nitro:panel :collapsible="true">
        {{-- The default slot: rendered here, with this view's values and methods. --}}
        <p>{{ count($members) }} members</p>
        <button nitro:click="invite">Invite someone</button>

        <nitro:slot name="footer">
            <a href="/team/settings" nitro:navigate>Team settings</a>
        </nitro:slot>
    </nitro:panel>
</div>
