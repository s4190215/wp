<?php 
include 'includes/header.inc'; 
include 'includes/nav.inc'; 
include 'includes/db_connect.inc'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // CLEAN INPUTS
  $name = trim($_POST['name']);
  $species = trim($_POST['species']);
  $breed = trim($_POST['breed']);
  $age_years = (int) $_POST['age_years'];
  $age_months = (int) $_POST['age_months'];
  $gender = trim($_POST['gender']);
  $size = trim($_POST['size']);
  $price = (float) $_POST['price'];
  $description = trim($_POST['description']);
  $health = trim($_POST['health']);
  $status = trim($_POST['status']);

  // IMAGE UPLOAD VALIDATION
  $image = $_FILES['image'];

  if ($image['error'] === 0) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($image['type'], $allowedTypes)) {
      echo "<div class='alert alert-danger'>Invalid image type!</div>";
      exit();
    }

    // UNIQUE NAME
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $newImageName = uniqid("pet_", true) . "." . $extension;

    $uploadPath = "assets/images/pets/" . $newImageName;

    if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
      echo "<div class='alert alert-danger'>Image upload failed!</div>";
      exit();
    }

  } else {
    echo "<div class='alert alert-danger'>No image uploaded!</div>";
    exit();
  }

  // INSERT INTO DATABASE
  $stmt = mysqli_prepare($conn, 
    "INSERT INTO pets 
    (name, species, breed, age_years, age_months, gender, size, price, description, health, status, image) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
  );

  mysqli_stmt_bind_param(
    $stmt, 
    "sssiiissssss", 
    $name, 
    $species, 
    $breed, 
    $age_years, 
    $age_months, 
    $gender, 
    $size, 
    $price, 
    $description, 
    $health, 
    $status, 
    $newImageName
  );

  mysqli_stmt_execute($stmt);

  echo "<div class='container mt-3 alert alert-success'>Pet added successfully!</div>";
}
?>

<main class="container my-5">

  <h1 class="mb-4">
    <span class="material-icons">add_circle</span>
    Add a New Pet for Adoption
  </h1>

  <!-- IMPORTANT: enctype -->
  <form method="POST" enctype="multipart/form-data">

    <div class="row g-3">

      <div class="col-md-6">
        <label class="form-label">Pet Name *</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Species *</label>
        <select name="species" class="form-control" required>
          <option value="">Select species</option>
          <option>Dog</option>
          <option>Cat</option>
          <option>Bird</option>
          <option>Rabbit</option>
          <option>Other</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Breed</label>
        <input type="text" name="breed" class="form-control">
      </div>

      <div class="col-md-3">
        <label class="form-label">Age (Years)</label>
        <input type="number" name="age_years" class="form-control">
      </div>

      <div class="col-md-3">
        <label class="form-label">Age (Months)</label>
        <input type="number" name="age_months" class="form-control">
      </div>

      <div class="col-md-4">
        <label class="form-label">Gender *</label>
        <select name="gender" class="form-control" required>
          <option value="">Select gender</option>
          <option>Male</option>
          <option>Female</option>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">Size *</label>
        <select name="size" class="form-control" required>
          <option value="">Select size</option>
          <option>Small</option>
          <option>Medium</option>
          <option>Large</option>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">Adoption Fee ($) *</label>
        <input type="number" name="price" class="form-control" required>
      </div>

      <div class="col-12">
        <label class="form-label">Description *</label>
        <textarea name="description" class="form-control" rows="3" required></textarea>
      </div>

      <div class="col-12">
        <label class="form-label">Health Information</label>
        <textarea name="health" class="form-control" rows="2"></textarea>
      </div>

      <div class="col-12">
        <label class="form-label">Status *</label>
        <select name="status" class="form-control" required>
          <option value="">Select status</option>
          <option>Available</option>
          <option>Pending</option>
          <option>Adopted</option>
        </select>
      </div>

      <div class="col-12">
      <label class="form-label">Pet Photo</label>
      <input type="file" name="image" class="form-control" required accept="image/*">
    </div>

      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Add Pet</button>
        <button type="reset" class="btn btn-danger">Cancel</button>
      </div>

    </div>

  </form>

</main>

<?php include 'includes/footer.inc'; ?>