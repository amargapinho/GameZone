<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="?">GameZone</a>
	<button
		class="navbar-toggler"
		type="button"
		data-toggle="collapse"
		data-target="#navbarSupportedContent"
		aria-controls="navbarSupportedContent"
		aria-expanded="false"
		aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item
				<?php if (empty($_GET)): ?>
					active
				<?php endif; ?>
            ">
				<a class="nav-link" href="?">Spiele</a>
			</li>
			
			<li class="nav-item
				<?php if (isset($_GET['action'])&&$_GET['action']==='wishlist'): ?>
					active
				<?php endif; ?>
            ">
				<a class="nav-link" href="?action=wishlist">Wunschliste</a>
			</li>
			
			<li class="nav-item
				<?php if (isset($_GET['action'])&&$_GET['action']==='categories'): ?>
					active
				<?php endif; ?>
            ">
				<a class="nav-link" href="?action=categories">Kategorien</a>
			</li>
			
			<li class="nav-item
				<?php if (isset($_GET['action'])&&$_GET['action']==='recover'): ?>
					active
				<?php endif; ?>
            ">
				<a class="nav-link" href="?action=recover">Gelöschte Spiele</a>
			</li>
		</ul>
	</div>
</nav>