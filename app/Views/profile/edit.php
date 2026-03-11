<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Profile</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Left Column - Profile Image -->
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label>Profile Image</label>
                                    <div class="mb-3">
                                        <?php if (!empty($user['profile_image'])): ?>
                                            <img id="preview" 
                                                 src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>" 
                                                 alt="Profile Preview" 
                                                 class="img-fluid rounded-circle" 
                                                 style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #007bff;">
                                        <?php else: ?>
                                            <img id="preview" 
                                                 src="<?= base_url('assets/img/default-avatar.png') ?>" 
                                                 alt="Profile Preview" 
                                                 class="img-fluid rounded-circle" 
                                                 style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #007bff; display: none;">
                                            <div id="placeholder" class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 200px; height: 200px; border: 4px solid #007bff;">
                                                <i class="fas fa-user fa-5x text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" 
                                           class="form-control-file" 
                                           id="profile_image" 
                                           name="profile_image" 
                                           accept="image/*"
                                           onchange="previewImage(event)">
                                    <small class="form-text text-muted">
                                        Allowed: JPG, PNG, WEBP (Max 2MB)
                                    </small>
                                </div>
                            </div>

                            <!-- Right Column - Form Fields -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control <?= isset(session('errors')['name']) ? 'is-invalid' : '' ?>" 
                                                   id="name" 
                                                   name="name" 
                                                   value="<?= old('name', esc($user['name'])) ?>" 
                                                   required>
                                            <?php if (isset(session('errors')['name'])): ?>
                                                <div class="invalid-feedback"><?= session('errors')['name'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" 
                                                   class="form-control <?= isset(session('errors')['email']) ? 'is-invalid' : '' ?>" 
                                                   id="email" 
                                                   name="email" 
                                                   value="<?= old('email', esc($user['email'])) ?>" 
                                                   required>
                                            <?php if (isset(session('errors')['email'])): ?>
                                                <div class="invalid-feedback"><?= session('errors')['email'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="student_id">Student ID</label>
                                            <input type="text" 
                                                   class="form-control <?= isset(session('errors')['student_id']) ? 'is-invalid' : '' ?>" 
                                                   id="student_id" 
                                                   name="student_id" 
                                                   value="<?= old('student_id', esc($user['student_id'] ?? '')) ?>" 
                                                   placeholder="e.g., 2024-00123">
                                            <?php if (isset(session('errors')['student_id'])): ?>
                                                <div class="invalid-feedback"><?= session('errors')['student_id'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course">Course</label>
                                            <input type="text" 
                                                   class="form-control <?= isset(session('errors')['course']) ? 'is-invalid' : '' ?>" 
                                                   id="course" 
                                                   name="course" 
                                                   value="<?= old('course', esc($user['course'] ?? '')) ?>" 
                                                   placeholder="e.g., BSIT, BSCS">
                                            <?php if (isset(session('errors')['course'])): ?>
                                                <div class="invalid-feedback"><?= session('errors')['course'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year_level">Year Level</label>
                                            <select class="form-control <?= isset(session('errors')['year_level']) ? 'is-invalid' : '' ?>" 
                                                    id="year_level" 
                                                    name="year_level">
                                                <option value="">Select Year</option>
                                                <option value="1" <?= old('year_level', $user['year_level'] ?? '') == '1' ? 'selected' : '' ?>>1st Year</option>
                                                <option value="2" <?= old('year_level', $user['year_level'] ?? '') == '2' ? 'selected' : '' ?>>2nd Year</option>
                                                <option value="3" <?= old('year_level', $user['year_level'] ?? '') == '3' ? 'selected' : '' ?>>3rd Year</option>
                                                <option value="4" <?= old('year_level', $user['year_level'] ?? '') == '4' ? 'selected' : '' ?>>4th Year</option>
                                                <option value="5" <?= old('year_level', $user['year_level'] ?? '') == '5' ? 'selected' : '' ?>>5th Year</option>
                                            </select>
                                            <?php if (isset(session('errors')['year_level'])): ?>
                                                <div class="invalid-feedback"><?= session('errors')['year_level'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="section">Section</label>
                                            <input type="text" 
                                                   class="form-control <?= isset(session('errors')['section']) ? 'is-invalid' : '' ?>" 
                                                   id="section" 
                                                   name="section" 
                                                   value="<?= old('section', esc($user['section'] ?? '')) ?>" 
                                                   placeholder="e.g., IT3A">
                                            <?php if (isset(session('errors')['section'])): ?>
                                                <div class="invalid-feedback"><?= session('errors')['section'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" 
                                           class="form-control <?= isset(session('errors')['phone']) ? 'is-invalid' : '' ?>" 
                                           id="phone" 
                                           name="phone" 
                                           value="<?= old('phone', esc($user['phone'] ?? '')) ?>" 
                                           placeholder="e.g., 0912-345-6789">
                                    <?php if (isset(session('errors')['phone'])): ?>
                                        <div class="invalid-feedback"><?= session('errors')['phone'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control <?= isset(session('errors')['address']) ? 'is-invalid' : '' ?>" 
                                              id="address" 
                                              name="address" 
                                              rows="3" 
                                              placeholder="Enter your complete address"><?= old('address', esc($user['address'] ?? '')) ?></textarea>
                                    <?php if (isset(session('errors')['address'])): ?>
                                        <div class="invalid-feedback"><?= session('errors')['address'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            
            preview.src = e.target.result;
            preview.style.display = 'block';
            
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
}
</script>

<?= $this->endSection() ?>
