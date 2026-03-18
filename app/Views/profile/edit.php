<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $role = session('user')['role'] ?? 'student'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Profile</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    <?php $errors = session()->getFlashdata('errors') ?? []; ?>

                    <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Profile Image -->
                        <div class="text-center mb-4">
                            <?php if (!empty($user['profile_image'])): ?>
                                <img id="preview" src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>"
                                     class="rounded-circle" style="width:150px;height:150px;object-fit:cover;border:4px solid #007bff;">
                            <?php else: ?>
                                <div id="placeholder" class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center"
                                     style="width:150px;height:150px;border:4px solid #007bff;">
                                    <i class="fas fa-user fa-4x text-white"></i>
                                </div>
                                <img id="preview" src="" class="rounded-circle d-none"
                                     style="width:150px;height:150px;object-fit:cover;border:4px solid #007bff;">
                            <?php endif; ?>
                            <div class="mt-2">
                                <input type="file" name="profile_image" id="profile_image" accept="image/*" onchange="previewImage(event)">
                                <small class="d-block text-muted">JPG, PNG, WEBP — max 2MB</small>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="form-group">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                   value="<?= old('name', esc($user['name'])) ?>" required>
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                   value="<?= old('email', esc($user['email'])) ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <?php if ($role === 'student'): ?>
                        <!-- Student-only fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Student ID</label>
                                    <input type="text" name="student_id" class="form-control"
                                           value="<?= old('student_id', esc($user['student_id'] ?? '')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course</label>
                                    <input type="text" name="course" class="form-control"
                                           value="<?= old('course', esc($user['course'] ?? '')) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Year Level</label>
                                    <select name="year_level" class="form-control">
                                        <option value="">Select Year</option>
                                        <?php foreach (range(1, 5) as $y): ?>
                                            <option value="<?= $y ?>" <?= old('year_level', $user['year_level'] ?? '') == $y ? 'selected' : '' ?>>
                                                Year <?= $y ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Section</label>
                                    <input type="text" name="section" class="form-control"
                                           value="<?= old('section', esc($user['section'] ?? '')) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="<?= old('phone', esc($user['phone'] ?? '')) ?>">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3"><?= old('address', esc($user['address'] ?? '')) ?></textarea>
                        </div>
                        <?php endif; ?>

                        <hr>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                        <a href="<?= base_url('profile') ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        preview.src = e.target.result;
        preview.classList.remove('d-none');
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
}
</script>

<?= $this->endSection() ?>
