<?php include_once "partials/cssdatatables.php" ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <?php 
        if(isset($_SESSION["hasil"])){
            if($_SESSION["hasil"]){
        ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-check"></i>Berhasil</h5>
                    <?php echo $_SESSION["pesan"] ?>
                </div>
        <?php
            } else {
        ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    <?php echo $_SESSION["pesan"] ?>
                </div>
        <?php
            }
            unset($_SESSION['hasil']);
            unset($_SESSION['pesan']);
        }
        ?>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">HOME</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="card">
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nik</th>
                        <th>Nama Karyawan</th>
                        <th>Bagian Terkini</th>
                        <th>Jabatan Terkini</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = new Database();
                    $db = $database->getConnection();

                    $selectSql = "SELECT K.*,
                        (
                        SELECT J.jabatan FROM jabatan_karyawan JK
                        INNER JOIN jabatan J ON JK.jabatan_id = J.no_jabatan
                        WHERE JK.karyawan_id = K.no_karyawan ORDER BY JK.tanggal_mulai DESC 
                        LIMIT 1
                        ) jabatan_terkini,
                        (
                        SELECT B.bagian FROM bagian_karyawan BK
                        INNER JOIN bagian B ON BK.bagian_id = B.no_bagian
                        WHERE BK.karyawan_id = K.no_karyawan ORDER BY BK.tanggal_mulai DESC
                        LIMIT 1
                        ) bagian_terkini
                        FROM karyawan K";

                    $stmt = $db->prepare($selectSql);
                    $stmt->execute();

                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                    <tr>
                        <td><?php echo $row['nik'] ?></td>
                        <td><?php echo $row['karyawan'] ?></td>
                        <td>
                            <?php
                            $bagian_terkini = $row['bagian_terkini'] == "" ? "Belum ada" : $row['bagian_terkini'];
                            ?>
                            <a href="#" class="btn bg-fuchsia btn-sm mr-1"
                            onclick="javascript: return alert ('Untuk edit BAGIAN TERKINI di Master data Karyawan!!!')">
                            <i class="fa fa-building"></i> <?php echo $bagian_terkini ?></a>    
                        </td>
                        <td>
                            <?php
                            $jabatan_terkini = $row['jabatan_terkini'] == "" ? "Belum ada" : $row['jabatan_terkini'];
                            ?>
                            <a href="#" class="btn bg-purple btn-sm mr-1"
                            onclick="javascript: return alert ('Untuk edit JABATAN TERKINI di Master data Karyawan!!!')">
                            <i class="fa fa-id-badge"></i> <?php echo $jabatan_terkini ?></a>    
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nik</th>
                        <th>Nama Karyawan</th>
                        <th>Bagian Terkini</th>
                        <th>Jabatan Terkini</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- /.content -->

<?php include_once "partials/scripts.php" ?>
<?php include_once "partials/scriptsdatatables.php" ?>
<script>
    $(function () {
        $('#mytable').DataTable()
    });
</script>