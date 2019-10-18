<div class="form-group">
	<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
		value="{{ isset($result) ? $result['name'] : old('name') }}" placeholder="Name" required
		autocomplete="off" disabled>
	@error('name')
	<span class="invalid-feedback" role="alert">
		<strong>{{ $message }}</strong>
	</span>
	@enderror
</div>

<div class="form-group">
	<input id="display_name" type="text" class="form-control @error('display_name') is-invalid @enderror" name="display_name"
		value="{{ isset($result) ? $result['display_name'] : old('display_name') }}" placeholder="Display Name" required
		autocomplete="off">
	@error('display_name')
	<span class="invalid-feedback" role="alert">
		<strong>{{ $message }}</strong>
	</span>
	@enderror
</div>

<div class="form-group">
	<input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description"
		value="{{ isset($result) ? $result['description'] : old('description') }}" placeholder="Description" required
		autocomplete="off">
	@error('description')
	<span class="invalid-feedback" role="alert">
		<strong>{{ $message }}</strong>
	</span>
	@enderror
</div>