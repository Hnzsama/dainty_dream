@extends('layouts.app')

@section('page-title', 'Suppliers')

@section('content')
<div class="products-container">
    <div class="products-header">
        <div class="products-title-section">
            <h1 class="products-title">Suppliers</h1>
            <p class="products-description">Manage and organize your supplier contacts</p>
        </div>
        <button onclick="openAddSupplierModal()" class="btn-add">+ Add</button>
    </div>

    <div class="search-bar-wrapper">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" id="searchInput" class="search-input" placeholder="Search suppliers..." value="{{ request('search', '') }}" onkeyup="searchData(event)">
    </div>

    <div class="table-container products-table-container">
        @if ($suppliers->count() > 0)
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="recordsTableBody">
                    @foreach ($suppliers as $supplier)
                        <tr class="product-row" data-product-name="{{ strtolower($supplier->name) }}">
                            <td><strong>{{ $supplier->name }}</strong></td>
                            <td>{{ $supplier->phone ?? '-' }}</td>
                            <td>{{ $supplier->address ?? '-' }}</td>
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <button 
                                        class="btn-edit" 
                                        data-supplier-id="{{ $supplier->id }}"
                                        data-name="{{ $supplier->name }}"
                                        data-address="{{ $supplier->address }}"
                                        data-phone="{{ $supplier->phone }}"
                                        onclick="openEditSupplierModal(this)">Edit</button>
                                    <form id="deleteForm-{{ $supplier->id }}" method="POST" action="{{ url('/suppliers/' . $supplier->id) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button 
                                        type="button" 
                                        class="btn-delete" 
                                        data-supplier-id="{{ $supplier->id }}"
                                        data-supplier-name="{{ $supplier->name }}"
                                        onclick="openDeleteModal(this.dataset.supplierId, this.dataset.supplierName)">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Showing page <strong>{{ $suppliers->currentPage() }}</strong> of <strong>{{ $suppliers->lastPage() }}</strong> • <strong>{{ $suppliers->total() }}</strong> total suppliers
            </div>
            {{ $suppliers->render('vendor.pagination.custom') }}
        </div>
    @else
        <div class="empty-state">
            <p>No suppliers found</p>
        </div>
    @endif
</div>

<!-- Add Supplier Modal -->
<div id="addSupplierModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><img src="{{ asset('SupplierAdd.png') }}" alt="Supplier" style="width: 20px; height: 20px; margin-right: 8px; object-fit: contain;"> Add New Supplier</h2>
            <button class="modal-close" onclick="closeAddSupplierModal()">&times;</button>
        </div>
        
        <form method="POST" action="{{ url('/suppliers') }}" class="modal-body">
            @csrf

            <div class="form-group">
                <label>Supplier Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="4">{{ old('address') }}</textarea>
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit">Add Supplier</button>
                <button type="button" class="btn-cancel" onclick="closeAddSupplierModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Supplier Modal -->
<div id="editSupplierModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><img src="{{ asset('SupplierAdd.png') }}" alt="Supplier" style="width: 20px; height: 20px; margin-right: 8px; object-fit: contain;"> Edit Supplier</h2>
            <button class="modal-close" onclick="closeEditSupplierModal()">&times;</button>
        </div>
        
        <form id="editSupplierForm" method="POST" class="modal-body">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Supplier Name</label>
                <input type="text" name="name" id="edit_name" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" id="edit_phone">
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" id="edit_address" rows="4"></textarea>
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit">Update Supplier</button>
                <button type="button" class="btn-cancel" onclick="closeEditSupplierModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content delete-modal">
        <div class="modal-body delete-body">
            <p>Are you sure you want to delete <strong id="deleteSupplierName"></strong>?</p>
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
        max-width: 420px;
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
    #addSupplierModal .modal-header h2,
    #editSupplierModal .modal-header h2 {
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
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

    function openAddSupplierModal() {
        document.getElementById('addSupplierModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeAddSupplierModal() {
        document.getElementById('addSupplierModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function openEditSupplierModal(button) {
        const supplierId = button.dataset.supplierId;
        const name = button.dataset.name;
        const address = button.dataset.address;
        const phone = button.dataset.phone;

        document.getElementById('edit_name').value = name;
        document.getElementById('edit_phone').value = phone || '';
        document.getElementById('edit_address').value = address || '';
        document.getElementById('editSupplierForm').action = '/suppliers/' + supplierId;
        
        document.getElementById('editSupplierModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEditSupplierModal() {
        document.getElementById('editSupplierModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    let deleteSupplierId = null;

    function openDeleteModal(supplierId, supplierName) {
        deleteSupplierId = supplierId;
        document.getElementById('deleteSupplierName').textContent = supplierName;
        document.getElementById('deleteModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteSupplierId = null;
        document.getElementById('deleteModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function confirmDelete() {
        if (deleteSupplierId) {
            document.getElementById('deleteForm-' + deleteSupplierId).submit();
        }
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const addModal = document.getElementById('addSupplierModal');
        const editModal = document.getElementById('editSupplierModal');
        const deleteModal = document.getElementById('deleteModal');
        if (event.target == addModal) {
            closeAddSupplierModal();
        }
        if (event.target == editModal) {
            closeEditSupplierModal();
        }
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAddSupplierModal();
            closeEditSupplierModal();
            closeDeleteModal();
        }
    });

    // Show modal if there are validation errors
    document.addEventListener('DOMContentLoaded', function() {
        if (hasErrors) {
            openAddSupplierModal();
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
