<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mofu Cafe Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Palet Warna Mofusand (versi final) */
            --mofu-blue-bg: #e0f2f7;
            --mofu-sidebar-bg: #7096b6;
            --mofu-blue-text: #5a7d9a;
            --mofu-dark-text: #303f56;
            --mofu-text-muted: #6c757d;
            --mofu-yellow-accent: #ffb347;
            --mofu-light-border: #d0e6ed;
            --mofu-shadow-soft: rgba(0, 0, 0, 0.04);
            --card-bg: #ffffff;
        }

        body {
            margin: 0;
            background-color: var(--mofu-blue-bg);
            font-family: 'Quicksand', sans-serif;
            font-weight: 500;
            color: var(--mofu-dark-text);
        }

        /* ===== SIDEBAR ===== */
        .page-wrapper {
            display: flex;
        }

        .sidebar {
            width: 260px;
            background-color: var(--mofu-sidebar-bg);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar .brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            margin-bottom: 2rem;
            text-decoration: none;
        }

        .sidebar .nav-title {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255, 255, 255, 0.85);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.15);
            color: #ffffff;
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--mofu-yellow-accent);
            color: var(--mofu-dark-text);
        }

        .sidebar .sidebar-footer {
            margin-top: auto;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 1.5rem;
        }

        .content-header {
            background-color: var(--card-bg);
            border: 1px solid var(--mofu-light-border);
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px 0 var(--mofu-shadow-soft);
            margin-bottom: 1.5rem;
        }

        .content-card {
            background: var(--card-bg);
            border: 1px solid var(--mofu-light-border);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 var(--mofu-shadow-soft);
            color: var(--mofu-dark-text);
            padding: 1.5rem;
        }

           .header-profile-image {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--mofu-light-border);
        }

        /* ===== CUSTOM BUTTON ===== */
        .btn-add-new {
            background-color: #ffffff;
            color: var(--mofu-yellow-accent);
            border: 1px solid var(--mofu-yellow-accent);
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-add-new:hover {
            background-color: var(--mofu-dark-text);
            color: #ffffff;
            border-color: var(--mofu-dark-text);
        }

        /* ===== KPI Cards ===== */
        .kpi-card .card-body {
            display: flex;
            align-items: center;
        }

        .kpi-card .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 15px;
            color: white;
        }

        .kpi-card .icon-circle.bg-success { background-color: #6fb07f !important; }
        .kpi-card .icon-circle.bg-primary { background-color: var(--mofu-blue-text) !important; }
        .kpi-card .icon-circle.bg-warning { background-color: var(--mofu-yellow-accent) !important; }
        .kpi-card .icon-circle.bg-danger { background-color: #e57373 !important; }

        /* ===== TABLE ===== */
        .table thead {
            background-color: var(--mofu-blue-text);
            color: white;
        }

        .table tbody tr:hover {
            background-color: var(--mofu-blue-bg);
        }

        /* ===== PAGINATION ===== */
        .pagination .page-item .page-link {
            color: var(--mofu-blue-text);
            border-color: var(--mofu-light-border);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--mofu-blue-text);
            border-color: var(--mofu-blue-text);
            color: white;
        }

        .pagination .page-item .page-link:hover {
            background-color: var(--mofu-blue-bg);
            border-color: var(--mofu-blue-text);
            color: var(--mofu-dark-text);
        }

        /* ===== FOOTER ===== */
        .app-footer {
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
        }

        .footer-image {
            width: 100%;
            height: auto;
            opacity: 0.9;
        }

    </style>
    @stack('styles')
</head>
<body>

<div class="page-wrapper">
    @include('layouts.partials.sidebar')

    <div class="page-content">
        @include('layouts.partials.content-header')

        <main class="main-content">
            @yield('content')
        </main>
    </div>
</div>

{{-- Logout Button --}}
<div style="display: flex; justify-content: flex-end;">
<form action="{{ route('logout') }}" method="POST">
    @csrf 
    <button type="submit" class="btn btn-danger">
        Logout
    </button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>
