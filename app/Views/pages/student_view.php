<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <h2 class="m-0">Student Management System</h2>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0" style="font-size: 1.1rem;">Add New Student</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('students/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Course</label>
                            <input type="text" name="course" class="form-control" placeholder="e.g. BSIT" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">Add Student</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h3 class="card-title mb-0" style="font-size: 1.1rem;">Students List</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($students)): foreach($students as $s): ?>
                            <tr>
                                <td class="align-middle"><?= esc($s['name']) ?></td>
                                <td class="align-middle"><?= esc($s['email']) ?></td>
                                <td class="align-middle"><?= esc($s['course']) ?></td>
                                <td class="text-center align-middle">
                                    
                                    <a href="<?= base_url('students/edit/' . $s['id']) ?>" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="<?= base_url('students/delete/' . $s['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Sigurado ka ba?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No students found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>