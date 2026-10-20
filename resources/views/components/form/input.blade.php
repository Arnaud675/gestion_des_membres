@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'group' => 'input-group',
])

<div class="form-group">
    <label>{{ $label }}@if($required) <span class="required">*</span>@endif</label>
    <div class="{{ $group }}">
        <input type="{{ $type }}"
               name="{{ $name }}"
               @if(!is_null($value)) value="{{ $value }}" @endif
               @if($placeholder) placeholder="{{ $placeholder }}" @endif
               @if($required) required @endif
               {{ $attributes->merge(['class' => 'form-input']) }}>
        @error($name)
            <span class="error-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
