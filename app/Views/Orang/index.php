<?= $this->extend('template/default'); ?>
<?= $this->section('content'); ?>
<table class="table mt-2 text-center">
    <div class="row">
        <div class="col-6">
            <h1>Daftar Orang</h1>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Recipient's username"
                    aria-label="Recipient's username" aria-describedby="button-addon2" name="keyword">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="submit">Cari</button>
            </div>

        </div>
    </div>
    <!-- <a href="/komik/tambah" class="btn btn-primary mb-2">Tambah data</a> -->
    <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
    <?php endif; ?>

    <thead>
        <tr>
            <th scope=" col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Alamat</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1 + (5 * ($currentPage - 1)); ?>
        <?php foreach ($orang as $k) : ?>
        <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><?= $k['nama']; ?></td>
            <td><?= $k['alamat']; ?></td>
            <td>
                <a href="/orang/<?= $k['id']; ?>" class="btn btn-success">Detail</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $pager->links('orang', 'orang_pagination'); ?>
<?= $this->endSection(); ?>