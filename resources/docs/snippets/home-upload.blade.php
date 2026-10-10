<input type="file" nitro:model="photo">

@if ($photo)
    <img src="{{ $photo->temporaryUrl() }}">
@endif
