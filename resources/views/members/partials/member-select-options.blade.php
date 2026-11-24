@php($availableOptions = collect($options)->flatten()->all())

@if($selected && !in_array($selected, $availableOptions, true))
    <option value="{{ $selected }}" selected>{{ $selected }} (valeur actuelle)</option>
@endif

@foreach($options as $group => $values)
    <optgroup label="{{ $group }}">
        @foreach($values as $value)
            <option value="{{ $value }}" {{ $selected === $value ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </optgroup>
@endforeach