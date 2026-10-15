<input type="email" nitro:model="email">
<span nitro:loading nitro:target="email">Checking…</span>
@error('email') <p class="error">{{ $message }}</p> @enderror
