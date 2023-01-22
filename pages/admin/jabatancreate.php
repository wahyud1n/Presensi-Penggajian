<?php
if (isset($_POST['button_create'])) {

    $database = new Database();
    $db = $database->getConnection();

    // CODE DI BAWAH UNTUK MENGHINDARI SQLINJECTION, Data yang di POST tidak langsung diselipkan kedalam insertSql tetapi melalui method
    // bindParam(1, $_POST[‘nama_lokasi’]) , sebagai konteks, angka 1 adalah nomor
    // parameter tanda tanya (?) sehingga jika terdapat lebih dari 1 (satu) field yang diinput
    // maka dilanjutkan sejumlah nomor field tersebut. 

    $validateSql = "SELECT * FROM jabatan WHERE jabatan = ? AND gapok = ? AND tunjangan = ? AND uang_makan = ?";
    $stmt = $db->prepare($validateSql);
    $stmt->bindParam(1, $_POST['jabatan']);
    $stmt->bindParam(2, $_POST['gapok']);
    $stmt->bindParam(3, $_POST['tunjangan']);
    $stmt->bindParam(4, $_POST['uang_makan']);
    $stmt->execute();
    if($stmt->rowCount() > 0){
?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i> Gagal</h5>
            Nama jabatan sama sudah ada
        </div>
<?php
    } else {
        $insertSql = "INSERT INTO jabatan SET jabatan = ?, gapok = ?, tunjangan = ?, uang_makan = ?";
        $stmt = $db->prepare($insertSql);
        $stmt->bindParam(1, $_POST['jabatan']);
        $stmt->bindParam(2, $_POST['gapok']);
        $stmt->bindParam(3, $_POST['tunjangan']);
        $stmt->bindParam(4, $_POST['uang_makan']);
        if($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil simpan data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal simpan data";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
    }
}
?>

<section class="container-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Jabatan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=jabatanread">Jabatan</a></li>
                    <li class="breadcrumb-item active">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Jabatan</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="jabatan">Nama Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="gapok">Gaji Pokok</label>
                    <input type="text" class="form-control" name="gapok" autocomplete="off" required
                        onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'
                    >
                </div>
                <div class="form-group">
                    <label for="tunjangan">Tunjangan</label>
                    <input type="text" class="form-control" name="tunjangan" autocomplete="off" required
                        onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'
                    >
                </div>
                <div class="form-group">
                    <label for="uang_makan">Uang Makan</label>
                    <input type="text" class="form-control" name="uang_makan" autocomplete="off" required
                        onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'
                    >
                </div>
                <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</section>

<?php include_once "partials/scripts.php" ?>