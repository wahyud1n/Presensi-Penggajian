<?php
if (isset($_POST['button_create'])) {

    $database = new Database();
    $db = $database->getConnection();

    // CODE DI BAWAH UNTUK MENGHINDARI SQLINJECTION, Data yang di POST tidak langsung diselipkan kedalam insertSql tetapi melalui method
    // bindParam(1, $_POST[‘nama_lokasi’]) , sebagai konteks, angka 1 adalah nomor
    // parameter tanda tanya (?) sehingga jika terdapat lebih dari 1 (satu) field yang diinput
    // maka dilanjutkan sejumlah nomor field tersebut. 

    $validateSql = "SELECT * FROM karyawan WHERE nik = ?";
    $stmt = $db->prepare($validateSql);
    $stmt->bindParam(1, $_POST['nik']);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i> Gagal</h5>
            NIK sama sudah ada
        </div>
    <?php
    } else {
        $validateSql = "SELECT * FROM pengguna WHERE username = ?";
        $stmt = $db->prepare($validateSql);
        $stmt->bindParam(1, $_POST['username']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                Username sama sudah ada
            </div>
<?php
        } else {
            if ($_POST['password'] != $_POST['passwordulangi']) {
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                    Password tidak sama
                </div>
<?php
            } else {
                $md5password = md5($_POST['password']);

                $insertSql = "INSERT INTO pengguna VALUES (NULL, ?, ?, ?, NULL)";
                $stmt = $db->prepare($insertSql);
                $stmt->bindParam(1, $_POST['username']);
                $stmt->bindParam(2, $md5password);
                $stmt->bindParam(3, $_POST['peran']);

                if ($stmt->execute()) {
                    $pengguna_id = $db->lastInsertId();

                    $insertKaryawanSql = "INSERT INTO karyawan VALUES (NULL, ?, ?, ?, ?, ?, ?)";
                    $stmtKaryawan = $db->prepare($insertKaryawanSql);
                    $stmtKaryawan->bindParam(1, $_POST['nik']);
                    $stmtKaryawan->bindParam(2, $_POST['karyawan']);
                    $stmtKaryawan->bindParam(3, $_POST['nohp']);
                    $stmtKaryawan->bindParam(4, $_POST['email']);
                    $stmtKaryawan->bindParam(5, $_POST['tanggal_masuk']);
                    $stmtKaryawan->bindParam(6, $pengguna_id);

                    if ($stmtKaryawan->execute()) {
                        $_SESSION['hasil'] = true;
                        $_SESSION['pesan'] = "Berhasil simpan data";
                    } else {
                        $_SESSION['hasil'] = false;
                        $_SESSION['pesan'] = "Gagal simpan data";
                    }
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal simpan data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
            }
        }
    }
}
?>

<section class="container-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
                    <li class="breadcrumb-item active">Tambah Data</li>
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
                    <input type="text" class="form-control" name="nik" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="karyawan">Nama Lengkap</label>
                    <input type="text" class="form-control" name="karyawan" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="nohp">No. Handphone</label>
                    <input type="text" class="form-control" name="nohp" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="passwordulangi">Password (ulangi)</label>
                    <input type="password" class="form-control" name="passwordulangi" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="peran">Peran</label>
                    <select name="peran" class="form-control">
                        <option value="">-- Pilih Peran --</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="USER">USER</option>
                    </select>
                </div>
                <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="button_create" class="btn btn-success btn-sm float-right"></button>
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</section>

<?php include_once "partials/scripts.php" ?>