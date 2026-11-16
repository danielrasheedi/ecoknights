@extends($layout)
@section('content')
    <h1>Create profile</h1>
    
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

    <form method="POST" action="{{ route('post-create-profile') }}">
        @csrf
        
        <div>
            <label for="UserID">User ID: *</label>
            <input type="text" 
                   id="UserID" 
                   name="UserID" 
                   value="{{ old('UserID') }}"
                   maxlength="12"
                   required>
        </div>
        
        <div>
            <label for="UserEmail">Email: *</label>
            <input type="email" 
                   id="UserEmail" 
                   name="UserEmail" 
                   value="{{ old('UserEmail') }}"
                   maxlength="255"
                   required>
        </div>
        
        <div>
            <label for="UserPassword">Password: *</label>
            <input type="password" 
                   id="UserPassword" 
                   name="UserPassword" 
                   minlength="8"
                   maxlength="64"
                   required>
        </div>
        
        <div>
            <label for="UserPassword_confirmation">Confirm password: *</label>
            <input type="password" 
                   id="UserPassword_confirmation" 
                   name="UserPassword_confirmation" 
                   minlength="8"
                   maxlength="64"
                   required>
        </div>
    
        <div>
            <label for="UserFullName">Full name:</label>
            <input type="text" 
                   id="UserFullName" 
                   name="UserFullName" 
                   value="{{ old('UserFullName') }}"
                   maxlength="80">
        </div>
        
        <div>
            <label for="UserDateOfBirth">Date of birth:</label>
            <input type="date" 
                   id="UserDateOfBirth" 
                   name="UserDateOfBirth" 
                   value="{{ old('UserDateOfBirth') }}">
        </div>
        
        <div>
            <label for="UserGender">Gender:</label>
            <select id="UserGender" name="UserGender">
                <option value=""></option>
                <option value="Male" {{ old('UserGender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('UserGender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        
        <div>
            <label for="UserPhoneNumber">Phone number:</label>
            <input type="text" 
                   id="UserPhoneNumber" 
                   name="UserPhoneNumber" 
                   value="{{ old('UserPhoneNumber') }}"
                   maxlength="20">
        </div>
        
        <div>
            <label for="UserAddress">Address:</label>
            <textarea id="UserAddress" 
                      name="UserAddress" 
                      maxlength="300" 
                      rows="3">{{ old('UserAddress') }}</textarea>
        </div>
        
        <div>
            <label for="UserOccupation">Occupation:</label>
            <input type="text" 
                   id="UserOccupation" 
                   name="UserOccupation" 
                   value="{{ old('UserOccupation') }}"
                   maxlength="100">
        </div>
        
        <div>
            <label for="UserTransport">Transportation:</label>
            <select id="UserTransport" name="UserTransport">
                <option value=""></option>
                <option value="I have my own vehicle" {{ old('UserTransport') == 'I have my own vehicle' ? 'selected' : '' }}>I have my own vehicle</option>
                <option value="I can arrange my own transport" {{ old('UserTransport') == 'I can arrange my own transport' ? 'selected' : '' }}>I can arrange my own transport</option>
                <option value="I rely on public transport" {{ old('UserTransport') == 'I rely on public transport' ? 'selected' : '' }}>I rely on public transport</option>
                <option value="I do not have reliable transportation" {{ old('UserTransport') == 'I do not have reliable transportation' ? 'selected' : '' }}>I do not have reliable transportation</option>
            </select>
        </div>
        
        <div>
            <label for="UserShirtSize">Shirt size:</label>
            <select id="UserShirtSize" name="UserShirtSize">
                <option value=""></option>
                <option value="XS" {{ old('UserShirtSize') == 'XS' ? 'selected' : '' }}>XS</option>
                <option value="S" {{ old('UserShirtSize') == 'S' ? 'selected' : '' }}>S</option>
                <option value="M" {{ old('UserShirtSize') == 'M' ? 'selected' : '' }}>M</option>
                <option value="L" {{ old('UserShirtSize') == 'L' ? 'selected' : '' }}>L</option>
                <option value="XL" {{ old('UserShirtSize') == 'XL' ? 'selected' : '' }}>XL</option>
                <option value="XXL" {{ old('UserShirtSize') == 'XXL' ? 'selected' : '' }}>XXL</option>
            </select>
        </div>
        
        <div>
            <label for="UserDietaryRequirements">Dietary requirements:</label>
            <input type="text" 
                   id="UserDietaryRequirements" 
                   name="UserDietaryRequirements" 
                   value="{{ old('UserDietaryRequirements') }}"
                   maxlength="200">
        </div>
        
        <div>
            <label for="UserMedicalConditions">Medical conditions:</label>
            <input type="text" 
                   id="UserMedicalConditions" 
                   name="UserMedicalConditions" 
                   value="{{ old('UserMedicalConditions') }}"
                   maxlength="300">
        </div>
        
        <div>
            <label for="UserSkillsAndExperiences">Skills and experiences:</label>
            <textarea id="UserSkillsAndExperiences" 
                      name="UserSkillsAndExperiences" 
                      rows="3">{{ old('UserSkillsAndExperiences') }}</textarea>
        </div>
        
        <div>
            <label for="UserRole">Role: *</label>
            <select id="UserRole" name="UserRole" required>
                <option value=""></option>
                <option value="Volunteer" {{ old('UserRole') == 'Volunteer' ? 'selected' : '' }}>Volunteer</option>
                <option value="Event Coordinator" {{ old('UserRole') == 'Event Coordinator' ? 'selected' : '' }}>Event Coordinator</option>
                <option value="Administrator" {{ old('UserRole') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
            </select>
        </div>

        <div>
            <button type="submit">Create</button>
            <button type="button" onclick="window.location.href='{{ route('get-read-profile') }}'">Cancel</button>
        </div>
    </form>
    
    <p>* Required fields</p>
@endsection