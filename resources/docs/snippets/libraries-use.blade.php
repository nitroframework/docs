<div nitro:ignore>
    <select nitro:select2="category">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

{{-- A row of a list: bound to its own row. --}}
@foreach ($lines as $i => $line)
    <div nitro:key="line-{{ $i }}" nitro:ignore>
        <select nitro:select2="lines.{{ $i }}.product">...</select>
    </div>
@endforeach
