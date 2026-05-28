<?php include 'includes/header.inc'; ?>
<?php include 'includes/nav.inc'; ?>
<?php include 'includes/db_connect.inc'; ?>

<main class="container my-5">

  <h1 class="mb-4">All Available Pets</h1>

  <form method="GET" class="row g-3 mb-4">

  <div class="col-md-4">
    <input 
      type="text" 
      name="search" 
      class="form-control"
      placeholder="Search pets..."
      value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
    >
  </div>

  <div class="col-md-2">
    <select name="status" class="form-control">

      <option value="">All Status</option>

      <option value="Available">
        Available
      </option>

      <option value="Pending">
        Pending
      </option>

      <option value="Adopted">
        Adopted
      </option>

    </select>
  </div>

  <div class="col-md-2">
    <select name="gender" class="form-control">

      <option value="">All Genders</option>

      <option value="Male">
        Male
      </option>

      <option value="Female">
        Female
      </option>

    </select>
  </div>

  <div class="col-md-2">
    <select name="sort" class="form-control">

      <option value="">Sort By</option>

      <option value="latest">
        Latest
      </option>

      <option value="oldest">
        Oldest
      </option>

      <option value="lowprice">
        Lowest Price
      </option>

      <option value="highprice">
        Highest Price
      </option>

    </select>
  </div>

  <div class="col-md-2">
    <button class="btn btn-primary w-100">
      Search
    </button>
  </div>

</form>

  <div class="row align-items-center">

    <!-- LEFT IMAGE -->
    <div class="col-md-5 mb-4">
      <img src="assets/images/pets/pets_banner.jpg" class="img-fluid rounded">
    </div>

    <!-- RIGHT TABLE -->
    <div class="col-md-7">

      <table class="table table-light table-striped">

        <thead class="table-dark">
          <tr>
            <th>Name</th>
            <th>Species</th>
            <th>Breed</th>
            <th>Size</th>
            <th>Fee ($)</th>
          </tr>
        </thead>

        <tbody>

        <?php

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$gender = $_GET['gender'] ?? '';
$sort = $_GET['sort'] ?? '';

$sql = "SELECT * FROM pets WHERE 1=1";

$params = [];
$types = "";

// SEARCH
if (!empty($search)) {

    $sql .= " AND (name LIKE ? OR species LIKE ? OR breed LIKE ?)";

    $searchTerm = "%$search%";

    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;

    $types .= "sss";
}

// STATUS
if (!empty($status)) {

    $sql .= " AND status = ?";

    $params[] = $status;

    $types .= "s";
}

// GENDER
if (!empty($gender)) {

    $sql .= " AND gender = ?";

    $params[] = $gender;

    $types .= "s";
}

// SORTING
switch ($sort) {

    case 'latest':
        $sql .= " ORDER BY id DESC";
        break;

    case 'oldest':
        $sql .= " ORDER BY id ASC";
        break;

    case 'lowprice':
        $sql .= " ORDER BY price ASC";
        break;

    case 'highprice':
        $sql .= " ORDER BY price DESC";
        break;

    default:
        $sql .= " ORDER BY id DESC";
}

$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {

    mysqli_stmt_bind_param(
        $stmt,
        $types,
        ...$params
    );
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);


        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>

          <tr>
            <td>
              <a href="details.php?id=<?= htmlspecialchars($row['id']) ?>">
                <?= htmlspecialchars($row['name']) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($row['species']) ?></td>
            <td><?= htmlspecialchars($row['breed']) ?></td>
            <td><?= htmlspecialchars($row['size']) ?></td>
            <td>$<?= htmlspecialchars($row['price']) ?></td>
          </tr>

        <?php 
            }
        } else {
        ?>

          <tr>
            <td colspan="5" class="text-center">No pets found</td>
          </tr>

        <?php } ?>

        </tbody>

      </table>

    </div>

  </div>

</main>

<?php include 'includes/footer.inc'; ?>