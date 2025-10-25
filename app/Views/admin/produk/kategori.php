<?= $this->extend('admin/layout/template') ?>
<?= $this->section('content') ?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Kategori Produk</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="#">Produk</a></li>
                            <li class="breadcrumb-item active">Kategori Produk</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-plus"></i> Tambah
                                </button>
                                <?php if (session('success')) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= session('success'); ?>
                                    </div>
                                <?php endif; ?>
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Nama Kategori</th>
                                            <th class="text-center">Tanggal Input</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nomor = 1; ?>
                                        <?php foreach($data_kategori as $ktg) : ?>
                                        <tr>
                                            <td><?= $nomor++; ?></td>
                                            <td><?= $ktg->nama_kategori; ?></td>
                                            <td><?= date('d/M/Y H:i:s',strtotime($ktg->tanggal_input)); ?></td>
                                            <td class="text-center" width="20%">
                                                <button type="button" class="btn btn-info btn-sm mb-2" data-bs-toggle="modal" 
                                                data-bs-target="#editModal<?= $ktg->id_kategori; ?>"><i class="fas fa-edit"></i> Edit</button>
                                                <a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <!-- Modal Tambah -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Tambah Kategori Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('produk/kategori/tambah');?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="nama_kategori">Nama Kategori:</label>
                                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
                                </div>
                            
                        </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Tambahkan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <?php foreach($data_kategori as $ktg) : ?>
                    <div class="modal fade" id="editModal<?= $ktg->id_kategori; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Kategori Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('produk/kategori/edit/'.$ktg->id_kategori);?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="mb-3">
                                        <label for="nama_kategori">Nama Kategori:</label>
                                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?= $ktg->nama_kategori; ?>" required>
                                    </div>
                                
                            </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
<?= $this->endSection() ?> 