<input fusion:model.trim="name">             {{-- Trimmed --}}
<input type="email" fusion:model.blur="email">     {{-- Set when the field loses focus --}}
<input type="radio" value="team" fusion:model="plan">
<input type="checkbox" fusion:model="terms">        {{-- true or false --}}
<select fusion:model="grade">...</select>
<input fusion:model="form.email">                   {{-- A key of the $form array --}}
