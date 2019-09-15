<nav class="navbar navbar-expand-lg navbar-dark mb-3 rainbow">
	<div class="container">
		<a class="navbar-brand" href="/">CAMAGRU</a>
			<ul class="navbar-nav ">
				<?php if (isset($_SESSION['user_id'])) { ?>
					<li class="nav-item">
						<a class="nav-link" href="#">Welcome, <?php echo $_SESSION['user_name']; ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/montages/index">Gallery</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/montages/montagesUpload">Montage</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/users/modify">Modify Info</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/users/logout">Logout</a>
					</li>

				<?php } else { ?>
					<li class="nav-item">
						<a class="nav-link" href="/montages/index">Gallery</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/users/register">Register</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/users/login">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/montages/montagesUpload">Montage</a>
					</li>
				<?php } ?>
			</ul>
		<!-- </div> -->
	</div>
</nav>