<!--Footer-->
<div class="container bg-dark">
			<footer class="row row-cols-3 my-4 border-top">
				<div class="col">
					<a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
						<svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
					</a>
					<p class="text-muted">&copy; 2022</p>
				</div>            

            <div class="col">
            <h5>User Links</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="index.php" class="nav-link p-0 text-muted">Home</a></li>
                    <li class="nav-item mb-2"><a href="userpanel.php?id=<?=$_SESSION['user_id']?>" class="nav-link p-0 text-muted">User Settings</a></li>
                </ul>
            </div>
            
            <div class="col">
            <h5 style="color: white;">Movie Categories</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="category.php?id=1" class="nav-link p-0 text-muted">Science Fiction</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=2" class="nav-link p-0 text-muted">Comedy</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=3" class="nav-link p-0 text-muted">Romantic</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=4" class="nav-link p-0 text-muted">Action</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=5" class="nav-link p-0 text-muted">Christmas</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=6" class="nav-link p-0 text-muted">Halloween</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=7" class="nav-link p-0 text-muted">Drama</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=8" class="nav-link p-0 text-muted">Documentary</a></li>
                </ul> 
            </div>
        </footer>
    </div>