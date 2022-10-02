<?= $this->extend('template/default'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-8">
        <h2 class="my-3">Form edit</h2>
        <form action="/komik/update/<?= $komik['id']; ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="slug" value="<?= $komik['slug']; ?>">
            <input type="hidden" name="lama" value="<?= $komik['sampul']; ?>">
            <div class="row mb-3">
                <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>"
                        id="judul" name="judul" value="<?= (old('judul')) ? old('judul') : $komik['judul'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('judul'); ?>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                <div class="col-sm-10">
                    <input type="text"
                        class="form-control <?= ($validation->hasError('penulis')) ? 'is-invalid' : ''; ?>" id="penulis"
                        name="penulis" value="<?= (old('penulis')) ? old('penulis') : $komik['penulis'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('penulis'); ?>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                <div class="col-sm-10">
                    <input type="text"
                        class="form-control <?= ($validation->hasError('penerbit')) ? 'is-invalid' : ''; ?>"
                        id="penerbit" name="penerbit"
                        value="<?= (old('penerbit')) ? old('penerbit') : $komik['penerbit'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('penerbit'); ?>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                <div class="col-sm-2">
                    <img src="/img/<?= $komik['sampul']; ?>" class="img-thumbnail img-preview">
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input type="file"
                            class="form-control label <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>"
                            id="sampul" name="sampul" onchange="previewImg()">
                        <div class="invalid-feedback">
                            <?= $validation->getError('sampul'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Edit data</button>
            <a href="/komik/" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>