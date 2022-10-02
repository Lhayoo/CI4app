<?= $this->extend('template/default'); ?>
<?= $this->section('content'); ?>
<table class="table mt-2 text-center">
    <a href="/komik/tambah" class="btn btn-primary mb-2">Tambah data</a>
    <h1>Daftar Komik</h1>
    <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
    <?php endif; ?>

    <thead>
        <tr>
            <th scope=" col">No</th>
            <th scope="col">Sampul</th>
            <th scope="col">Judul</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($komik as $k) : ?>
        <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><img src="/img/<?= $k['sampul']; ?>" alt="" class="sampul"></td>
            <td><?= $k['judul']; ?></td>
            <td>
                <a href="/komik/detail/<?= $k['slug']; ?>" class="btn btn-success">Detail</a>
                <form action="/komik/<?= $k['id']; ?>" class="d-inline" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Apakah anda yakin?');">Delete</button>
                </form>
                <a href="/komik/edit/<?= $k['slug']; ?>" class="btn btn-warning">Edit</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection(); ?>