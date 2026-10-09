<input nitro:keydown.enter="search">                  {{-- Enter --}}
<input nitro:keydown.enter.space="choose">            {{-- Enter or Space --}}
<div nitro:keydown.escape.window="close">...</div>    {{-- Escape, anywhere on the page --}}
<textarea nitro:keydown.ctrl.enter="send"></textarea> {{-- Ctrl+Enter --}}
<ul nitro:keydown.up.prevent="previous" nitro:keydown.down.prevent="next">...</ul>

<div nitro:keydown.ctrl.k.window.prevent="openSearch">...</div>   {{-- Ctrl+K, anywhere: a search box --}}
<div nitro:keydown.meta.k.window.prevent="openSearch">...</div>   {{-- and Command+K on a Mac --}}

<button nitro:click.shift="selectRange($i)">...</button>   {{-- a click with Shift held --}}
