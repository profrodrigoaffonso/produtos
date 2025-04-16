<div class="form-group">
    <label>{{ $label }}</label>
    <select class="form-control" id="{{ $id }}" name="{{ $name }}" {{ @$required }}>
        <option></option>
        @foreach($values as $key => $value)
            <option {{($key == @$selected ? 'selected' : '')}} value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
    @error($name)
        <div style="color: #f00">{{ $message }}</div>
    @enderror
</div>
