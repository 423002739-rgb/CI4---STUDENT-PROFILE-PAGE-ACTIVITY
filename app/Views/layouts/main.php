<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $title ?? 'StarterPanel' ?> — CI4</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="<?= base_url('css/adminlte.css') ?>" />
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #6366f1;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --header-bg: #ffffff;
            --header-border: #e2e8f0;
            --body-bg: #f1f5f9;
            --card-bg: #ffffff;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background: var(--body-bg) !important;
        }

        /* ── Sidebar ── */
        .app-sidebar {
            background: var(--sidebar-bg) !important;
            width: var(--sidebar-width) !important;
            border-right: none !important;
            box-shadow: 4px 0 24px rgba(0,0,0,0.15) !important;
        }

        .sidebar-brand {
            background: var(--sidebar-bg) !important;
            border-bottom: 1px solid #1e293b !important;
            padding: 1.25rem 1.5rem !important;
        }

        .brand-text {
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            letter-spacing: -0.3px;
        }

        .sidebar-wrapper { background: var(--sidebar-bg) !important; }

        .nav-header {
            font-size: 0.65rem !important;
            font-weight: 700 !important;
            letter-spacing: 1.5px !important;
            color: #475569 !important;
            padding: 1.25rem 1.25rem 0.4rem !important;
            text-transform: uppercase;
        }

        .nav-item .nav-link {
            color: var(--sidebar-text) !important;
            border-radius: 8px !important;
            margin: 2px 10px !important;
            padding: 0.6rem 1rem !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .nav-item .nav-link:hover {
            background: var(--sidebar-hover) !important;
            color: #ffffff !important;
        }

        .nav-item .nav-link.active {
            background: var(--sidebar-active) !important;
            color: var(--sidebar-text-active) !important;
            box-shadow: 0 4px 12px rgba(99,102,241,0.35) !important;
        }

        .nav-icon { font-size: 1rem !important; width: 1.2rem; text-align: center; }

        /* ── Header ── */
        .app-header {
            background: var(--header-bg) !important;
            border-bottom: 1px solid var(--header-border) !important;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06) !important;
            height: 60px !important;
        }

        .app-header .nav-link { color: #64748b !important; }
        .app-header .nav-link:hover { color: var(--accent) !important; }

        /* ── Main content ── */
        .app-main { background: var(--body-bg) !important; }

        .app-content-header {
            background: transparent !important;
            padding: 1.5rem 0 0 !important;
            border-bottom: none !important;
        }

        .app-content { padding-top: 1rem !important; }

        /* ── Cards ── */
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04) !important;
            background: var(--card-bg) !important;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.1rem 1.5rem !important;
            font-weight: 600 !important;
        }

        .card-body { padding: 1.5rem !important; }

        /* ── Buttons ── */
        .btn-primary {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
        }
        .btn-primary:hover {
            background: var(--accent-hover) !important;
            border-color: var(--accent-hover) !important;
        }
        .btn { border-radius: 8px !important; font-weight: 500 !important; }

        /* ── Tables ── */
        .table { font-size: 0.875rem !important; }
        .table thead th {
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            color: #64748b !important;
            border-bottom: 2px solid #e2e8f0 !important;
            background: #f8fafc !important;
        }

        /* ── Footer ── */
        .app-footer {
            background: var(--header-bg) !important;
            border-top: 1px solid var(--header-border) !important;
            font-size: 0.8rem !important;
            color: #94a3b8 !important;
        }

        /* ── Badges ── */
        .badge { border-radius: 6px !important; font-weight: 500 !important; }

        /* ── Form controls ── */
        .form-control, .form-select {
            border-radius: 8px !important;
            border-color: #e2e8f0 !important;
            font-size: 0.875rem !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15) !important;
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <?= $this->include('layouts/header') ?>
        <?= $this->include('layouts/sidebar') ?>
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <?= $this->include('components/alerts') ?>
                    <?= $this->renderSection('breadcrumb') ?>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>
        <?= $this->include('layouts/footer') ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('js/adminlte.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sw = document.querySelector('.sidebar-wrapper');
            if (sw && OverlayScrollbarsGlobal?.OverlayScrollbars) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sw, {
                    scrollbars: { theme: 'os-theme-light', autoHide: 'leave', clickScroll: true }
                });
            }
        });
    </script>
    <?= $this->renderSection('javascript') ?>
</body>
</html>
