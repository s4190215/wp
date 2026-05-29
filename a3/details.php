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
$stmt = mysqli_prepare(
    $conn,
    "SELECT pets.*, users.username, users.email, users.phone, users.location
     FROM pets
     LEFT JOIN users
     ON pets.owner_id = users.id
     WHERE pets.id = ?"
);
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

  <div class="col-lg-4 mb-4">
    <img src="<?= $imagePath ?>" class="img-fluid rounded">
  </div>

  <div class="col-lg-8">
    <h2 class="fw-bold mb-2" style="color:#7c6cff;">
    <?= htmlspecialchars($pet['name']) ?>
</h2>

    <span class="badge rounded-pill px-3 py-2"
      style="background:#7c6cff;"><?= htmlspecialchars($pet['species']) ?></span>
    <span class="badge rounded-pill px-3 py-2"
      style="background:#ff4d94;"><?= htmlspecialchars($pet['status']) ?></span>

    <table class="table table-light table-bordered mt-3 rounded overflow-hidden">
      <tr><th>Breed</th><td><?= htmlspecialchars($pet['breed']) ?></td></tr>
      <tr>
        <th>Age</th>
        <td><?= htmlspecialchars($pet['age_years']) ?> years, <?= htmlspecialchars($pet['age_months']) ?> months</td>
      </tr>
      <tr><th>Gender</th><td><?= htmlspecialchars($pet['gender']) ?></td></tr>
      <tr><th>Size</th><td><?= htmlspecialchars($pet['size']) ?></td></tr>
      <tr><th>Adoption Fee</th><td>$<?= htmlspecialchars($pet['price']) ?></td></tr>
    </table>

    <h5 class="mt-4">
  <span class="material-icons text-primary" style="font-size:18px;">
    description
  </span>
  Description
</h5>

<p>
  <?= htmlspecialchars($pet['description']) ?>
</p>

<h5 class="mt-4">
  <span class="material-icons text-success" style="font-size:18px;">
    health_and_safety
  </span>
  Health Information
</h5>

<p>
  <?= htmlspecialchars($pet['health']) ?>
</p>

<h5>Contact Owner</h5>

<p>
  <span class="material-icons align-middle text-primary" style="font-size:14px;">
    person
  </span>
  Name:
  <?= htmlspecialchars($pet['username']) ?>
</p>

<p>
  <span class="material-icons align-middle text-primary" style="font-size:14px;">
    email
  </span>
  Email:
  <?= htmlspecialchars($pet['email']) ?>
</p>

<p>
  <span class="material-icons align-middle text-primary" style="font-size:14px;">
    call
  </span>
  Phone:
  <?= htmlspecialchars($pet['phone']) ?>
</p>

<p>
  <span class="material-icons align-middle text-primary" style="font-size:14px;">
    location_on
  </span>
  Location:
  <?= htmlspecialchars($pet['location']) ?>
</p>

<?php if (
    isset($_SESSION['user_id']) &&
    $_SESSION['user_id'] == $pet['owner_id']
): ?>

<hr>

<a href="edit.php?id=<?= $pet['id'] ?>"
   class="btn btn-warning btn-sm me-2">

   <span class="material-icons align-middle" style="font-size:14px;">
       edit
   </span>

   Edit
</a>

<button
    type="button"
    class="btn btn-danger btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#deleteModal">

    <span class="material-icons align-middle" style="font-size:14px;">
        delete
    </span>

    Delete
</button>

<?php endif; ?>

  </div>

</div>

<hr>


</main>
<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">

  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content border-0">

      <!-- HEADER -->
      <div class="modal-header text-white"
           style="background:#ff4d94;">

        <h5 class="modal-title">

          <span class="material-icons align-middle"
                style="font-size:18px;">

            warning
          </span>

          Confirm Deletion

        </h5>

        <button type="button"
                class="btn-close btn-close-white"
                data-bs-dismiss="modal">
        </button>

      </div>

      <!-- BODY -->
      <div class="modal-body">

        Are you sure you want to delete

        <strong>
          <?= htmlspecialchars($pet['name']) ?>
        </strong>

        ?

        <hr>

        <small class="text-muted">
          This action cannot be undone.
        </small>

      </div>

      <!-- FOOTER -->
      <div class="modal-footer">

        <button
          type="button"
          class="btn btn-secondary"
          data-bs-dismiss="modal">

          Cancel

        </button>

        <a
          href="delete.php?id=<?= $pet['id'] ?>"
          class="btn btn-danger">

          Yes, Delete

        </a>

      </div>

    </div>

  </div>

</div>
<?php include 'includes/footer.inc'; ?>