<?php
include 'includes/header.inc';
include 'includes/nav.inc';
include 'includes/db_connect.inc';
?>

<main class="container my-5">

    <h1 class="gallery-title mb-4">
        Search Pets
    </h1>

    <!-- SEARCH FORM -->
    <form method="GET" class="mb-4">

        <div class="input-group">

            <input
                type="text"
                name="q"
                class="form-control"
                placeholder="Search pets..."
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
            >

            <button class="btn btn-primary">
                Search
            </button>

        </div>

    </form>

<?php

if (isset($_GET['q']) && !empty(trim($_GET['q']))) {

    $search = trim($_GET['q']);
    $searchTerm = "%$search%";

    $stmt = mysqli_prepare(
        $conn,
        "SELECT *
         FROM pets
         WHERE name LIKE ?
         OR description LIKE ?
         ORDER BY id DESC"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $searchTerm,
        $searchTerm
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
?>

    <h5 class="text-light mb-4">
        Search Results for
        "<strong><?= htmlspecialchars($search) ?></strong>"
    </h5>

    <div class="row g-4">

    <?php

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
    ?>

        <div class="col-md-3">

            <div class="card bg-dark text-white border-0 h-100">

                <img
                    src="assets/images/pets/<?= htmlspecialchars($row['image']) ?>"
                    class="card-img-top"
                    style="height:200px; object-fit:cover;"
                >

                <div class="card-body">

                    <h5>
                        <?= htmlspecialchars($row['name']) ?>
                    </h5>

                    <span class="badge bg-primary">
                        <?= htmlspecialchars($row['species']) ?>
                    </span>

                    <?php if ($row['status'] == "Available") { ?>
                        <span class="badge bg-success">Available</span>
                    <?php } elseif ($row['status'] == "Pending") { ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                    <?php } else { ?>
                        <span class="badge bg-secondary">Adopted</span>
                    <?php } ?>

                    <p class="mt-2">
                        $<?= htmlspecialchars($row['price']) ?>
                    </p>

                    <a
                        href="details.php?id=<?= $row['id'] ?>"
                        class="btn btn-primary btn-sm"
                    >
                        View Details
                    </a>

                </div>

            </div>

        </div>

    <?php
        }
    } else {
    ?>

        <div class="col-12">
            <div class="alert alert-warning">
                No pets found.
            </div>
        </div>

    <?php } ?>

    </div>

<?php } ?>

</main>

<?php include 'includes/footer.inc'; ?>