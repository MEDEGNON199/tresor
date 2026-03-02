<?php
require_once 'connexion.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $id = (int)$id;
    $query = "DELETE FROM oeuvre WHERE id_oeuvre = $id";
    mysqli_query($connexion, $query);
}

header('Location: index.php');
exit;