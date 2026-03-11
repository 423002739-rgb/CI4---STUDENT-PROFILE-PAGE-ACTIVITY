<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h3 class="card-title mb-0" style="font-size: 1.2rem;">
                        <i class="fas fa-user-edit me-2"></i>Edit Student Information
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('students/update/' . $student['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= esc($student['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?= esc($student['email']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Course</label>
                            <input type="text" name="course" class="form-control" 
                                   value="<?= esc($student['course']) ?>" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success shadow-sm">
                                Save Changes
                            </button>
                            <a href="<?= base_url('students') ?>" class="
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>