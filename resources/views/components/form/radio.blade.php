@props([
    'name', 'options', 'checked' => false, 'label' => false,
])

@if($label)
    <label>{{ $label }}</label>
@endif

@foreach($options as $value => $text)
    @php
        $id = $name . '_' . $value;
    @endphp
    <div class="form-check">
        <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}"
                @checked(old($name, $checked) == $value)
                {{ $attributes->class([
                    'form-check-input',
                ]) }}
        >
        <label class="form-check-label" for="{{ $id }}">
            {{ $text }}
        </label>
    </div>
@endforeach

<x-form.validation-feedback :name="$name" />
