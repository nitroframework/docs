@use('App\Enums\OrderStatus')

<select fusion:model="status">
    @foreach (OrderStatus::cases() as $case)
        <option value="{{ $case->value }}">{{ $case->label() }}</option>
    @endforeach
</select>

<p>{{ $status->label() }}</p>
