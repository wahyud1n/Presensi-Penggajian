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
                <h1 class="m-0">Jabatan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Jabatan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Jabatan</h3>
            <a href="?page=jabatancreate" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i>Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jabatan</th>
                        <th>Gapok</th>
                        <th>Tunjangan</th>
                        <th>Uang Makan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = new Database();
                    $db = $database->getConnection();

                    $selectSql = "SELECT * FROM jabatan";

                    $stmt = $db->prepare($selectSql);
                    $stmt->execute();

                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td style="text-transform: uppercase;"><?php echo $row['jabatan'] ?></td>
                        <td style="text-align: right;"><?php echo "Rp. ".number_format($row['gapok']) ?></td>
                        <td style="text-align: right;"><?php echo "Rp. ".number_format($row['tunjangan']) ?></td>
                        <td style="text-align: right;"><?php echo "Rp. ".number_format($row['uang_makan']) ?></td>
                        <td>
                            <a href="?page=jabatanupdate&no_jabatan=<?php echo $row['no_jabatan'] ?>"
                                class="btn btn-primary btn-sm mr-1">
                                <i class="fa fa-edit"></i>Ubah</a>
                            <a href="?page=jabatandelete&no_jabatan=<?php echo $row['no_jabatan'] ?>" class="btn btn-danger btn-sm"
                                onclick="javascript: return confirm('Konfirmasi data akan dihapus?');"><i
                                class="fa fa-trash"></i>Hapus</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Jabatan</th>
                        <th>Gapok</th>
                        <th>Tunjangan</th>
                        <th>Uang Makan</th>
                        <th>Opsi</th>
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