<form nitro:submit="subscribe">
    <input nitro:model="email" type="email">
    @error('email') <p>{{ $message }}</p> @enderror

    <button nitro:loading.attr="disabled">Subscribe</button>
</form>
