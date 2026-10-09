<th nitro:click="sortBy('title')">Title {{ $this->sortIcon('title') }}</th>
...
@foreach ($this->rows['items'] as $post)
    ...
@endforeach

<p>{{ $this->rows['from'] }}–{{ $this->rows['to'] }} of {{ $this->rows['total'] }}</p>
<button nitro:click="previousPage">Previous</button>
<button nitro:click="nextPage">Next</button>
