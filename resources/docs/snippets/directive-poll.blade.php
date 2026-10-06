<div fusion:poll.30s="refresh">...</div>            {{-- Every 30 seconds, paused while the tab is hidden --}}
<div fusion:poll.visible="refresh">...</div>        {{-- Only while the element is on screen --}}
<div fusion:init="load">...</div>                   {{-- Once, when the element appears --}}
<div fusion:visible.200px="loadMore">...</div>      {{-- When the element comes within 200px of the screen --}}
