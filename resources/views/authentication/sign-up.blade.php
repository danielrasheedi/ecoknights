@extends('layout.volunteer')
@section('content')
    <h1>Sign up</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
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

    <form method="POST" action="{{ route('post-sign-up') }}">
        @csrf
        
        <div>
            <label for="UserID">Identification card:</label>
            <input type="text" 
                   id="UserID" 
                   name="UserID" 
                   maxlength="12" 
                   required>
        </div>
        
        <div>
            <label for="UserEmail">Email:</label>
            <input type="email" 
                   id="UserEmail" 
                   name="UserEmail" 
                   maxlength="255" 
                   required>
        </div>
        
        <div>
            <label for="UserPassword">Password:</label>
            <input type="password" 
                   id="UserPassword" 
                   name="UserPassword" 
                   minlength="8"
                   maxlength="64" 
                   required>
            <div id="passwordStrength"></div>
        </div>
        
        <div>
            <label for="UserPassword_confirmation">Confirm password:</label>
            <input type="password" 
                   id="UserPassword_confirmation" 
                   name="UserPassword_confirmation" 
                   minlength="8"
                   maxlength="64" 
                   required>
            <div id="passwordMatch"></div>
        </div>
        
        <div>
            <button type="submit">Sign up</button>
        </div>
    </form>

    <script>
        // Password strength indicator
        document.getElementById('UserPassword').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');
            
            let strength = 0;
            let feedback = [];
            
            if (password.length >= 8) strength++;
            else feedback.push('Eight characters');
            
            if (/[A-Z]/.test(password)) strength++;
            else feedback.push('One uppercase letter');
            
            if (/[a-z]/.test(password)) strength++;
            else feedback.push('One lowercase letter');
            
            if (/[0-9]/.test(password)) strength++;
            else feedback.push('One digit');
            
            if (password.length === 0) {
                strengthDiv.innerHTML = '';
            } else if (strength === 0) {
                strengthDiv.innerHTML = 'Very Weak<br>' + feedback.map(item => '· ' + item).join('<br>');
            } else if (strength === 1) {
                strengthDiv.innerHTML = 'Weak<br>' + feedback.map(item => '· ' + item).join('<br>');
            } else if (strength < 4) {
                strengthDiv.innerHTML = 'Medium<br>' + feedback.map(item => '· ' + item).join('<br>');
            } else {
                strengthDiv.innerHTML = 'Strong';
            }
        });

        // Password confirmation matching
        document.getElementById('UserPassword_confirmation').addEventListener('input', function() {
            const password = document.getElementById('UserPassword').value;
            const confirmPassword = this.value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (confirmPassword === '') {
                matchDiv.textContent = '';
            } else if (password === confirmPassword) {
                matchDiv.textContent = 'Passwords match';
            } else {
                matchDiv.textContent = 'Passwords do not match';
            }
        });

        // Also check when original password changes
        document.getElementById('UserPassword').addEventListener('input', function() {
            const confirmPassword = document.getElementById('UserPassword_confirmation').value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (confirmPassword !== '') {
                if (this.value === confirmPassword) {
                    matchDiv.textContent = 'Passwords match';
                } else {
                    matchDiv.textContent = 'Passwords do not match';
                }
            }
        });
    </script>
@endsection