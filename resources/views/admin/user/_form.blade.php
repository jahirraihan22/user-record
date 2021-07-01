<div class="form-group">
    <label for="f_name">First Name : &nbsp;</label>
    <input type="text" class="form-control" name="f_name" id="f_name"
        value="{{ old('f_name', isset($user) ? $user->f_name : null) }}" placeholder="First name">
</div>
@error('f_name') <small class="text-danger">{{ $message }}</small> @enderror

<div class="form-group">
    <label for="l_name">Last Name : &nbsp;</label>
    <input type="text" class="form-control" name="l_name" id="l_name"
        value="{{ old('l_name', isset($user) ? $user->l_name : null) }}" placeholder="Last name">
</div>
@error('l_name') <small class="text-danger">{{ $message }}</small> @enderror

<div class="form-group">
    <label for="phone">Phone : &nbsp;</label>
    <input type="tel" class="form-control" name="phone" id="phone"
        value="{{ old('phone', isset($user) ? $user->phone : null) }}" placeholder="Phone number">
</div>
@error('phone') <small class="text-danger">{{ $message }}</small> @enderror

<div class="form-group">
    <label for="email">Email : &nbsp;</label>
    <input type="email" class="form-control" name="email" id="email"
        value="{{ old('email', isset($user) ? $user->email : null) }}" placeholder="Email address">
</div>
@error('email') <small class="text-danger">{{ $message }}</small> @enderror


<div class="form-group">
    <label for="address">Address : &nbsp;</label>
    <textarea class="form-control" name="address" id="address"
        placeholder="Address">{{ old('address', isset($user) ? $user->address : null) }}</textarea>
</div>



<div class="form-group">
    <label for="image" class="form-check-label"><b>Image : </b>&nbsp;</label>
    <input type="file" name="image" class="form-control-file" @if (old('image', isset($user) ? $user->image : null) == true) checked @endif
        value="1" id="image">
</div>
@error('image') <small class="text-danger">{{ $message }}</small> @enderror
