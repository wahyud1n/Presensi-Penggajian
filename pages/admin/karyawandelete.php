<?php 
if(isset($_GET['no_karyawan'])){
    $no_karyawan = $_GET['no_karyawan'];

    $database = new Database();
    $db = $database->getConnection();

    $deleteSql = "DELETE FROM karyawan WHERE no_karyawan = ?";
    $stmt = $db->prepare($deleteSql);
    $stmt->bindParam(1, $_GET['no_karyawan']);
    if($stmt->execute()) {
        $_SESSION['hasil'] = true;
    } else {
        $_SESSION['hasil'] = false;
    }
}
echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
?>