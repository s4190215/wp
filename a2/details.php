<?php 
include 'includes/header.inc';
include 'includes/nav.inc';
include 'includes/db_connect.inc'; 
?>

<main class="container my-5">

<?php
// 1. VALIDATE ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid pet ID.</p>";
    exit();
}

$id = (int) $_GET['id'];

// 2. FETCH FROM DATABASE (Prepared Statement)
$stmt = mysqli_prepare($conn, "SELECT * FROM pets WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$pet = mysqli_fetch_assoc($result);

if (!$pet) {
    echo "<p>Pet not found.</p>";
    exit();
}

// 3. IMAGE PATH (SAFE FALLBACK)
$imagePath = "assets/images/pets/" . htmlspecialchars($pet['image']);
if (empty($pet['image']) || !file_exists($imagePath)) {
    $imagePath = "assets/images/pets/default.jpg"; // optional fallback image
}
?>

<!-- DISPLAY -->
<div class="row">

  <div class="col-md-6 mb-4">
    <img src="<?= $imagePath ?>" class="img-fluid rounded">
  </div>

  <div class="col-md-6">
    <h2><?= htmlspecialchars($pet['name']) ?></h2>

    <span class="badge bg-primary"><?= htmlspecialchars($pet['species']) ?></span>
    <span class="badge bg-success"><?= htmlspecialchars($pet['status']) ?></span>

    <table class="table table-light mt-3">
      <tr><th>Breed</th><td><?= htmlspecialchars($pet['breed']) ?></td></tr>
      <tr>
        <th>Age</th>
        <td><?= htmlspecialchars($pet['age_years']) ?> years, <?= htmlspecialchars($pet['age_months']) ?> months</td>
      </tr>
      <tr><th>Gender</th><td><?= htmlspecialchars($pet['gender']) ?></td></tr>
      <tr><th>Size</th><td><?= htmlspecialchars($pet['size']) ?></td></tr>
      <tr><th>Adoption Fee</th><td>$<?= htmlspecialchars($pet['price']) ?></td></tr>
    </table>
  </div>

</div>

<div class="mt-4">
  <h4>Description</h4>
  <p><?= htmlspecialchars($pet['description']) ?></p>
</div>

<div class="mt-3">
  <h4>Health Information</h4>
  <p><?= htmlspecialchars($pet['health']) ?></p>
</div>

</main>

<?php include 'includes/footer.inc'; ?>