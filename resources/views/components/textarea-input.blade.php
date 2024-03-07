@props(['name', 'label', 'type' => 'text', 'value' => ''])
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea {!! $attributes->merge(['class' => $errors->has($name) ? 'form-control is-invalid' : 'form-control' ]) !!} type="{{ $type }}" id="{{ $name }}" name="{{ $name }}">
        {{ old($name, $value) }}
    </textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
