<button nitro:click="save">Save</button>
<form nitro:submit="add">...</form>
<input nitro:keydown.enter="search">
<div nitro:click.outside="$set('open', false)">...</div>
<input nitro:input.debounce.300ms="suggest">
