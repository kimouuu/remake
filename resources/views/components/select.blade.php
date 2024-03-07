@props(['name', 'label', 'options' => [], 'value' => null])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select {!! $attributes->merge(['class' => $errors->has($name) ? 'form-control is-invalid' : 'form-control']) !!} id="{{ $name }}" name="{{ $name }}">
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
