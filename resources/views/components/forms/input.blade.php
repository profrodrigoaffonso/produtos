<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input name="{{ $name }}" type="{{ $type }}" class="form-control" id="{{ $id }}" value="{{ @$value }}" maxlength="{{ $maxlength }}" {{ @$required }} {{ @$extra }}>
    <div id="js_error_{{ $id }}" style="display: none"></div>
    @error($name)
        <div style="color: #f00">{{ $message }}</div>
    @enderror
</div>
