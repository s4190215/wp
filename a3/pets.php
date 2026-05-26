<?php include 'includes/header.inc'; ?>
<?php include 'includes/nav.inc'; ?>
<?php include 'includes/db_connect.inc'; ?>

<main class="container my-5">

  <h1 class="mb-4">All Available Pets</h1>

  <!-- SEARCH -->
  <form method="GET" class="mb-4 d-flex">
    <input type="text" name="search" class="form-control me-2" 
      placeholder="Search pet by name..." 
      value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button class="btn btn-primary">Search</button>
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
        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {

            $search = trim($_GET['search']);
            $searchParam = "%$search%";

            $stmt = mysqli_prepare($conn, 
              "SELECT * FROM pets 
               WHERE (name LIKE ? OR species LIKE ?) 
               AND status = 'Available'"
            );

            mysqli_stmt_bind_param($stmt, "ss", $searchParam, $searchParam);

        } else {

            $stmt = mysqli_prepare($conn, 
              "SELECT * FROM pets 
               WHERE status='Available' 
               ORDER BY id DESC"
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