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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $species = trim($_POST['species']);
    $breed = trim($_POST['breed']);
    $gender = trim($_POST['gender']);
    $size = trim($_POST['size']);
    $price = (float) $_POST['price'];
    $description = trim($_POST['description']);
    $health = trim($_POST['health']);
    $status = trim($_POST['status']);

    $update = mysqli_prepare(
        $conn,
        "UPDATE pets 
        SET name=?, species=?, breed=?, gender=?, size=?, price=?, description=?, health=?, status=?
        WHERE id=? AND owner_id=?"
    );

    mysqli_stmt_bind_param(
        $update,
        "sssssdsssii",
        $name,
        $species,
        $breed,
        $gender,
        $size,
        $price,
        $description,
        $health,
        $status,
        $id,
        $_SESSION['user_id']
    );

    mysqli_stmt_execute($update);

    $_SESSION['flash'] = "Pet updated successfully.";

    header("Location: owner.php");
    exit();
}
?>

<main class="container my-5">

<h1 class="mb-4">Edit Pet</h1>

<form method="POST">

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">Pet Name</label>
<input 
type="text" 
name="name" 
class="form-control"
value="<?= htmlspecialchars($pet['name']) ?>"
required
>
</div>

<div class="col-md-6">
<label class="form-label">Species</label>
<input 
type="text" 
name="species" 
class="form-control"
value="<?= htmlspecialchars($pet['species']) ?>"
required
>
</div>

<div class="col-md-6">
<label class="form-label">Breed</label>
<input 
type="text" 
name="breed" 
class="form-control"
value="<?= htmlspecialchars($pet['breed']) ?>"
>
</div>

<div class="col-md-6">
<label class="form-label">Gender</label>
<select name="gender" class="form-control">

<option <?= $pet['gender'] == 'Male' ? 'selected' : '' ?>>
Male
</option>

<option <?= $pet['gender'] == 'Female' ? 'selected' : '' ?>>
Female
</option>

</select>
</div>

<div class="col-md-6">
<label class="form-label">Size</label>

<select name="size" class="form-control">

<option <?= $pet['size'] == 'Small' ? 'selected' : '' ?>>
Small
</option>

<option <?= $pet['size'] == 'Medium' ? 'selected' : '' ?>>
Medium
</option>

<option <?= $pet['size'] == 'Large' ? 'selected' : '' ?>>
Large
</option>

</select>

</div>

<div class="col-md-6">
<label class="form-label">Price</label>
<input 
type="number" 
name="price" 
class="form-control"
value="<?= $pet['price'] ?>"
required
>
</div>

<div class="col-12">
<label class="form-label">Description</label>

<textarea 
name="description" 
class="form-control"
rows="4"
required
><?= htmlspecialchars($pet['description']) ?></textarea>

</div>

<div class="col-12">
<label class="form-label">Health</label>

<textarea 
name="health" 
class="form-control"
rows="3"
><?= htmlspecialchars($pet['health']) ?></textarea>

</div>

<div class="col-md-6">
<label class="form-label">Status</label>

<select name="status" class="form-control">

<option <?= $pet['status'] == 'Available' ? 'selected' : '' ?>>
Available
</option>

<option <?= $pet['status'] == 'Pending' ? 'selected' : '' ?>>
Pending
</option>

<option <?= $pet['status'] == 'Adopted' ? 'selected' : '' ?>>
Adopted
</option>

</select>

</div>

<div class="col-12 mt-3">

<button class="btn btn-primary">
Update Pet
</button>

<a href="owner.php" class="btn btn-secondary">
Cancel
</a>

</div>

</div>

</form>

</main>

<?php include 'includes/footer.inc'; ?>