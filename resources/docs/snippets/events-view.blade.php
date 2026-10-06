<button fusion:click="$dispatch('notify', 'Copied')">Copy</button>
<button fusion:click="$dispatchTo('toaster', 'notify', 'Copied')">Copy</button>
<button fusion:click="$dispatchSelf('refresh')">Refresh</button>
<button fusion:click="$parent->save()">Save the form around it</button>
