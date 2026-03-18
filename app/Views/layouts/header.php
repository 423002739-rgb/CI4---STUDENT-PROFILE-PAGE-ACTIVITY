<?php
$sessionUser = session('user') ?? [];
$userName    = $sessionUser['name']  ?? 'User';
$userRole    = $sessionUser['role']  ?? '';
$userEmail   = $sessionUser['email'] ?? '';
$profileImg  = $sessionUser['profile_image'] ?? null;
$avatarSrc   = $profileImg
    ? base_url('uploads/profiles/' . esc($profileImg))
    : base_url('assets/images/avatar4.png');

$roleBadgeColor = match($userRole) {
    'admin'   => 'danger',
    'teacher' => 'warning',
    'student' => 'success',
    default   => 'secondary',
};
?>
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Sidebar toggle + brand -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link px-3" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list fs-5"></i>
                </a>
            </li>
        </ul>

        <!-- Right side -->
        <ul class="navbar-nav ms-auto align-items-center gap-1">
            <!-- Fullscreen -->
            <li class="nav-item">
                <a class="nav-link px-2" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display:none"></i>
                </a>
            </li>

            <!-- User dropdown -->
            <li class="nav-item dropdown ms-2">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2 pe-0" data-bs-toggle="dropdown">
                    <img src="<?= $avatarSrc ?>"
                         class="rounded-circle border border-2"
                         style="width:34px;height:34px;object-fit:cover;border-color:#e2e8f0 !important;"
                         alt="avatar">
                    <div class="d-none d-md-block text-start lh-sm">
                        <div style="font-size:.85rem;font-weight:600;color:#1e293b;"><?= esc($userName) ?></div>
                        <div>
                            <span class="badge bg-<?= $roleBadgeColor ?>" style="font-size:.65rem;">
                                <?= ucfirst($userRole) ?>
                            </span>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width:220px;border-radius:12px;">
                    <li class="px-3 py-2 border-bottom">
                        <div style="font-weight:600;font-size:.875rem;color:#1e293b;"><?= esc($userName) ?></div>
                        <div style="font-size:.78rem;color:#64748b;"><?= esc($userEmail) ?></div>
                    </li>
                    <?php if ($userRole === 'student'): ?>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="<?= base_url('profile') ?>">
                            <i class="bi bi-person-circle text-primary"></i> My Profile
                        </a>
                    </li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
