<?php 
if(isset($_GET['no_jabatan'])){
    $no_jabatan = $_GET['no_jabatan'];

    $database = new Database();
    $db = $database->getConnection();

    $deleteSql = "DELETE FROM jabatan WHERE no_jabatan = ?";
    $stmt = $db->prepare($deleteSql);
    $stmt->bindParam(1, $_GET['no_jabatan']);
    if($stmt->execute()) {
        $_SESSION['hasil'] = true;
    } else {
        $_SESSION['hasil'] = false;
    }
}
echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
?>