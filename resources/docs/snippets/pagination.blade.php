<th nitro:click="sortBy('name')">Name {{ $this->sortIcon('name') }}</th>
...
@foreach ($this->rows['items'] as $student)
    ...
@endforeach

<p>{{ $this->rows['from'] }}–{{ $this->rows['to'] }} of {{ $this->rows['total'] }}</p>
<button nitro:click="previousPage">Previous</button>
<button nitro:click="nextPage">Next</button>
