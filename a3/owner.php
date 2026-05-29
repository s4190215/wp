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

    <h1 class="mb-2 text-primary fw-bold">
    Pets by <?= htmlspecialchars($_SESSION['username']) ?>
</h1>

<p class="text-light mb-4">
    <span class="material-icons align-middle" style="font-size:18px;">
        location_on
    </span>
    Location: Melbourne, Australia
</p>

<hr class="mb-4">

    <div class="row">

    <?php while ($pet = mysqli_fetch_assoc($result)): ?>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

            <div class="card h-100 border-0 shadow">

                <img 
                    src="assets/images/pets/<?= htmlspecialchars($pet['image']) ?>" 
                    class="card-img-top"
                    style="height:180px; object-fit:cover;"
                >

                <div class="card-body">

                    <h5><?= htmlspecialchars($pet['name']) ?></h5>
                    <div class="mb-2">

                    <span class="badge bg-primary">
                        <?= htmlspecialchars($pet['species']) ?>
                    </span>

                    <span class="badge bg-success">
                        <?= htmlspecialchars($pet['status']) ?>
                    </span>

                    </div>

                    <p class="small text-muted mb-1">
                        <?= htmlspecialchars($pet['breed']) ?>
                    </p>

                    <p class="fw-bold">
                        $<?= number_format($pet['price'], 2) ?>
                    </p>

                    

                    <div class="fw-bold">
                        <div class="d-flex gap-2 flex-wrap">
                        <a 
                            href="details.php?id=<?= $pet['id'] ?>" 
                            class="btn btn-primary btn-sm"
                        >
                            View Details
                        </a>

                        
                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

    </div>

</main>

<?php include 'includes/footer.inc'; ?>