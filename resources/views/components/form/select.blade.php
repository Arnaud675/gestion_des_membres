@props([
    'name',
    'label',
    'required' => false,
    'group' => 'input-group',
    'class' => 'form-input',
])

<div class="form-group">
    <label>{{ $label }}@if($required) <span class="required">*</span>@endif</label>
    <div class="{{ $group }}">
        <select name="{{ $name }}" class="{{ $class }}" {{ $attributes }}>
            {{ $slot }}
        </select>
        @error($name)
            <span class="error-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
