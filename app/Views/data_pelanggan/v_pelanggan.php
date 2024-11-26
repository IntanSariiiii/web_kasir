<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
</head>

<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="text-center">Data Pelanggan</h3>
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal"
                    data-bs-target="#modalTambahPelanggan"><i class="fa-solid fa-user-plus"></i> Tambah
                    Pelanggan</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="container mt-5">
                    <table class="table table-bordered" id="pelangganTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data pelanggan akan dimasukkan melalui AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pelanggan -->
        <div class="modal fade" id="modalTambahPelanggan" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalTambahPelanggan" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h1 class="modal-title fs-5" id="modalTambahPelangganLabel">Tambah Pelanggan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formPelanggan">
                            <div class="row mb-3">
                                <label for="nama_pelanggan" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="namaPelanggan" name="nama_pelanggan">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamatPelanggan" name="alamat">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nomor_telepon" class="col-sm-4 col-form-label">Nomor Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nomorTelepon" name="nomor_tlp">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="simpanPelanggan" class="btn btn-primary float-end">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pelanggan -->
    <div class="modal fade" id="modalEditPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditPelanggan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h1 class="modal-title fs-5" id="modalEditPelanggan">Edit Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditPelanggan">
                        <input type="hidden" id="idPelangganEdit">
                        <div class="row mb-3">
                            <label for="namaPelangganEdit" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="namaPelangganEdit" name="nama_pelanggan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamatPelangganEdit" class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="alamatPelangganEdit" name="alamat">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nomorTeleponEdit" class="col-sm-4 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nomorTeleponEdit" name="nomor_tlp">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="editPelangganSimpan">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Fungsi untuk menampilkan pelanggan
            function tampilPelanggan() {
                $.ajax({
                    url: '<?= base_url('pelanggan/tampil') ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status === 'success' && Array.isArray(hasil.pelanggan)) {
                            var pelangganTable = $('#pelangganTable tbody');
                            pelangganTable.empty();

                            var pelanggan = hasil.pelanggan;
                            var no = 1;

                            pelanggan.forEach(function (item) {
                                var row = '<tr>' +
                                    '<td>' + no + '</td>' +
                                    '<td>' + item.nama_pelanggan + '</td>' +
                                    '<td>' + item.alamat + '</td>' +
                                    '<td>' + item.nomor_tlp + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-warning btn-sm editPelanggan" data-id="' + item.pelanggan_id + '" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan"><i class="fa-solid fa-pencil"></i> Edit</button> ' +
                                    '<button class="btn btn-danger btn-sm hapusPelanggan" data-id="' + item.pelanggan_id + '"><i class="fa-solid fa-trash-can"></i> Hapus</button>' +
                                    '</td>' +
                                    '</tr>';
                                pelangganTable.append(row);
                                no++;
                            });
                        } else {
                            alert('Tidak ada data pelanggan tersedia.');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }

            // Panggil fungsi tampilPelanggan saat halaman dimuat
            tampilPelanggan();

            // Simpan data pelanggan baru
            $("#modalTambahPelanggan").on("click", "#simpanPelanggan", function () {
                var nama_pelanggan = $('#namaPelanggan').val();
                var alamat = $('#alamatPelanggan').val();
                var nomor_tlp = $('#nomorTelepon').val();

                if (!nama_pelanggan || !alamatPelanggan || !nomorTelepon) {
                    alert("Semua kolom harus diisi.");
                    return;
                }

                var formData = {
                    "nama_pelanggan": nama_pelanggan,
                    "alamat": alamat,
                    "nomor_tlp": nomor_tlp
                };

                $.ajax({
                    url: '<?= base_url('/pelanggan/simpan') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (hasil) {
                        if (hasil.status === 'success') {
                            $('#modalTambahPelanggan').modal('hide');
                            $('#formPelanggan')[0].reset();
                            tampilProduk();
                        } else {
                            alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });

            // Hapus pelanggan
            $('#pelangganTable').on('click', '.editPelanggan', function () {
                var id = $(this).data('id');

                $.ajax({
                    url: '<?= base_url('/pelanggan/edit/'); ?>' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        5
                        console.log(
                            data
                        );
                        if (data.status === 'success') {
                            var produk = data.produk;


                            $('#idPelangganEdit').val(produk.pelanggan_id);
                            $('#namaPelangganEdit').val(produk.nama_pelanggan);
                            $('#alamatPelangganEdit').val(produk.alamat);
                            $('#nomorTeleponEdit').val(produk.nomor_tlp);
                            $('#modalEditPelanggan').modal('show');

                        } else {
                            alert('Gagal mendapatkan data pelanggan.');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });

            });

            // Handle update button click to update the product
            $('#editPelangganSimpan').on('click', function () {
                var formData = {
                    id: $('#idPelangganEdit').val(),
                    nama_pelanggan: $('#namaPelangganEdit').val(),
                    alamat: $('#alamatPelangganEdit').val(),
                    nomor_tlp: $('#nomorTeleponEdit').val()
                };

                $.ajax({
                    url: '<?= base_url('pelanggan/update'); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (hasil) {

                        if (hasil.status === 'success') {
                            $('#modalEditPelanggan').modal('hide');
                            tampilProduk();
                        } else {
                            alert('Gagal update: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });

            $(document).on('click', '.hapusPelanggan', function () {
                var id = $(this).data('id');
                if (confirm("Apakah Anda yakin ingin menghapus pelanggan ini?")) {
                    $.ajax({
                        url: '<?= base_url('pelanggan/hapus/') ?>' + id,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                alert(response.message);
                                tampilPelanggan();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                        }
                    });
                }
            });
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>