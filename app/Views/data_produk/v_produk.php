<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>

    <!--link bootstrap-->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!--link -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
   
</head>

<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="text-center">Data Produk</h3>
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data data-bs-target="#modalTambahProduk"><i class="fa-solid fa-cart-plus"></i>Tambah Data</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="container mt-5">
                    <table class="table table-bordered" id="produkTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                            <tbody>
                                <!--Data akan dimasukkan melalui ajax-->
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTambahProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahProduk" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h1 class="modal-title fs-5" id="modalTambahProdukLabel">Tambah Produk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formProduk">
                            <div class="row mb-3">
                                <label for="namaProduk"class="col-form-label">Nama Produk</label>
                                <div class="cl-sm-8">
                                    <input type="text" class="form-control" id="namaProduk" name="namaProduk">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="hargaProduk"class="col-sm-4 col-form-label">Harga</label>
                                <div class="cl-sm-8">
                                    <input type="number" step="0.01" class="form-control" id="hargaProduk">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="stokProduk"class="col-sm-4 col-form-label">Stok</label>
                                <div class="cl-sm-8">
                                    <input type="number" class="form-control" id="stokProduk">
                                </div>
                            </div>  
                        </form>
                        <div class="modal-footer">
                            <button type="button" id="simpanProduk" class="btn btn-primary float-end">Simpan</button>
                        </div>
                    </div>        
                </div>            
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-heade">
                        <h1 class="modal-title " id="modalHapusLabel">Konfirmasi Hapus</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"> &times; </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus data ini?
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="btnHapus">Hapus</button>
                        </div>
                    </div>        
                </div>            
            </div>
        
         <!-- Modal Edit Produk -->
         <div class="modal fade" id="modalEditProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content ">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="modalEditProdukLabel">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditProduk">
                            <input type="hidden" id="editProdukId">
                            <div class="row mb-3">
                                <label for="editNamaProduk" class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="editNamaProduk">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="editHargaProduk" class="col-sm-2 col-form-label">Harga</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="editHargaProduk">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="editStokProduk" class="col-sm-2 col-form-label">Stok</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="editStokProduk">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="updateProduk">Update</button>
                    </div>
                </div>
            </div>
</div>


    
    <script src="<?= base_url("assets/jquery.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>

    <script>
        
        $(document).ready(function() {
    tampilProduk();
    
    // Function to display products in the table
    function tampilProduk() {
        $.ajax({
            url: '<?= base_url('/produk/tampil') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(hasil) {
                if (hasil.status === 'success') {
                    var produkTable = $('#produkTable tbody');
                    produkTable.empty(); // Clear existing data
                    
                    var produk = hasil.produk;
                    var no = 1;
                    
                    // Loop to insert data into the table
                    produk.forEach(function(item) {
                        var row = '<tr>' +
                            '<td>' + no + '</td>' +
                            '<td>' + item.nama_produk + '</td>' +
                            '<td>' + item.harga + '</td>' +
                            '<td>' + item.stok + '</td>' +
                            '<td>' +
                                '<button class="btn btn-warning btn-sm editProduk" data-id="' + item.produk_id + '" data-bs-toggle="modal" data-bs-target="#modalEditProduk"><i class="fa-solid fa-pencil"></i> Edit</button> ' +
                                '<button class="btn btn-danger btn-sm hapusProduk" data-id="' + item.produk_id + '"><i class="fa-solid fa-trash-can"></i> Hapus</button> ' +
                            '</td>' +
                        '</tr>';
                        produkTable.append(row);
                        no++;
                    });
                } else {
                    alert('Gagal mengambil data.');
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }
    
    // Handle save button click for adding a new product
    $("#modalTambahProduk").on("click", "#simpanProduk", function() {
        var nama_produk = $('#namaProduk').val();
        var harga = $('#hargaProduk').val();
        var stok = $('#stokProduk').val();
        
        if (!nama_produk || !harga || !stok) {
            alert("Semua kolom harus diisi.");
            return;
        }

        var formData = {
            "nama_produk": nama_produk,
            "harga": harga,
            "stok": stok
        };

        $.ajax({
            url: '<?= base_url('/produk/simpan') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(hasil) {
                if (hasil.status === 'success') {
                    $('#modalTambahProduk').modal('hide');
                    $('#formProduk')[0].reset();
                    tampilProduk();
                } else {
                    alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    });

    // Handle edit button click to fetch and fill the modal with product data
    $('#produkTable').on('click', '.editProduk', function() {
        var produkId = $(this).data('id');

        $.ajax({
            url: '<?= base_url('produk/edit/'); ?>' + produkId, // Fixed URL concatenation
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    var produk = data.produk;
                    $('#editProdukId').val(produk.produk_id);
                    $('#editNamaProduk').val(produk.nama_produk);
                    $('#editHargaProduk').val(produk.harga);
                    $('#editStokProduk').val(produk.stok);
                    $('#modalEditProduk').modal('show');
                } else {
                    alert('Gagal mendapatkan data produk.');
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    });

    // Handle update button click to update the product
    $('#updateProduk').on('click', function() {
        var formData = {
            id: $('#editProdukId').val(),
            nama_produk: $('#editNamaProduk').val(),
            harga: $('#editHargaProduk').val(),
            stok: $('#editStokProduk').val()
        };

        $.ajax({
            url: '<?= base_url('produk/update'); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(hasil) {
                if (hasil.status === 'success') {
                    $('#modalEditProduk').modal('hide');
                    tampilProduk();
                } else {
                    alert('Gagal update: ' + JSON.stringify(hasil.errors));
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    });

    // Handle delete button click to delete a product
    $('#produkTable').on('click', '.hapusProduk', function() {
        var id = $(this).data('id');
        
        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
            $.ajax({
                url: '<?= base_url('produk/delete'); ?>/' + id, // Make sure the URL is correct for the delete function
                type: 'DELETE',
                success: function(response) {
                    alert('Produk berhasil dihapus.');
                    tampilProduk(); // Reload the product table
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat menghapus produk: ' + error);
                }
            });
        }
    });
});


        $('#produkTable').on('click','.hapusProduk',function(){
        var id=$(this).attr('data-id')
        console.log(id);        
            
        $.ajax({
            url:`http://localhost:8080/produk/delete/${id}`,
            type: 'DELETE',
            success: function(response){
                $('#modalHapus').modal('hide');
                alert('Berhasil Hapus data');
                tampilProduk()
            }
        })
    });
    


    // let idHapus;
    // function ShowModalHapus(id){
    //     idHapus = id;
    //     $('#modalHapus').modal('show');
    // }

</script>



</body>

<!-- <body>
    <div class="container">
        <div class="card-header header-margin" style="display: flex; justify-content: center;">
            <h3 class="card_title" style="color: black;">
                <strong>Data Produk</strong>
            </h3>
        </div>
        <div class="card-body text-center button-margin" style="display: flex; justify-content: flex-end;">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-plus"></i>
                <a>Tambah Data</a>
            </button>
        </div>
    </div> -->

<!-- </body> -->
</html> 