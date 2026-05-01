
<?php 
include 'includes/header.inc';
include 'includes/nav.inc';
include 'includes/db_connect.inc'; 
?>

<main class="container my-5">

<?php
// 1. CHECK ID
if (!isset($_GET['id'])) {
    echo "<p>No pet selected.</p>";
    exit();
}

$id = $_GET['id'];


// 2. FETCH FROM DATABASE
$stmt = mysqli_prepare($conn, "SELECT * FROM pets WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$pet = mysqli_fetch_assoc($result);

if (!$pet) {
    echo "<p>Pet not found.</p>";
    exit();
}
?>

<!-- 3. DISPLAY (THIS IS STEP 4) -->
<div class="row">

  <div class="col-md-6 mb-4">
    <img src="assets/images/pets/<?= $pet['image'] ?>" class="img-fluid rounded">
  </div>

  <div class="col-md-6">
    <h2><?= $pet['name'] ?></h2>

    <span class="badge bg-primary"><?= $pet['species'] ?></span>
    <span class="badge bg-success"><?= $pet['status'] ?></span>

    <table class="table table-light mt-3">
      <tr><th>Breed</th><td><?= $pet['breed'] ?></td></tr>
      <tr><th>Age</th><td><?= $pet['age_years'] ?> years, <?= $pet['age_months'] ?> months</td></tr>
      <tr><th>Gender</th><td><?= $pet['gender'] ?></td></tr>
      <tr><th>Size</th><td><?= $pet['size'] ?></td></tr>
      <tr><th>Adoption Fee</th><td>$<?= $pet['price'] ?></td></tr>
    </table>
  </div>

</div>

<div class="mt-4">
  <h4>Description</h4>
  <p><?= $pet['description'] ?></p>
</div>

<div class="mt-3">
  <h4>Health Information</h4>
  <p><?= $pet['health'] ?></p>
</div>

</main>