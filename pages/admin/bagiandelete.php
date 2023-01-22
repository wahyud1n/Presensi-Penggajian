<?php 
if(isset($_GET['no_bagian'])){
    $no_bagian = $_GET['no_bagian'];

    $database = new Database();
    $db = $database->getConnection();

    $deleteSql = "DELETE FROM bagian WHERE no_bagian = ?";
    $stmt = $db->prepare($deleteSql);
    $stmt->bindParam(1, $_GET['no_bagian']);
    if($stmt->execute()) {
        $_SESSION['hasil'] = true;
    } else {
        $_SESSION['hasil'] = false;
    }
}
echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
?>