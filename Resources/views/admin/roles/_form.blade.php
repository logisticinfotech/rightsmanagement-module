
    <div class="form-group">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($result) ? $result['name'] : old('name') }}" placeholder="Role Name" required autocomplete="off">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input id="display_name" type="text" class="form-control @error('display_name') is-invalid @enderror" name="display_name" value="{{ isset($result) ? $result['display_name'] : old('display_name') }}" placeholder="Role Display Name" required autocomplete="off">
        @error('display_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <textarea name="description" id="discription" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Role Description" autocomplete="off">{{ isset($result) ? $result['description'] : old('description') }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>