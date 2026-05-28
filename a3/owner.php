<?php
include 'includes/header.inc';
include 'includes/nav.inc';
include 'includes/db_connect.inc';

if (!isset($_SESSION['user_id'])) {

    $_SESSION['flash'] = "Please login first.";

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM pets WHERE owner_id = ? ORDER BY id DESC"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<main class="container my-5">

    <h1 class="mb-4">
        My Pets
    </h1>

    <div class="row">

    <?php while ($pet = mysqli_fetch_assoc($result)): ?>

        <div class="col-md-4 mb-4">

            <div class="card h-100 shadow-sm">

                <img 
                    src="assets/images/pets/<?= htmlspecialchars($pet['image']) ?>" 
                    class="card-img-top"
                    style="height:250px; object-fit:cover;"
                >

                <div class="card-body">

                    <h5><?= htmlspecialchars($pet['name']) ?></h5>

                    <p class="text-muted">
                        <?= htmlspecialchars($pet['breed']) ?>
                    </p>

                    <span class="badge bg-primary">
                        <?= htmlspecialchars($pet['status']) ?>
                    </span>

                    <div class="mt-3">

                        <a 
                            href="details.php?id=<?= $pet['id'] ?>" 
                            class="btn btn-dark btn-sm"
                        >
                            View Details
                        </a>

                    </div>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

    </div>

</main>

<?php include 'includes/footer.inc'; ?>