@extends('layouts.app')

@section('page-title', 'Edit User')

@section('content')
<div class="form-container">
    <div class="form-title"><img src="{{ asset('IconKey.png') }}" alt="user icon" class="form-icon"> Edit User</div>

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

    <form method="POST" action="{{ url('/users/' . $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Password (Leave blank to keep current)</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation">
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update User</button>
            <a href="{{ url('/users') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
            <h1>👨‍💼 Edit User</h1>

            @if ($errors->any())
                <div class="error-message">
                    <strong>Please fix the errors below:</strong>
                    <ul style="margin-top: 10px; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/users/' . $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="e.g., John Smith" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="e.g., john@example.com" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Leave blank to keep current">
                        <div class="help-text">Leave empty to keep the current password</div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g., (555) 123-4567">
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit">Update User</button>
                    <a href="{{ url('/users') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
