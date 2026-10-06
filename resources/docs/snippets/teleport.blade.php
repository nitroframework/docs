{{-- In the component: --}}
@teleport('modals')
    <div class="modal">...</div>
@endteleport

{{-- In the layout, where the content appears: --}}
@portal('modals')
