<aside class="app-sidebar shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= base_url() ?>" class="brand-link d-flex align-items-center gap-2 text-decoration-none">
            <div style="width:32px;height:32px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-grid-fill text-white" style="font-size:.9rem;"></i>
            </div>
            <span class="brand-text">StarterPanel</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <?php $role = session('user')['role'] ?? 'guest'; ?>
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">

                <?php if ($role === 'student'): ?>
                <li class="nav-header">Main</li>
                <li class="nav-item">
                    <a href="<?= base_url('student/dashboard') ?>" class="nav-link <?= ($segment ?? '') === 'student' ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">Account</li>
                <li class="nav-item">
                    <a href="<?= base_url('profile') ?>" class="nav-link <?= ($segment ?? '') === 'profile' ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>My Profile</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if ($role === 'teacher' || $role === 'admin'): ?>
                <li class="nav-header">Main</li>
                <li class="nav-item <?= in_array($segment ?? '', ['dashboard','dashboard-v2','dashboard-v3']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($segment ?? '', ['dashboard','dashboard-v2','dashboard-v3']) ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard <i class="nav-arrow bi bi-chevron-right ms-auto"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= ($segment ?? '') === 'dashboard' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-circle"></i><p>Dashboard v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard-v2') ?>" class="nav-link <?= ($segment ?? '') === 'dashboard-v2' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-circle"></i><p>Dashboard v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard-v3') ?>" class="nav-link <?= ($segment ?? '') === 'dashboard-v3' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-circle"></i><p>Dashboard v3</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Management</li>
                <li class="nav-item">
                    <a href="<?= base_url('students') ?>" class="nav-link <?= ($segment ?? '') === 'students' ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Students</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if ($role === 'admin'): ?>
                <li class="nav-header">Admin</li>
                <li class="nav-item">
                    <a href="<?= base_url('users') ?>" class="nav-link <?= ($segment ?? '') === 'users' ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-person-gear"></i>
                        <p>User Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('menu-management') ?>" class="nav-link <?= ($segment ?? '') === 'menu-management' ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-layout-text-sidebar"></i>
                        <p>Menu Management</p>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</aside>
