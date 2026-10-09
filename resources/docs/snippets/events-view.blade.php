<button nitro:click="$dispatch('notify', 'Copied')">Copy</button>
<button nitro:click="$dispatchTo('toaster', 'notify', 'Copied')">Copy</button>
<button nitro:click="$dispatchSelf('refresh')">Refresh</button>
<button nitro:click="$parent->save()">Save the form around it</button>
