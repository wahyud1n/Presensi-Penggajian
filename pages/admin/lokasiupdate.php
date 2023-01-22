<?php 
if(isset($_GET['no_lokasi'])){

    $database = new Database();
    $db = $database->getConnection();

    $no_lokasi = $_GET['no_lokasi'];
    $findSql = "SELECT * FROM lokasi WHERE no_lokasi = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['no_lokasi']);
    $stmt->execute();
    $row = $stmt->fetch();
    if(isset($row['no_lokasi'])){
        if(isset($_POST['button_update'])){

            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM lokasi WHERE lokasi = ? AND no_lokasi != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1, $_POST['lokasi']);
            $stmt->bindParam(2, $_POST['no_lokasi']);
            $stmt->execute();
            if($stmt->rowCount() > 0){
?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dissmis="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    Nama lokasi sama sudah ada
                </div>
        <?php 
            } else {
                $updateSql = "UPDATE lokasi SET lokasi = ? WHERE no_lokasi = ?";
                $stmt = $db->prepare($updateSql);
                $stmt->bindParam(1, $_POST['lokasi']);
                $stmt->bindParam(2, $_POST['no_lokasi']);
                if($stmt->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil ubah data";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal ubah data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
            }
        }
        ?>
        <section class="container-header">
            <div class="container-fluid">
                <div class="row mb2">
                    <div class="col-sm-6">
                        <h1>Update Data Lokasi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=lokasiread">Lokasi</a></li>
                            <li class="breadcrumb-item active">Update Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Lokasi</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="lokasi">Nama Lokasi</label>
                            <input type="hidden" class="form-control" name="no_lokasi" value="<?php echo $row['no_lokasi'] ?>">
                            <input type="text" class="form-control" name="lokasi" autocomplete="off" value="<?php echo $row['lokasi'] ?>" required>
                        </div>
                        <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
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
        echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
}
?>