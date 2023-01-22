<?php 
if(isset($_GET['no_lokasi'])){
    $no_lokasi = $_GET['no_lokasi'];

    $database = new Database();
    $db = $database->getConnection();

    $deleteSql = "DELETE FROM lokasi WHERE no_lokasi = ?";
    $stmt = $db->prepare($deleteSql);
    $stmt->bindParam(1, $_GET['no_lokasi']);
    if($stmt->execute()) {
        $_SESSION['hasil'] = true;
    } else {
        $_SESSION['hasil'] = false;
    }
}
echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
?>