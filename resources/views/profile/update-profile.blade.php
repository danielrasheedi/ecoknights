@extends($layout)
@section('content')
    <h1>Update profile</h1>
    
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ session('user_role') === 'Administrator' && isset($user) ? route('post-administrator-update-profile', $user->UserID) : route('post-update-profile') }}">
        @csrf
        @method('PUT')
        
        <div>
            <label for="UserFullName">Full name: *</label>
            <input type="text" 
                   id="UserFullName" 
                   name="UserFullName" 
                   value="{{ old('UserFullName', $user->UserFullName ?? '') }}"
                   maxlength="80"
                   required>
        </div>
        
        <div>
            <label for="UserDateOfBirth">Date of birth: *</label>
            <input type="date" 
                   id="UserDateOfBirth" 
                   name="UserDateOfBirth" 
                   value="{{ old('UserDateOfBirth', $user->UserDateOfBirth ? $user->UserDateOfBirth->format('Y-m-d') : '') }}"
                   required>
        </div>
        
        <div>
            <label for="UserGender">Gender: *</label>
            <select id="UserGender" name="UserGender" required>
                <option value="">Select gender</option>
                <option value="Male" {{ (old('UserGender') ?? $user->UserGender ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ (old('UserGender') ?? $user->UserGender ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        
        <div>
            <label for="UserEmail">Email: *</label>
            <input type="email" 
                   id="UserEmail" 
                   name="UserEmail" 
                   value="{{ old('UserEmail', $user->UserEmail ?? '') }}"
                   maxlength="255"
                   required>
        </div>
        
        <div>
            <label for="UserPhoneNumber">Phone number: *</label>
            <input type="text" 
                   id="UserPhoneNumber" 
                   name="UserPhoneNumber" 
                   value="{{ old('UserPhoneNumber', $user->UserPhoneNumber ?? '') }}"
                   maxlength="20"
                   required>
        </div>
        
        <div>
            <label for="UserAddress">Address: *</label>
            <textarea id="UserAddress" 
                      name="UserAddress" 
                      maxlength="300" 
                      rows="3"
                      required>{{ old('UserAddress', $user->UserAddress ?? '') }}</textarea>
        </div>
        
        <div>
            <label for="UserOccupation">Occupation: *</label>
            <input type="text" 
                   id="UserOccupation" 
                   name="UserOccupation" 
                   value="{{ old('UserOccupation', $user->UserOccupation ?? '') }}"
                   maxlength="100"
                   required>
        </div>
        
        <div>
            <label for="UserTransport">Transportation: *</label>
            <select id="UserTransport" name="UserTransport" required>
                <option value="">Select transportation</option>
                <option value="I have my own vehicle" {{ (old('UserTransport') ?? $user->UserTransport ?? '') === 'I have my own vehicle' ? 'selected' : '' }}>I have my own vehicle</option>
                <option value="I can arrange my own transport" {{ (old('UserTransport') ?? $user->UserTransport ?? '') === 'I can arrange my own transport' ? 'selected' : '' }}>I can arrange my own transport</option>
                <option value="I rely on public transport" {{ (old('UserTransport') ?? $user->UserTransport ?? '') === 'I rely on public transport' ? 'selected' : '' }}>I rely on public transport</option>
                <option value="I do not have reliable transportation" {{ (old('UserTransport') ?? $user->UserTransport ?? '') === 'I do not have reliable transportation' ? 'selected' : '' }}>I do not have reliable transportation</option>
            </select>
        </div>
        
        <div>
            <label for="UserShirtSize">Shirt size: *</label>
            <select id="UserShirtSize" name="UserShirtSize" required>
                <option value="">Select shirt size</option>
                <option value="XS" {{ (old('UserShirtSize') ?? $user->UserShirtSize ?? '') === 'XS' ? 'selected' : '' }}>XS</option>
                <option value="S" {{ (old('UserShirtSize') ?? $user->UserShirtSize ?? '') === 'S' ? 'selected' : '' }}>S</option>
                <option value="M" {{ (old('UserShirtSize') ?? $user->UserShirtSize ?? '') === 'M' ? 'selected' : '' }}>M</option>
                <option value="L" {{ (old('UserShirtSize') ?? $user->UserShirtSize ?? '') === 'L' ? 'selected' : '' }}>L</option>
                <option value="XL" {{ (old('UserShirtSize') ?? $user->UserShirtSize ?? '') === 'XL' ? 'selected' : '' }}>XL</option>
                <option value="XXL" {{ (old('UserShirtSize') ?? $user->UserShirtSize ?? '') === 'XXL' ? 'selected' : '' }}>XXL</option>
            </select>
        </div>
        
        <div>
            <label for="UserDietaryRequirements">Dietary requirements:</label>
            <input type="text" 
                   id="UserDietaryRequirements" 
                   name="UserDietaryRequirements" 
                   value="{{ old('UserDietaryRequirements', $user->UserDietaryRequirements ?? '') }}"
                   maxlength="200">
        </div>
        
        <div>
            <label for="UserMedicalConditions">Medical conditions:</label>
            <input type="text" 
                   id="UserMedicalConditions" 
                   name="UserMedicalConditions" 
                   value="{{ old('UserMedicalConditions', $user->UserMedicalConditions ?? '') }}"
                   maxlength="300">
        </div>
        
        <div>
            <label for="UserSkillsAndExperiences">Skills and experiences: *</label>
            <textarea id="UserSkillsAndExperiences" 
                      name="UserSkillsAndExperiences" 
                      rows="3"
                      required>{{ old('UserSkillsAndExperiences', $user->UserSkillsAndExperiences ?? '') }}</textarea>
        </div>
        
        @if(session('user_role') === 'Administrator' && $user->UserID !== session('user_id'))
            <div>
                <label for="UserRole">Role: *</label>
                <select id="UserRole" name="UserRole" required>
                    @foreach(['Volunteer', 'Event Coordinator', 'Administrator'] as $role)
                        <option value="{{ $role }}" {{ old('UserRole', $user->UserRole) === $role ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
        @else
            <div>
                <label for="UserRole">Role:</label>
                <input type="text"
                       id="UserRole"
                       value="{{ $user->UserRole ?? '' }}"
                       readonly>
            </div>
        @endif
        
        <div>
            <button type="submit">Update</button>
            @if(session('user_role') === 'Administrator')
                <button type="button" onclick="window.location.href='{{ route('get-read-profile') }}'">Cancel</button>
            @endif
        </div>
    </form>
    
    <p>* Required fields</p>
@endsection