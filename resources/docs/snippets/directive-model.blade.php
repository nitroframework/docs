<input nitro:model="email">                        {{-- Updates on every keystroke --}}
<input nitro:model.blur="name">                    {{-- Updates when the field loses focus --}}
<input nitro:model.debounce.300ms="search">        {{-- Updates 300ms after typing stops --}}
<input type="number" nitro:model.number="age">     {{-- Stores the value as a number --}}
<input nitro:model="form.email">                   {{-- Binds a key of the $form array --}}
