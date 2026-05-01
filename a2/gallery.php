<?php 
include 'includes/header.inc'; 
include 'includes/nav.inc'; 
include 'includes/db_connect.inc';
?>

<main class="container my-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="gallery-title">Pet Gallery</h1>

    <!-- FILTER -->
    <div class="d-flex align-items-center gap-2">
      <span class="material-icons text-info" style="font-size:18px;">filter_list</span>
      <span class="text-light small">Filter by Status:</span>

      <select id="filter" class="form-select custom-filter">
        <option value="all">Show All</option>
        <option value="Available">Available</option>
        <option value="Pending">Pending</option>
        <option value="Adopted">Adopted</option>
      </select>
    </div>
  </div>

  <!-- GRID -->
  <div class="row g-4">

  <?php
    $sql = "SELECT * FROM pets";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
  ?>

    <div class="col-md-3 pet-card" data-status="<?= $row['status'] ?>">
      <div class="card bg-dark text-white border-0 p-2">

        <a href="details.php?id=<?= $row['id'] ?>">
        <img src="assets/images/pets/<?= $row['image'] ?>" class="gallery-img">
        </a>

        <div class="card-body">
          <h5><?= $row['name'] ?></h5>

          <span class="badge bg-primary"><?= $row['species'] ?></span>

          <?php if ($row['status'] == "Available") { ?>
            <span class="badge bg-success">Available</span>
          <?php } elseif ($row['status'] == "Pending") { ?>
            <span class="badge bg-warning text-dark">Pending</span>
          <?php } else { ?>
            <span class="badge bg-secondary">Adopted</span>
          <?php } ?>

          <p class="mt-2">$<?= $row['price'] ?></p>
        </div>

      </div>
    </div>

  <?php } ?>

  </div>

</main>

<!-- MODAL -->
<div class="modal fade" id="imageModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark text-white">

      <div class="modal-header" style="background: linear-gradient(to right, #6366f1, #4f46e5);">
        <h5 class="modal-title" id="modalTitle">Pet Name</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <img id="modalImage" class="img-fluid rounded">
      </div>

    </div>
  </div>
</div>

<?php include 'includes/footer.inc'; ?>