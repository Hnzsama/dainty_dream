@extends('layouts.app')

@section('page-title', 'User Management')

@section('content')
<div class="products-container">
    <div class="products-header">
        <div class="products-title-section">
            <h1 class="products-title">Users</h1>
            <p class="products-description">Manage and organize your user accounts</p>
        </div>
        <a href="{{ url('/users/create') }}" class="btn-add">+ Add</a>
    </div>

    <div class="search-bar-wrapper">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" id="searchInput" class="search-input" placeholder="Search users..." value="{{ request('search', '') }}" onkeyup="searchData(event)">
    </div>

    <div class="table-container products-table-container">
        @if ($users->count() > 0)
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="recordsTableBody">
                    @foreach ($users as $user)
                        <tr class="product-row" data-product-name="{{ strtolower($user->name) }}">
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>{{ ucfirst($user->role ?? 'user') }}</td>
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn-edit">Edit</a>
                                    @if($user->id !== auth()->user()->id)
                                        <form method="POST" action="{{ url('/users/' . $user->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Delete this user?')">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <p>No users found</p>
        </div>
    @endif
</div>

<style>
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-gray);
    }

    .empty-state p {
        font-size: 16px;
        margin: 0;
    }
</style>

<script>
    function searchData(event) {
        if (event.key === 'Enter' || event.type === 'keyup') {
            const searchTerm = document.getElementById('searchInput').value;
            const url = new URL(window.location);
            if (searchTerm) {
                url.searchParams.set('search', searchTerm);
            } else {
                url.searchParams.delete('search');
            }
            window.location = url.toString();
        }
    }
</script>
@endsection
