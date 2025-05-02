<form action="{{ route('traveler.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="text" name="name" placeholder="Full Name" value="{{ old('name', $traveler->name ?? '') }}">
    <input type="text" name="display_name" placeholder="Display Name" value="{{ old('display_name', $details->display_name ?? '') }}">
    <input type="email" name="email" placeholder="Email" value="{{ old('email', $traveler->email ?? '') }}">
    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone', $details->phone ?? '') }}">
    <input type="date" name="dob" value="{{ old('dob', $details->dob ?? '') }}">
    <input type="text" name="nationality" placeholder="Nationality" value="{{ old('nationality', $details->nationality ?? '') }}">
    <select name="gender">
        <option value="">Select Gender</option>
        <option value="male" {{ (old('gender', $details->gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
        <option value="female" {{ (old('gender', $details->gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
    </select>
    <input type="text" name="passport_details" placeholder="Passport Details" value="{{ old('passport_details', $details->passport_details ?? '') }}">
    <textarea name="address" placeholder="Address">{{ old('address', $details->address ?? '') }}</textarea>
    <input type="file" name="profile_picture">

    <button type="submit">Update Profile</button>
</form>
