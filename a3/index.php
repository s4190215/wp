<?php include 'includes/header.inc'; ?>
<?php include 'includes/nav.inc'; ?>
<?php include 'includes/db_connect.inc'; ?>

<main class="container my-5">

  <!-- CAROUSEL -->
  <div id="petCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">

      <div class="carousel-item active">
        <img src="assets/images/pets/dog1.jpg" class="d-block w-100 rounded">
        <div class="carousel-caption">
          <h3>Buddy</h3>
        </div>
      </div>

      <div class="carousel-item">
        <img src="assets/images/pets/cat1.jpg" class="d-block w-100 rounded">
        <div class="carousel-caption">
          <h3>Whiskers</h3>
        </div>
      </div>

      <div class="carousel-item">
        <img src="assets/images/pets/dog2.jpg" class="d-block w-100 rounded">
        <div class="carousel-caption">
          <h3>Max</h3>
        </div>
      </div>

      <div class="carousel-item">
        <img src="assets/images/pets/bird.jpg" class="d-block w-100 rounded">
        <div class="carousel-caption">
          <h3>Charlie</h3>
        </div>
      </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <h2 class="mb-4">
    <span class="material-icons text-danger">favorite</span>
    Recently Added Pets
  </h2>

  <div class="row g-4">

  <?php
$sql = "SELECT * FROM pets ORDER BY id DESC LIMIT 4";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>

  <div class="col-md-3">
    <div class="card bg-dark text-white border-0">
      <img src="assets/images/pets/<?= $row['image'] ?>" class="card-img-top">

      <div class="card-body">
        <h5><?= $row['name'] ?></h5>
        <p>$<?= $row['price'] ?></p>
      </div>
    </div>
  </div>

<?php } ?>

  </div>

</main>

<?php include 'includes/footer.inc'; ?>