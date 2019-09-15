<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="jumbotron jumbotron-flud text-center">
	<div class="container">
		<h5 class="display-3"><?php echo $data['title']; ?></h5>
		<p class="lead"><?php echo $data['description']; ?></p>
	</div>
</div>

<div class="container-fluid text-center" >
	<img src="img/cat_preview.png" alt="cat" class="img-fluid spinl">
	<img src="img/bender_preview.png" alt="bender" class="img-fluid spinl">
	<img src="img/peace_preview.png" alt="peace" class="img-fluid spinr">
	<img src="img/heart_preview.png" alt="heart" class="img-fluid spinr">
	<img src="img/watermelon_preview.png" alt="watermelon" class="img-fluid">
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>