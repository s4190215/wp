<?php
include 'includes/header.inc';
include 'includes/nav.inc';
include 'includes/db_connect.inc';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$phone = trim($_POST['phone']);
$location = trim($_POST['location']);

    // HASH PASSWORD
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // PREPARED STATEMENT
$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO users
    (username, email, password, phone, location)
    VALUES (?, ?, ?, ?, ?)"
);
    mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $username,
    $email,
    $hashedPassword,
    $phone,
    $location
);

    if (mysqli_stmt_execute($stmt)) {

        // GET USER ID
        $user_id = mysqli_insert_id($conn);

        // AUTO LOGIN
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;

        // FLASH MESSAGE
        $_SESSION['flash'] = "Registration successful. Welcome $username!";

        header("Location: index.php");
        exit();

    } else {
        $message = "Registration failed.";
    }
}
?>

<main class="container my-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="mb-4 text-center">Register</h2>

                    <?php if (!empty($message)) { ?>
                        <div class="alert alert-danger">
                            <?= $message ?>
                        </div>
                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone (Optional)</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="mb-3">
                        <label class="form-label">Location (Optional)</label>
                        <input
                            type="text"
                            name="location"
                            class="form-control"
                            placeholder="e.g., Melbourne, VIC">
                    </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Register
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>

<?php include 'includes/footer.inc'; ?>