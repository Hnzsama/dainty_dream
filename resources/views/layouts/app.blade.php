<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dainty Dream - Inventory Management')</title>
    <link rel="icon" type="image/png" href="{{ asset('iconDainty.png') }}">

    <!-- Open Graph / WhatsApp Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Dainty Dream - Inventory Management')">
    <meta property="og:description" content="Sistem manajemen inventaris butik Dainty Dream. Kelola produk, kategori, supplier, customer, dan transaksi masuk/keluar secara efisien.">
    <meta property="og:image" content="{{ asset('iconDainty.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('iconDainty.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
    <meta name="description" content="Sistem manajemen inventaris butik Dainty Dream. Kelola produk, kategori, supplier, customer, dan transaksi masuk/keluar secara efisien.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #B4E7FF;
            --primary-dark: #8ADBFF;
            --primary-light: #E8F4FF;
            --secondary: #D4BAFF;
            --secondary-dark: #C5B3E0;
            --secondary-light: #EDD9FF;
            --accent: #F4A8D4;
            --accent-light: #FFD9E8;
            --bg-light: #F5ECFF;
            --bg-white: #FAFBFE;
            --bg-gradient-1: #F5E6FF;
            --bg-gradient-2: #E8D7FF;
            --bg-gradient-3: #D5E8FF;
            --text-dark: #7C6BA8;
            --text-gray: #B8A8D8;
            --border-light: #E8D7FF;
            --success: #A8E6B8;
            --warning: #FFD9A8;
            --danger: #F5A8A8;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #EFF6FF;
            color: var(--text-dark);
        }

        /* Hide scrollbar while keeping functionality */
        body::-webkit-scrollbar {
            display: none;
        }

        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .container-layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: #FFFFFF;
            border-right: 1px solid #E8D7FF;
            padding: 20px 0;
            box-shadow: 2px 0 15px rgba(197, 179, 224, 0.08);
            display: flex;
            flex-direction: column;
            height: 100vh;
            animation: slideInLeft 0.6s ease-out;
        }

        .sidebar-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 0px 15px 30px;
            border-bottom: none;
            margin: 0;
            font-size: 12px;
            font-weight: 500;
            color: #44474E;
            flex-shrink: 0;
            text-align: center;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .sidebar-logo-icon {
            width: 100%;
            height: auto;
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            object-fit: contain;
        }

        .sidebar-section {
            padding: 0 0;
            margin-bottom: 0;
            flex-shrink: 0;
        }

        .sidebar-section-title {
            display: none;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            margin: 4px 12px;
            border-left: none;
            border-radius: 10px;
            text-decoration: none;
            color: #A9AAB2;
            transition: all 0.3s ease;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
        }

        .sidebar-link:hover {
            background: #F0F0F5;
            color: #4A90E2;
            transform: none;
        }

        .sidebar-link.active {
            background: #E8F1FF;
            color: #4A90E2;
            border-left: none;
            border-right: 4px solid #4A90E2;
        }

        .sidebar-link img {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .sidebar-link.active img {
            content: '';
        }

        .sidebar-logout {
            margin-top: auto;
            padding: 30px 12px 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 10px 12px;
            background: #E8C1D1;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #D4A8BE;
        }

        .sidebar-footer-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            margin: 4px 12px;
            text-decoration: none;
            color: #A9AAB2;
            transition: all 0.3s ease;
            font-size: 12px;
            font-weight: 500;
            border-radius: 10px;
        }

        .sidebar-footer-link:hover {
            background: #F0F0F5;
            color: #4A90E2;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .top-bar {
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-light);
            padding: 5px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(197, 179, 224, 0.08);
            min-height: 40px;
        }

        .page-title {
            display: none;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }

        .notification-icon {
            width: 20px;
            height: 20px;
            color: var(--text-dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
        }

        .notification-icon:hover {
            color: var(--primary);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-info {
            display: none;
        }

        .admin-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .admin-role {
            font-size: 12px;
            color: var(--text-gray);
        }

        .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 10px 20px 20px 20px;
        }

        /* Custom Scrollbar Styling */
        .content::-webkit-scrollbar {
            width: 8px;
        }

        .content::-webkit-scrollbar-track {
            background: transparent;
        }

        .content::-webkit-scrollbar-thumb {
            background: #D4BAFF;
            border-radius: 4px;
        }

        .content::-webkit-scrollbar-thumb:hover {
            background: #C5B3E0;
        }

        /* MESSAGES */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #D5F5E8;
            color: #2D6B5F;
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: #FFE8E8;
            color: #8B5555;
            border-left: 4px solid var(--danger);
        }

        /* CARDS */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .summary-card {
            background: var(--bg-white);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(197, 179, 224, 0.15);
        }

        .card-body {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .card-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .card-icon-wrapper img {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }

        .card-content {
            flex: 1;
        }

        .card-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .card-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .card-frequency {
            font-size: 12px;
            color: #3b82f6;
            margin-top: 2px;
        }

        .card-change {
            font-size: 12px;
            margin-top: 8px;
            color: var(--success);
        }

        /* TABLE */
        .table-container {
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            overflow: hidden;
        }

        .table-header {
            padding: 25px;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-inline {
            width: 24px;
            height: 24px;
            display: inline-block;
            vertical-align: middle;
            flex-shrink: 0;
        }

        .btn-add {
            background: #D4BAFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(133, 212, 240, 0.35);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--bg-light);
            border-bottom: 2px solid var(--border-light);
        }

        th {
            padding: 15px 25px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px 25px;
            border-bottom: 1px solid var(--border-light);
            font-size: 14px;
            color: var(--text-dark);
        }

        th:last-child,
        td:last-child {
            text-align: right;
        }

        td:last-child > div {
            justify-content: flex-end;
        }

        tbody tr:hover {
            background: var(--bg-light);
        }

        /* FORMS */
        .form-container {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            max-width: 600px;
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border-light);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: var(--bg-white);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(133, 212, 240, 0.15);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-submit {
            flex: 1;
            background: #D4BAFF;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(133, 212, 240, 0.35);
        }

        .btn-cancel {
            flex: 1;
            background: var(--bg-light);
            color: var(--text-dark);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-cancel:hover {
            background: var(--border-light);
        }

        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: rgba(133, 212, 240, 0.15);
            color: var(--primary);
        }

        .btn-edit:hover {
            background: var(--primary);
            color: white;
        }

        .btn-delete {
            background: rgba(245, 168, 168, 0.2);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
        }

        .error-list {
            background: #FFE8E8;
            color: #8B5555;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--danger);
        }

        .error-list strong {
            display: block;
            margin-bottom: 10px;
        }

        .error-list ul {
            margin-left: 20px;
            font-size: 14px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-gray);
        }

        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* CHART */
        .chart-container {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            margin-bottom: 40px;
        }

        .chart-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        /* PRODUCTS PAGE */
        .products-container {
            padding: 20px;
        }

        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .products-title-section h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 8px 0;
        }

        .products-description {
            font-size: 14px;
            color: var(--text-gray);
            margin: 0;
        }

        .search-bar-wrapper {
            display: flex;
            align-items: center;
            position: relative;
            margin-bottom: 20px;
            max-width: 400px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            width: 20px;
            height: 20px;
            color: #999;
            stroke-width: 2;
        }

        .search-input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-dark);
            background: var(--bg-white);
        }

        .search-input::placeholder {
            color: #999;
        }

        .products-table-container {
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(197, 179, 224, 0.08);
            overflow: hidden;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table thead {
            background: var(--bg-light);
            border-bottom: 2px solid var(--border-light);
        }

        .products-table th {
            padding: 10px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .products-table tbody tr {
            border-bottom: 1px solid var(--border-light);
            transition: background 0.2s ease;
        }

        .products-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .products-table td {
            padding: 10px 15px;
            font-size: 14px;
            color: var(--text-dark);
            vertical-align: middle;
        }

        .products-table th:last-child,
        .products-table td:last-child {
            text-align: right;
        }

        .item-details {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .item-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            overflow: hidden;
            background: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #E8D7FF, #F5E6FF);
            color: #7C6BA8;
            font-weight: 700;
            font-size: 20px;
        }

        .item-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .item-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .item-sku {
            font-size: 12px;
            color: var(--text-gray);
        }

        .category-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            background: rgba(212, 186, 255, 0.3);
            color: #6d28d9;
            text-align: center;
        }

        .stock-level-wrapper {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 150px;
        }

        .stock-progress-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .stock-progress {
            height: 100%;
            background: #3b82f6;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .stock-text {
            font-size: 12px;
            color: var(--text-gray);
        }

        .stock-low {
            color: #ef4444;
        }

        .stock-normal {
            color: var(--text-gray);
        }

        .price {
            font-weight: 600;
            color: var(--text-dark);
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit, .btn-delete {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-edit {
            background: rgba(212, 186, 255, 0.3);
            color: #6d28d9;
        }

        .btn-edit:hover {
            background: rgba(212, 186, 255, 0.5);
        }

        .btn-delete {
            background: rgba(244, 168, 212, 0.3);
            color: #be185d;
        }

        .btn-delete:hover {
            background: rgba(244, 168, 212, 0.5);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-light);
                padding: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .main-content {
                flex: 1;
            }

            .content {
                padding: 20px;
            }

            .top-bar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .page-title {
                font-size: 20px;
            }
        }

        /* NOTIFICATION TOAST */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            pointer-events: none;
        }

        .notification {
            background: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            pointer-events: auto;
            animation: slideIn 0.4s ease-out;
            max-width: 400px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .notification.removing {
            animation: slideOut 0.4s ease-in forwards;
        }

        .notification.success {
            border-left: 4px solid var(--success);
        }

        .notification.success .notification-icon {
            color: var(--success);
        }

        .notification.error {
            border-left: 4px solid var(--danger);
        }

        .notification.error .notification-icon {
            color: var(--danger);
        }

        .notification.info {
            border-left: 4px solid var(--primary);
        }

        .notification.info .notification-icon {
            color: var(--primary);
        }

        .notification-icon {
            flex-shrink: 0;
            font-size: 20px;
        }

        .notification-message {
            color: var(--text-dark);
            font-size: 14px;
            font-weight: 500;
        }

        .notification-close {
            margin-left: auto;
            background: none;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
            font-size: 20px;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-close:hover {
            color: var(--text-dark);
        }
    </style>
</head>
<body>
    <div class="container-layout">
        <!-- SIDEBAR -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <img src="{{ asset('iconDainty.png') }}" alt="Dainty Dream" class="sidebar-logo-icon">
                <span>Inventory Management</span>
            </div>

            <!-- Dashboard -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Main</div>
                <a href="{{ url('/dashboard') }}" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}" data-icon-on="{{ asset('DashboardOnClick.png') }}" data-icon-off="{{ asset('DashboardOffClick.png') }}">
                    @if(request()->is('dashboard'))
                        <img src="{{ asset('DashboardOnClick.png') }}" alt="Dashboard">
                    @else
                        <img src="{{ asset('DashboardOffClick.png') }}" alt="Dashboard">
                    @endif
                    Dashboard
                </a>
            </div>

            <!-- Master Section -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Master Data</div>
                <a href="{{ url('/products') }}" class="sidebar-link {{ request()->is('products*') ? 'active' : '' }}" data-icon-on="{{ asset('ClothingItemOnClick.png') }}" data-icon-off="{{ asset('ClothingItemOffClick.png') }}">
                    @if(request()->is('products*'))
                        <img src="{{ asset('ClothingItemOnClick.png') }}" alt="Clothing Items">
                    @else
                        <img src="{{ asset('ClothingItemOffClick.png') }}" alt="Clothing Items">
                    @endif
                    Clothing Items
                </a>
                <a href="{{ url('/categories') }}" class="sidebar-link {{ request()->is('categories*') ? 'active' : '' }}" data-icon-on="{{ asset('CategoryOnClick.png') }}" data-icon-off="{{ asset('CategoryOffClick.png') }}">
                    @if(request()->is('categories*'))
                        <img src="{{ asset('CategoryOnClick.png') }}" alt="Categories">
                    @else
                        <img src="{{ asset('CategoryOffClick.png') }}" alt="Categories">
                    @endif
                    Categories
                </a>
                <a href="{{ url('/suppliers') }}" class="sidebar-link {{ request()->is('suppliers*') ? 'active' : '' }}" data-icon-on="{{ asset('SupplierOnClick.png') }}" data-icon-off="{{ asset('SupplierOffClick.png') }}">
                    @if(request()->is('suppliers*'))
                        <img src="{{ asset('SupplierOnClick.png') }}" alt="Suppliers">
                    @else
                        <img src="{{ asset('SupplierOffClick.png') }}" alt="Suppliers">
                    @endif
                    Suppliers
                </a>
                <a href="{{ url('/customers') }}" class="sidebar-link {{ request()->is('customers*') ? 'active' : '' }}" data-icon-on="{{ asset('CustomerOnClick.png') }}" data-icon-off="{{ asset('CustomerOffClick.png') }}">
                    @if(request()->is('customers*'))
                        <img src="{{ asset('CustomerOnClick.png') }}" alt="Customers">
                    @else
                        <img src="{{ asset('CustomerOffClick.png') }}" alt="Customers">
                    @endif
                    Customers
                </a>
            </div>

            <!-- Transaction Section -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Transactions</div>
                <a href="{{ url('/incoming') }}" class="sidebar-link {{ request()->is('incoming*') ? 'active' : '' }}" data-icon-on="{{ asset('StockInOnClick.png') }}" data-icon-off="{{ asset('StockInOffClick.png') }}">
                    @if(request()->is('incoming*'))
                        <img src="{{ asset('StockInOnClick.png') }}" alt="Stock In">
                    @else
                        <img src="{{ asset('StockInOffClick.png') }}" alt="Stock In">
                    @endif
                    Stock In
                </a>
                <a href="{{ url('/outgoing') }}" class="sidebar-link {{ request()->is('outgoing*') ? 'active' : '' }}" data-icon-on="{{ asset('StockOutOnClick.png') }}" data-icon-off="{{ asset('StockOutOffClick.png') }}">
                    @if(request()->is('outgoing*'))
                        <img src="{{ asset('StockOutOnClick.png') }}" alt="Stock Out">
                    @else
                        <img src="{{ asset('StockOutOffClick.png') }}" alt="Stock Out">
                    @endif
                    Stock Out
                </a>
            </div>

            <!-- Reports Section (placeholder) -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Reports</div>
                <a href="{{ route('reports.monthly') }}" class="sidebar-link {{ request()->is('reports*') ? 'active' : '' }}" data-icon-on="{{ asset('ReportsOnClick.png') }}" data-icon-off="{{ asset('ReportsOffClick.png') }}">
                    @if(request()->is('reports*'))
                        <img src="{{ asset('ReportsOnClick.png') }}" alt="Reports">
                    @else
                        <img src="{{ asset('ReportsOffClick.png') }}" alt="Reports">
                    @endif
                    Monthly Report
                </a>
            </div>

            <!-- Logout (fixed at bottom) -->
            <div class="sidebar-logout">
                <form method="POST" action="{{ url('/logout') }}" style="display: contents;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <span>Log Out</span>
                    </button>
                </form>
                
                <a href="#" class="sidebar-footer-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.64l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.09-.47 0-.59.22L2.74 8.87c-.12.22-.07.49.12.64l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.64l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.09.47 0 .59-.22l1.92-3.32c.12-.22.07-.49-.12-.64l-2.03-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
                    </svg>
                    Settings
                </a>
                
                <a href="#" class="sidebar-footer-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    Support
                </a>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- TOP BAR -->
            <div class="top-bar">
                <div class="page-title">@yield('page-title', 'Dashboard')</div>
                <div class="top-bar-right">
                    <div class="notification-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                        </svg>
                    </div>
                    <div class="admin-profile">
                        <div class="admin-info">
                            <div class="admin-name">{{ auth()->user()->name }}</div>
                            <div class="admin-role">Administrator</div>
                        </div>
                        <div class="admin-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="content">
                @if (session('msg'))
                    <div class="alert alert-success">
                        ✓ {{ session('msg') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-list">
                        <strong>Please fix the following errors:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notificationContainer" class="notification-container"></div>

    <script>
        function showNotification(message, type = 'success', duration = 3000) {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            
            const icons = {
                success: '✓',
                error: '✕',
                info: 'ℹ'
            };
            
            // Format message: lowercase and remove trailing punctuation
            const formattedMessage = message.toLowerCase().replace(/[!.]+$/, '').replace(/^✓\s*/, '');
            
            notification.innerHTML = `
                <span class="notification-icon">${icons[type] || '●'}</span>
                <span class="notification-message">${formattedMessage}</span>
                <button class="notification-close" onclick="this.parentElement.remove()">×</button>
            `;
            
            container.appendChild(notification);
            
            if (duration > 0) {
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.classList.add('removing');
                        setTimeout(() => notification.remove(), 400);
                    }
                }, duration);
            }
        }

        // Check for success message from session
        document.addEventListener('DOMContentLoaded', function() {
            const alertElement = document.querySelector('.alert.alert-success');
            if (alertElement) {
                const message = alertElement.textContent.trim();
                showNotification(message, 'success');
                alertElement.style.display = 'none';
            }
        });

        // Sidebar icon hover effect
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            
            sidebarLinks.forEach(link => {
                const iconOnClick = link.getAttribute('data-icon-on');
                const iconOffClick = link.getAttribute('data-icon-off');
                const img = link.querySelector('img');
                
                link.addEventListener('mouseenter', function() {
                    if (img && iconOnClick) {
                        img.src = iconOnClick;
                    }
                });
                
                link.addEventListener('mouseleave', function() {
                    if (img && iconOffClick) {
                        const isActive = link.classList.contains('active');
                        img.src = isActive ? iconOnClick : iconOffClick;
                    }
                });
            });
        });
    </script>
</body>
</html>
