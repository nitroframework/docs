<div>
    <button fusion:click="increment">+</button>
    <p>Clicked {{ $count }} times</p>      {{-- reads $count --}}
    <p>Hello, {{ $name }}</p>               {{-- reads $name, so a click leaves it alone --}}

    @foreach ($students as $student)        {{-- reads $students, so neither one changes it --}}
        <li>{{ $student['name'] }}</li>
    @endforeach
</div>
