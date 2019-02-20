<?php

include 'header.php';
?>

	<section class="main-container">
		<div class="main-wrapper">
			<h2>Home</h2>
			<?php
			if (isset($_SESSION['u_id'])){
				echo "You are logged in";
			}
			?>
		</div>
		
	</section>

	<?php
include 'footer.php';
?>

