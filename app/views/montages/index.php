<?php require APPROOT . '/views/inc/header.php'; ?>

<?php flash_message() ?>

<!-- IF GALLERY IS EMPTY -->
<?php if(sizeof($data['montages']) == 0) : ?>
	<div class="text-center big-ass-text center-div">
		There is nothing in the gallery yet, be the first one to post a picture!
	</div>
<?php endif; ?>

<!-- IF GALLERY IS NOT EMPTY -->
<?php foreach ($data['montages'] as $pageNumber => $page) : ?>

	<div class="page <?= ($pageNumber != 1 ? 'd-none' : '') ?>" data-pagenumber="<?= $pageNumber ?>">
		<h2>Page <?= $pageNumber ?></h2>

		<?php foreach ($page as $montageId => $montage) : ?>
			<div class="card card-body mb-3 container-fluid">
				<a href="/montages/<?php echo $montage->montageId; ?>">
					<img src="/photos/<?php echo $montage->montageFilename; ?>" class="img-fluid rounded mx-auto d-block half-width" alt="Responsive image">
				</a>
				<div class="bg-light p-2 mb3">
					<span>made by <?php echo $montage->userName; ?> on <?php echo $montage->montageCreatedAt; ?></span>
				</div>
				<a href="/montages/<?php echo $montage->montageId; ?>" class="btn btn-primary">Read Comments and Put a Like</a> 
			</div>
		<?php endforeach; ?>

	</div>

<?php endforeach; ?>

<?php foreach($data['montages'] as $pageNumber => $page) : ?>
	<button class="pageButton" value="<?= $pageNumber ?>"><?= $pageNumber ?></button>
<?php endforeach; ?>
<!-- 
<nav aria-label="Page navigation example">
	<ul class="all pagination pagination-sm justify-content-center">
		<li class="page-item"><a class="page-link link2" href="#">Prev</a></li>
	</ul>
</nav> -->

<script src="/js/pagination.js"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>