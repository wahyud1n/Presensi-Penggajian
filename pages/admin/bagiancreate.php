<?php

$database = new Database();
$db = $database->getConnection();

if (isset($_POST['button_create'])) {
    // CODE DI BAWAH UNTUK MENGHINDARI SQLINJECTION, Data yang di POST tidak langsung diselipkan kedalam insertSql tetapi melalui method
    // bindParam(1, $_POST[‘nama_lokasi’]) , sebagai konteks, angka 1 adalah nomor
    // parameter tanda tanya (?) sehingga jika terdapat lebih dari 1 (satu) field yang diinput
    // maka dilanjutkan sejumlah nomor field tersebut. 

    $validateSql = "SELECT * FROM bagian WHERE bagian = ?";
    $stmt = $db->prepare($validateSql);
    $stmt->bindParam(1, $_POST['bagian']);
    $stmt->execute();
    if($stmt->rowCount() > 0){
?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h5><i class="icon fas fa-ban"></i> Gagal</h5>
    Nama bagian sama sudah ada
</div>
<?php
    } else {
        $insertSql = "INSERT INTO bagian SET bagian = ?, karyawan_id = ?, lokasi_id = ?";
        $stmt = $db->prepare($insertSql);
        $stmt->bindParam(1, $_POST['bagian']);
        $stmt->bindParam(2, $_POST['karyawan_id']);
        $stmt->bindParam(3, $_POST['lokasi_id']);
        if($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil simpan data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal simpan data";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }
}
?>

<section class="container-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Bagian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                    <li class="breadcrumb-item active">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Bagian</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="bagian">Nama Bagian</label>
                    <input type="text" class="form-control" name="bagian" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="karyawan_id">Kepala Bagian</label>
                    <select class="form-control" name="karyawan_id">
                        <option value="">-- Pilih Kepala Bagian --</option>
                        <?php

                        $selectSql = "SELECT * FROM karyawan";
                        $stmt_karyawan = $db->prepare($selectSql);
                        $stmt_karyawan->execute();

                        while ($row_karyawan = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) {

                            // $selected = $row_karyawan["no_karyawan"] == $row["karyawan_id"] ? " selected" : "";

                            echo "<option value=\"" . $row_karyawan["no_karyawan"] . "\">" . $row_karyawan["karyawan"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lokasi_id">Lokasi Bagian</label>
                    <select class="form-control" name="lokasi_id">
                        <option value="">-- Pilih Lokasi Bagian --</option>
                        <?php

                        $selectSql = "SELECT * FROM lokasi";
                        $stmt_lokasi = $db->prepare($selectSql);
                        $stmt_lokasi->execute();

                        while ($row_lokasi = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)) {
                            
                            // $selected = $row_lokasi["no_lokasi"] == $row["lokasi_id"] ? " selected" : "";
                            
                            echo "<option value=\"" . $row_lokasi["no_lokasi"] . "\">" . $row_lokasi["lokasi"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
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