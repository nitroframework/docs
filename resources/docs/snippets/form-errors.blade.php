@error('email')
    <span class="error">{{ $message }}</span>
@enderror

<input @class(['input', 'is-invalid' => $errors->has('email')]) nitro:model="email">
<p>{{ $errors->first('email') }}</p>
