@extends('layouts.app')

@section('page-title', 'Add User')

@section('content')
<div class="form-container">
    <div class="form-title"><img src="{{ asset('IconKey.png') }}" alt="user icon" class="form-icon"> Add New User</div>

    @if ($errors->any())
        <div style="background: #FFE8E8; color: #A04040; padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #F5A8A8;">
            <strong>Please fix the errors below:</strong>
            <ul style="margin-top: 10px; margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/users') }}">
        @csrf

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Add User</button>
            <a href="{{ url('/users') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
