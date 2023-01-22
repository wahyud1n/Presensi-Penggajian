<?php 
if(isset($_GET['no_jabatan'])){

    $database = new Database();
    $db = $database->getConnection();

    $no_jabatan = $_GET['no_jabatan'];
    $findSql = "SELECT * FROM jabatan WHERE no_jabatan = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['no_jabatan']);
    $stmt->execute();
    $row = $stmt->fetch();
    if(isset($row['no_jabatan'])){
        if(isset($_POST['button_update'])){

            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM jabatan WHERE jabatan = ? AND gapok = ? AND tunjangan = ? AND uang_makan = ? AND no_jabatan != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1, $_POST['jabatan']);
            $stmt->bindParam(2, $_POST['gapok']);
            $stmt->bindParam(3, $_POST['tunjangan']);
            $stmt->bindParam(4, $_POST['uang_makan']);
            $stmt->bindParam(5, $_POST['no_jabatan']);
            $stmt->execute();
            if($stmt->rowCount() > 0){
?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dissmis="alert" aria-hidden="true">x</button>
    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
    Nama jabatan sama sudah ada
</div>
<?php 
            } else {
                $updateSql = "UPDATE jabatan SET jabatan = ?, gapok = ?, tunjangan = ?, uang_makan = ? WHERE no_jabatan = ?";
                $stmt = $db->prepare($updateSql);
                $stmt->bindParam(1, $_POST['jabatan']);
                $stmt->bindParam(2, $_POST['gapok']);
                $stmt->bindParam(3, $_POST['tunjangan']);
                $stmt->bindParam(4, $_POST['uang_makan']);
                $stmt->bindParam(5, $_POST['no_jabatan']);
                if($stmt->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil ubah data";
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal ubah data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
            }
        }
        ?>
<section class="container-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Update Data Jabatan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=jabatanread">Jabatan</a></li>
                    <li class="breadcrumb-item active">Update Data</li>
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
                    <input type="hidden" class="form-control" name="no_jabatan" value="<?php echo $row['no_jabatan'] ?>">
                    <input type="text" class="form-control" name="jabatan" autocomplete="off"
                        value="<?php echo $row['jabatan'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="gapok">Gaji Pokok</label>
                    <input type="text" class="form-control" name="gapok" autocomplete="off" value="<?php echo$row['gapok'] ?>" required
                        onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <div class="form-group">
                    <label for="tunjangan">Tunjangan</label>
                    <input type="text" class="form-control" name="tunjangan" autocomplete="off" value="<?php echo $row['tunjangan'] ?>" required
                        onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <div class="form-group">
                    <label for="uang_makan">Uang Makan</label>
                    <input type="text" class="form-control" name="uang_makan" autocomplete="off" value="<?php echo $row['uang_makan'] ?>" required
                        onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
                </div>
                <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right">
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
        echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
}
?>