<th fusion:click="sortBy('name')">Name {{ $this->sortIcon('name') }}</th>
...
@foreach ($this->rows['items'] as $student)
    ...
@endforeach

<p>{{ $this->rows['from'] }}–{{ $this->rows['to'] }} of {{ $this->rows['total'] }}</p>
<button fusion:click="previousPage">Previous</button>
<button fusion:click="nextPage">Next</button>
