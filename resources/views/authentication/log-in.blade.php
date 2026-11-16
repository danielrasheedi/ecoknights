@extends('layout.volunteer')
@section('content')
    <h1>Log in</h1>

    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

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

    <form method="POST" action="{{ route('post-log-in') }}">
        @csrf

        <div>
            <label for="UserEmail">Email:</label>
            <input
                type="email"
                id="UserEmail"
                name="UserEmail"
                value="{{ old('UserEmail') }}"
                maxlength="255"
                required
            >
        </div>

        <div>
            <label for="UserPassword">Password:</label>
            <input
                type="password"
                id="UserPassword"
                name="UserPassword"
                maxlength="64"
                required
            >
        </div>

        <div>
            <button type="submit">Log in</button>
        </div>
    </form>
@endsection