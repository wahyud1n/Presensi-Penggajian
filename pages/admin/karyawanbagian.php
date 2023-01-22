<?php 
if (isset($_GET['no_karyawan'])) {

    $database = new Database();
    $db = $database->getConnection();

    $no_karyawan = $_GET['no_karyawan'];
    $findSql = "SELECT * FROM karyawan WHERE no_karyawan = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['no_karyawan']);
    $stmt->execute();
    $row = $stmt->fetch();
    if(isset($row['no_karyawan'])) {
        if(isset($_POST['button_update'])) {

            $updateSql = "INSERT INTO bagian_karyawan SET karyawan_id = ?, bagian_id = ?, tanggal_mulai = ?";
            $stmt = $db->prepare($updateSql);
            $stmt->bindParam(1, $_POST['karyawan_id']);
            $stmt->bindParam(2, $_POST['bagian_id']);
            $stmt->bindParam(3, $_POST['tanggal_mulai']);
            if ($stmt->execute()) {
                $_SESSION['hasil'] = true;
            } else {
                $_SESSION['hasil'] = false;
            }
            echo "<meta http-equiv='refresh' content='1;url=?page=karyawanbagian&no_karyawan=" . $_POST['karyawan_id'] . "'>";
        }

        if (isset($_POST['button_delete'])) {
            $updateSql = "DELETE FROM bagian_karaywan WHERE id = ?";
            $stmt = $db->prepare($updateSql);
            $stmt->bindParam(1, $_POST['bk_id']);
            if ($stmt->execute()) {
                $_SESSION['hasil'] = true;
            } else {
                $_SESSION['hasil'] = false;
            }
            echo "<meta http-equiv='refresh' content='1;url=?page=karyawanbagian&no_karyawan=" . $_POST['karyawan_id'] . "'>";
        }
?>
        <section class="container-header">
            <div class="container-fluid">
                <?php
                if (isset($_SESSION["hasil"])) {
                    if ($_SESSION["hasil"]) {
                ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                        </div>
                <?php
                    } else {
                ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                        </div>
                <?php
                    }
                    unset($_SESSION["hasil"]);
                }
                ?>
                <div class="row mb2">
                    <div class="col-sm-6">
                        <h1>Karyawan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
                            <li class="breadcrumb-item active">Riwayat Bagian</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Bagian</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nik">Nomer Induk Karyawan</label>
                                <input type="text" class="form-control" name="nik" autocomplete="off" value="<?php echo $row['nik'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nohp">No Handphone</label>
                                <input type="text" class="form-control" name="nohp" autocomplete="off" value="<?php echo $row['nohp'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="karyawan">Nama Karyawan</label>
                                <input type="text" class="form-control" name="karyawan" autocomplete="off" value="<?php echo $row['karyawan'] ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" value="<?php echo $no_karyawan ?>" name="karyawan_id">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bagian_id">Bagian</label>
                                    <select name="bagian_id" class="form-control">
                                        <option value="">-- Pilih Bagian --</option>
                                        <?php

                                        $selectSql = "SELECT * FROM bagian";
                                        $stmt_bagian = $db->prepare($selectSql);
                                        $stmt_bagian->execute();

                                        while ($row_bagian = $stmt_bagian->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value=\"" . $row_bagian["no_bagian"] . "\">" . $row_bagian["bagian"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="button_update" class="btn btn-success btn-block float-right mb-3">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>

                    <table id="mytable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bagian</th>
                                <th>Tangal Mulai</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $database = new Database();
                            $db = $database->getConnection();

                            $selectSql = "SELECT BK.*, B.bagian FROM bagian_karyawan BK 
                                            LEFT JOIN bagian B ON BK.bagian_id = B.no_bagian 
                                            WHERE BK.karyawan_id = ? 
                                            ORDER BY tanggal_mulai DESC";
                            $stmt = $db->prepare($selectSql);
                            $stmt->bindParam(1, $no_karyawan);
                            $stmt->execute();

                            $no = 1;
                            while ($rowbagian = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowbagian['bagian'] ?></td>
                                    <td><?php echo $rowbagian['tanggal_mulai'] ?></td>
                                    <td>
                                        <form action method="POST">
                                            <input type="hidden" name="bk_id" value="<?php echo $rowbagian['id'] ?>">
                                            <input type="hidden" value="<?php echo $no_karyawan ?>" name="karyawan_id">
                                            <button type="submit" name="button_delete" class="btn btn-danger btn-sm mr-1" onclick="javascript: return confirm('Konfirmasi data akan dihapus?');">
                                            <i class="fa fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
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