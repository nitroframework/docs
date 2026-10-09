<div>
    <button nitro:click="increment">+</button>
    <p>Clicked {{ $count }} times</p>      {{-- reads $count --}}
    <p>Hello, {{ $name }}</p>               {{-- reads $name, so a click leaves it alone --}}

    @foreach ($authors as $author)          {{-- reads $authors, so neither one changes it --}}
        <li>{{ $author }}</li>
    @endforeach
</div>
