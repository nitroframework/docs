{{-- Aliased, because the name is written out in full. --}}
@if ($errors->has('form.email')) ... @endif

{{-- Not aliased, because the name is built from a variable. --}}
@if ($errors->has('form.'.$field)) ... @endif
