<!-- NavBar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container">
    <a href="index.php" class="navbar-brand">iMovieRatings</a>
      <button 
        class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navmenu"
      >
        <span class="span-navbar-toggler-icon"><i class="bi bi-list"></i></span>
      </button>

      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
        <?php if($_SESSION['username']): ?>
          <li class="nav-item">
            <h5 class="text-danger">Hello, <?= $_SESSION['username'] ?></h5>
          </li>
          <li class="nav-item">
            <a href="userpanel.php?id=<?= $_SESSION['user_id'] ?>" class="nav-link">User Settings</a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">Logout</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a href="login.php" class="nav-link">Login</a>
          </li>
        <?php endif ?>
        <?php if($_SESSION['username'] == "admin"): ?>
          <li class="nav-item">
            <a href="adminpanel.php" class="nav-link">Admin Panel</a>
          </li>
        <?php endif ?>
        </ul>
        <form method="post">
          <input class = "search" type="text" name="search">
          <button type="submit" id="button" class="btn btn-danger">Search</button>
        </form>
      </div>
  </div>
</nav> 