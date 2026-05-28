<?php
session_start();
?>

<?php if (isset($_SESSION['flash'])): ?>

<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show">

        <?= $_SESSION['flash']; ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

    </div>
</div>

<?php unset($_SESSION['flash']); ?>

<?php endif; ?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetConnect</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/styles.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/images/pets/favicon.ico">
</head>

<body>