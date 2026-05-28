<?php
include 'includes/header.inc';
include 'includes/nav.inc';
include 'includes/db_connect.inc';

if (!isset($_SESSION['user_id'])) {

    $_SESSION['flash'] = "Please login first.";

    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {

    echo "<div class='container mt-5 alert alert-danger'>No pet selected.</div>";
    exit();
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM pets WHERE id = ? AND owner_id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $id,
    $_SESSION['user_id']
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$pet = mysqli_fetch_assoc($result);

if (!$pet) {

    echo "<div class='container mt-5 alert alert-danger'>Unauthorized access.</div>";
    exit();
}

// DELETE IMAGE
$imagePath = "assets/images/pets/" . $pet['image'];

if (file_exists($imagePath)) {
    unlink($imagePath);
}

// DELETE PET
$delete = mysqli_prepare(
    $conn,
    "DELETE FROM pets WHERE id = ? AND owner_id = ?"
);

mysqli_stmt_bind_param(
    $delete,
    "ii",
    $id,
    $_SESSION['user_id']
);

mysqli_stmt_execute($delete);

$_SESSION['flash'] = "Pet deleted successfully.";

header("Location: owner.php");
exit();
?>