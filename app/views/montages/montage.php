<?php require APPROOT . '/views/inc/header.php'; ?>

<pre>
	<!-- <?php
	//var_dump($data);
	?> -->
</pre>
<?php flash_message() ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-1">
			<a href="/montages" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
		</div>
		<div class="col-10">
			<p>
				<div class="text-center">
					<img src="/photos/<?php echo $data['montage']->montageFilename; ?>" alt="" style="width:40vw" class="rounded">
				</div>
				<div class="bg-info text-white p-3 mb-8">
					Made by <?php echo $data['montage']->userName; ?> on <?php echo $data['montage']->montageCreatedAt;?>

					<?php if (isset($_SESSION['user_id'])) : ?>
						<?php if ($data['alreadyLiked']) : ?>
							<a class="btn btn-outline-warning" href="/montages/unlike/<?= $data['montage']->montageId ?>"> Unlike</a>
						<?php else : ?>
							<a class="btn btn-danger" href="/montages/like/<?= $data['montage']->montageId ?>"><i class="fa fa-heart"></i> Like!</a>
						<?php endif; ?>
					<?php endif; ?>

					<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['montage']->userId) :?>
						<a class="btn btn-dark" href="/montages/delete/<?= $data['montage']->montageId ?>">Delete</a>
					<?php endif;?>
				</div>
			</p>
		</div>
		<div class="col-1">
		</div>
	</div>
</div>


<?php foreach ($data['comments'] as $comment) : ?>
	<div class="card card-body mb-3 container-fluid">
		<p class="card-text"><?php echo $comment->comment; ?></p>
		<div class="bg-light p-2 mb3">
			made by <?php echo $data['montage']->userName; ?> on <?php echo $data['montage']->montageCreatedAt; ?>
		</div>
	</div>
<?php endforeach; ?>

<?php if (isset($_SESSION['user_id'])) : ?>
	<form action="/montages/<?= $data['montage']->montageId ?>" method="post" class="add-comment-form mb-4">
		<div class="form-group">
			<label for="comment">Comment:</label>
			<textarea class="form-control" name="comment" class="form-control"></textarea>
			<!-- <input type="text" name="comment" class="form-control form-control-lg <?php echo (!empty($data['comment_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['commentInput']; ?>"> -->
			<!-- <span class="invalid-feedback"><?php echo $data['comment_err'];?></span> -->
		</div>
		<input type="submit" name="submit" value="Submit" class="btn btn-primary">
	</form>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>