@extends('layouts.app')

@section('page-title', 'Categories')

@section('content')
<div class="products-container">
    <div class="products-header">
        <div class="products-title-section">
            <h1 class="products-title">Product Categories</h1>
            <p class="products-description">Manage and organize your product categories</p>
        </div>
        <button onclick="openAddCategoryModal()" class="btn-add">+ Add</button>
    </div>

    <div class="search-bar-wrapper">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" id="searchInput" class="search-input" placeholder="Search categories..." value="{{ request('search', '') }}" onkeyup="searchData(event)">
    </div>

    <div class="table-container products-table-container">
        @if ($categories->count() > 0)
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="recordsTableBody">
                    @foreach ($categories as $category)
                        <tr class="product-row" data-product-name="{{ strtolower($category->name) }}">
                            <td><strong>{{ $category->name }}</strong></td>
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <button 
                                        class="btn-edit" 
                                        data-category-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        onclick="openEditCategoryModal(this)">Edit</button>
                                    <form id="deleteForm-{{ $category->id }}" method="POST" action="{{ url('/categories/' . $category->id) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button 
                                        type="button" 
                                        class="btn-delete" 
                                        data-category-id="{{ $category->id }}"
                                        data-category-name="{{ $category->name }}"
                                        onclick="openDeleteModal(this.dataset.categoryId, this.dataset.categoryName)">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Showing page <strong>{{ $categories->currentPage() }}</strong> of <strong>{{ $categories->lastPage() }}</strong> • <strong>{{ $categories->total() }}</strong> total categories
                </div>
                {{ $categories->render('vendor.pagination.custom') }}
            </div>
        @else
            <div class="empty-state">
                <p>No categories found</p>
            </div>
        @endif
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><img src="{{ asset('CategoryAdd.png') }}" alt="Category" style="width: 20px; height: 20px; margin-right: 8px; object-fit: contain;"> Add New Category</h2>
            <button class="modal-close" onclick="closeAddCategoryModal()">&times;</button>
        </div>
        
        <form method="POST" action="{{ url('/categories') }}" class="modal-body">
            @csrf

            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit">Add Category</button>
                <button type="button" class="btn-cancel" onclick="closeAddCategoryModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><img src="{{ asset('CategoryAdd.png') }}" alt="Category" style="width: 20px; height: 20px; margin-right: 8px; object-fit: contain;"> Edit Category</h2>
            <button class="modal-close" onclick="closeEditCategoryModal()">&times;</button>
        </div>
        
        <form id="editCategoryForm" method="POST" class="modal-body">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" id="edit_name" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit">Update Category</button>
                <button type="button" class="btn-cancel" onclick="closeEditCategoryModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content delete-modal">
        <div class="modal-body delete-body">
            <p>Are you sure you want to delete <strong id="deleteCategoryName"></strong>?</p>
            <p class="delete-warning">This action cannot be undone.</p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-delete" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: var(--bg-white);
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 380px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 20px;
        border-bottom: 1px solid var(--border-light);
    }

    .modal-header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header img {
        width: 20px;
        height: 20px;
        object-fit: contain;
    }

    /* Modal Header Text Colors */
    #addCategoryModal .modal-header h2,
    #editCategoryModal .modal-header h2 {
        color: #7c6ba8;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 28px;
        color: var(--text-gray);
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .modal-close:hover {
        background: var(--bg-light);
        color: var(--text-dark);
    }

    .modal-body {
        padding: 15px 20px;
    }

    .modal-footer {
        display: flex;
        gap: 10px;
        padding: 12px 20px;
        border-top: 1px solid var(--border-light);
        justify-content: flex-end;
    }

    .modal-footer .btn-submit,
    .modal-footer .btn-cancel {
        padding: 8px 16px;
        font-size: 13px;
    }

    .error-message {
        display: block;
        color: var(--danger);
        font-size: 12px;
        margin-top: 4px;
    }

    .icon-inline {
        width: 20px;
        height: 20px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 8px;
        stroke: currentColor;
    }

    .icon-large {
        width: 64px;
        height: 64px;
        color: var(--text-gray);
        margin-bottom: 16px;
    }

    .delete-modal {
        max-width: 360px;
    }

    .delete-body {
        text-align: center;
        padding: 20px 15px;
    }

    .delete-body p {
        margin: 10px 0;
        color: var(--text-dark);
    }

    .delete-body strong {
        color: var(--danger);
    }

    .delete-warning {
        font-size: 12px;
        color: var(--text-gray);
        font-style: italic;
    }

    .pagination-wrapper {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin: 0;
        padding: 20px;
        border-top: 1px solid var(--border-light);
        gap: 30px;
        background: var(--bg-white);
    }

    .pagination-info {
        font-size: 14px;
        color: var(--text-dark);
        font-weight: 600;
        letter-spacing: 0.3px;
        margin: 0;
        white-space: nowrap;
    }

    .pagination-info strong {
        color: var(--primary-dark);
        font-size: 16px;
    }

    /* Pagination Styling */
    nav[role="navigation"] {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }

    .pagination {
        display: flex;
        list-style: none;
        gap: 6px;
        padding: 0;
        margin: 0;
        align-items: center;
        justify-content: center;
        flex-wrap: nowrap;
    }

    .pagination li {
        display: inline-flex;
    }

    .pagination span,
    .pagination a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border: 2px solid var(--border-light);
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: var(--bg-white);
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(124, 107, 168, 0.04);
    }

    .pagination a {
        position: relative;
    }

    .pagination a:hover:not(.disabled) {
        background: linear-gradient(135deg, #D4BAFF 0%, #B4E7FF 100%);
        color: white;
        border-color: #D4BAFF;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(212, 186, 255, 0.35);
    }

    .pagination a:active {
        transform: translateY(0);
    }

    /* Current Page Indicator */
    .page-indicator .current-page {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #D4BAFF 0%, #C5B3E0 100%);
        color: white;
        font-weight: 700;
        font-size: 12px;
        border: 2px solid #D4BAFF;
        box-shadow: 0 4px 12px rgba(212, 186, 255, 0.4);
    }

    .pagination .disabled span {
        color: var(--text-gray);
        background: var(--bg-light);
        border-color: #E8D7FF;
        cursor: not-allowed;
        opacity: 0.6;
        box-shadow: none;
    }

    .pagination-arrow {
        font-weight: 700;
        font-size: 13px;
    }

    .pagination .disabled:hover span {
        background: var(--bg-light);
        border-color: #E8D7FF;
        transform: none;
        box-shadow: none;
    }
</style>

<script>
    const hasErrors = '{{ $errors->any() ? "true" : "false" }}' === 'true';

    function openAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function openEditCategoryModal(button) {
        const categoryId = button.dataset.categoryId;
        const name = button.dataset.name;

        document.getElementById('edit_name').value = name;
        document.getElementById('editCategoryForm').action = '/categories/' + categoryId;
        
        document.getElementById('editCategoryModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    let deleteCategoryId = null;

    function openDeleteModal(categoryId, categoryName) {
        deleteCategoryId = categoryId;
        document.getElementById('deleteCategoryName').textContent = categoryName;
        document.getElementById('deleteModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteCategoryId = null;
        document.getElementById('deleteModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function confirmDelete() {
        if (deleteCategoryId) {
            document.getElementById('deleteForm-' + deleteCategoryId).submit();
        }
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const addModal = document.getElementById('addCategoryModal');
        const editModal = document.getElementById('editCategoryModal');
        const deleteModal = document.getElementById('deleteModal');
        if (event.target == addModal) {
            closeAddCategoryModal();
        }
        if (event.target == editModal) {
            closeEditCategoryModal();
        }
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAddCategoryModal();
            closeEditCategoryModal();
            closeDeleteModal();
        }
    });

    // Show modal if there are validation errors
    document.addEventListener('DOMContentLoaded', function() {
        if (hasErrors) {
            openAddCategoryModal();
        }
    });

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
