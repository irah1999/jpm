<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card card-theme p-4">
        <h4 class="text-blue-950 mb-3"><a href="<?= route_to('categories.index') ?>"><i class="fa-solid fa-arrow-left"></i>
            </a> Edit Category</h4>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= route_to('categories.update', $category['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $category['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Status</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="status_active" name="status" value="1" <?= old('status', $category['status']) == '1' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="status_active">Active</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="status_inactive" name="status" value="0" <?= old('status', $category['status']) == '0' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="status_inactive">Inactive</label>
                </div>
            </div>

            <button class="btn btn-blue-950">Update</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>