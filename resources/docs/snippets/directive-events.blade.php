<button fusion:click="save">Save</button>
<form fusion:submit="add">...</form>
<input fusion:keydown.enter="search">
<div fusion:click.outside="$set('open', false)">...</div>
<input fusion:input.debounce.300ms="suggest">
