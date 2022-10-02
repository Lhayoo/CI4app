<?= $this->extend('template/default'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col">
        <h2 class="mt-2">Detail Komik</h2>
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/img/<?= $komik['sampul']; ?>" class="img-fluid rounded-start" alt="gambar">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $komik['judul']; ?></h5>
                        <p class="card-text">Penulis : <?= $komik['penulis']; ?></p>
                        <p class="card-text">Penerbit : <?= $komik['penerbit']; ?></p>

                        <a href="/komik/edit/<?= $komik['slug']; ?>" class="btn btn-warning">Edit</a>
                        <a class="btn btn-secondary" href="/komik">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>