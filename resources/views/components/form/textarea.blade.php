@props([
    'name',
    'label',
    'rows' => 3,
    'placeholder' => null,
    'required' => false,
    'group' => 'input-group',
])

<div class="form-group">
    <label>{{ $label }}@if($required) <span class="required">*</span>@endif</label>
    <div class="{{ $group }}">
        <textarea name="{{ $name }}"
                  rows="{{ $rows }}"
                  @if($placeholder) placeholder="{{ $placeholder }}" @endif
                  @if($required) required @endif
                  {{ $attributes->merge(['class' => 'form-textarea']) }}>{{ $slot }}</textarea>
        @error($name)
            <span class="error-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
