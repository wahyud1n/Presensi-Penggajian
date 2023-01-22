<?php 
if(isset($_GET['no_karyawan'])){

    $database = new Database();
    $db = $database->getConnection();

    $no_karyawan = $_GET['no_karyawan'];
    $findSql = "SELECT * FROM karyawan WHERE no_karyawan = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['no_karyawan']);
    $stmt->execute();
    $row = $stmt->fetch();
    if(isset($row['no_karyawan'])){
        if(isset($_POST['button_update'])){

            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM karyawan WHERE nik = ? AND karyawan = ? AND nohp = ? AND email = ? AND tanggal_masuk = ? AND no_karyawan != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1, $_POST['nik']);
            $stmt->bindParam(2, $_POST['karyawan']);
            $stmt->bindParam(3, $_POST['nohp']);
            $stmt->bindParam(4, $_POST['email']);
            $stmt->bindParam(5, $_POST['tanggal_masuk']);
            $stmt->bindParam(7, $_POST['no_karyawan']);
            $stmt->execute();
            if($stmt->rowCount() > 0){
?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dissmis="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    Nama karyawan sama sudah ada
                </div>
        <?php 
            } else {
                $updateSql = "UPDATE karyawan SET nik = ?, karyawan = ?, nohp = ?, email = ?, tanggal_masuk = ? WHERE no_karyawan = ?";
                $stmt = $db->prepare($updateSql);
                $stmt->bindParam(1, $_POST['nik']);
                $stmt->bindParam(2, $_POST['karyawan']);
                $stmt->bindParam(3, $_POST['nohp']);
                $stmt->bindParam(4, $_POST['email']);
                $stmt->bindParam(5, $_POST['tanggal_masuk']);
                $stmt->bindParam(7, $_POST['no_karyawan']);
                if($stmt->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil ubah data";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal ubah data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
            }
        }
        ?>
        <section class="container-header">
            <div class="container-fluid">
                <div class="row mb2">
                    <div class="col-sm-6">
                        <h1>Update Data Karyawan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
                            <li class="breadcrumb-item active">Update Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Karyawan</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nik">Nomer Induk Karyawan</label>
                            <input type="hidden" class="form-control" name="no_karyawan" value="<?php echo $row['no_karyawan'] ?>">
                            <input type="text" class="form-control" name="nik" autocomplete="off" value="<?php echo $row['nik'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="karyawan">Nama Karyawan</label>
                            <input type="text" class="form-control" name="karyawan" autocomplete="off" value="<?php echo $row['karyawan'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nohp">No Handphone</label>
                            <input type="text" class="form-control" name="nohp" autocomplete="off" value="<?php echo $row['nohp'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" autocomplete="off" value="<?php echo $row['email'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="tanggal_masuk" autocomplete="off" value="<?php echo $row['tanggal_masuk'] ?>" required>
                        </div>
                        <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
                            <i class="fa fa-times"></i> Batal
                        </a>
                        <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </section>
<?php
    } else {
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
}
?>