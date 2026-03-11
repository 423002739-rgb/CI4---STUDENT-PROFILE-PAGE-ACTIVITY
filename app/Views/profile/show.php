<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Profile</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <!-- Profile Image Column -->
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <?php if (!empty($user['profile_image'])): ?>
                                    <img src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>" 
                                         alt="Profile Image" 
                                         class="img-fluid rounded-circle" 
                                         style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #007bff;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                                         style="width: 200px; height: 200px; border: 4px solid #007bff;">
                                        <i class="fas fa-user fa-5x text-white"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h4><?= esc($user['name']) ?></h4>
                            <p class="text-muted"><?= esc($user['email']) ?></p>
                            <a href="<?= base_url('profile/edit') ?>" class="btn btn-primary btn-block">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </div>

                        <!-- Profile Details Column -->
                        <div class="col-md-8">
                            <h5 class="mb-3">Student Information</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Student ID:</dt>
                                <dd class="col-sm-8"><?= esc($user['student_id'] ?? 'Not set') ?></dd>

                                <dt class="col-sm-4">Course:</dt>
                                <dd class="col-sm-8"><?= esc($user['course'] ?? 'Not set') ?></dd>

                                <dt class="col-sm-4">Year Level:</dt>
                                <dd class="col-sm-8">
                                    <?php if (!empty($user['year_level'])): ?>
                                        Year <?= esc($user['year_level']) ?>
                                    <?php else: ?>
                                        Not set
                                    <?php endif; ?>
                                </dd>

                                <dt class="col-sm-4">Section:</dt>
                                <dd class="col-sm-8"><?= esc($user['section'] ?? 'Not set') ?></dd>

                                <dt class="col-sm-4">Phone:</dt>
                                <dd class="col-sm-8"><?= esc($user['phone'] ?? 'Not set') ?></dd>

                                <dt class="col-sm-4">Address:</dt>
                                <dd class="col-sm-8"><?= esc($user['address'] ?? 'Not set') ?></dd>
                            </dl>

                            <hr>

                            <h5 class="mb-3">Account Information</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Account Created:</dt>
                                <dd class="col-sm-8">
                                    <?php if (!empty($user['created_at'])): ?>
                                        <?= date('F d, Y h:i A', strtotime($user['created_at'])) ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </dd>

                                <dt class="col-sm-4">Last Updated:</dt>
                                <dd class="col-sm-8">
                                    <?php if (!empty($user['updated_at'])): ?>
                                        <?= date('F d, Y h:i A', strtotime($user['updated_at'])) ?>
                                    <?php else: ?>
                                        Never
                                    <?php endif; ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
