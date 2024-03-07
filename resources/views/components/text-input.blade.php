@props(['name', 'label', 'type' => 'text', 'value' => ''])
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input value="{{ old($name, $value) }}" {!! $attributes->merge(['class' => $errors->has($name) ? 'form-control is-invalid' : 'form-control' ]) !!} type="{{ $type }}" id="{{ $name }}" name="{{ $name }}">
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
