<header>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container d-flex align-items-center">

      <!-- LOGO -->
      <div class="d-flex align-items-center">
        <span class="material-icons me-2">pets</span>
        <a class="navbar-brand fw-semibold m-0" href="index.php">PetConnect</a>
      </div>

      <!-- TOGGLE -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- LINKS -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav align-items-center ms-4">

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="index.php">
              <span class="material-icons me-1" style="font-size:18px;">home</span>
              Home
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="pets.php">
              <span class="material-icons me-1" style="font-size:18px;">list</span>
              Browse Pets
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="gallery.php">
              <span class="material-icons me-1" style="font-size:18px;">photo</span>
              Gallery
            </a>
          </li>

          <?php if (isset($_SESSION['user_id'])): ?>

  <li class="nav-item">
    <a class="nav-link d-flex align-items-center" href="add.php">
      <span class="material-icons me-1" style="font-size:18px;">add_circle</span>
      Add Pet
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link d-flex align-items-center" href="#">
      <span class="material-icons me-1" style="font-size:18px;">person</span>
      <?= htmlspecialchars($_SESSION['username']) ?>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link d-flex align-items-center" href="logout.php">
      <span class="material-icons me-1" style="font-size:18px;">logout</span>
      Logout
    </a>
  </li>

<?php else: ?>

  <li class="nav-item">
    <a class="nav-link d-flex align-items-center" href="register.php">
      <span class="material-icons me-1" style="font-size:18px;">person_add</span>
      Register
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link d-flex align-items-center" href="login.php">
      <span class="material-icons me-1" style="font-size:18px;">login</span>
      Login
    </a>
  </li>

<?php endif; ?>

        </ul>
      </div>

    </div>
  </nav>
</header>