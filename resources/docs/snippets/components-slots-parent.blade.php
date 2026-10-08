{{-- resources/views/fusion/components/team.blade.php --}}
<div>
    <fusion:panel :collapsible="true">
        {{-- The default slot: rendered here, with this view's values and methods. --}}
        <p>{{ count($members) }} members</p>
        <button fusion:click="invite">Invite someone</button>

        <fusion:slot name="footer">
            <a href="/team/settings" fusion:navigate>Team settings</a>
        </fusion:slot>
    </fusion:panel>
</div>
