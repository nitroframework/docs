<input fusion:model="email">                        {{-- Updates on every keystroke --}}
<input fusion:model.blur="name">                    {{-- Updates when the field loses focus --}}
<input fusion:model.debounce.300ms="search">        {{-- Updates 300ms after typing stops --}}
<input type="number" fusion:model.number="age">     {{-- Stores the value as a number --}}
<input fusion:model="form.email">                   {{-- Binds a key of the $form array --}}
