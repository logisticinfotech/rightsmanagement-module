<div class="form-group">
    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
        value="{{ isset($result) ? $result['name'] : old('name') }}" placeholder="Name" required autocomplete="off">
    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
        value="{{ isset($result) ? $result['email'] : old('email') }}" placeholder="Email" required autocomplete="off">
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <select name="roles[]" id="roles" class="form-control" multiple='multiple'>
        @foreach($roles as $key => $role)
        <option value="{{ $role->name }}"
            {{ (isset($result) && $result['roles']->contains($role->name) ? "selected" : "") }}>
            {{ $role->display_name }}</option>
        @endforeach
    </select>
</div>

@if(!isset($result))
<div class="form-group">
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
        placeholder="{{ __('Password') }}" required autocomplete="new-password">
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
        placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
</div>
@endif

@section("scripts")
<script>
    $(document).ready(() => {
        $('#roles').select2({
            placeholder: "Select Roles",
        });
    });
</script>
@stop
