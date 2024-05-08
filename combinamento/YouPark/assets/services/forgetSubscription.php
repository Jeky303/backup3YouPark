<?php
require_once("config.php");
echo($_GET['targaDimentica']);
if (isset($_GET['targaDimentica'])) {
    $query_delete = "DELETE FROM abbonamenti WHERE targa = :targa";
    $stmt_delete = $db->prepare($query_delete);
    $stmt_delete->bindParam(':targa', $_GET['targaDimentica'], PDO::PARAM_STR);
    $stmt_delete->execute();
}
echo'<script>window.history.back();</script>';

?>