<input nitro:model.trim="name">             {{-- Trimmed --}}
<input type="email" nitro:model.blur="email">     {{-- Set when the field loses focus --}}
<input type="radio" value="team" nitro:model="plan">
<input type="checkbox" nitro:model="terms">        {{-- true or false --}}
<select nitro:model="grade">...</select>
<input nitro:model="form.email">                   {{-- A key of the $form array --}}
