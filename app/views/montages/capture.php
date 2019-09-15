<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- <?php var_dump($data); ?> -->

<div class="container-fluid">
	<?php flash_message() ?>
	<div class="row">
		<div class="col-10 border border-info">
			<div class="row">
				<div class="col-2 border border-info border-top-0 border-bottom-0 list p-0 text-center">
					<h5 class="text-center">
						Stickers
					</h5>
					<img src="/img/cat_preview.png" data-image="/img/cat.png" data-name="sticker-cat" class="img-fluid sticker">
					<img src="/img/bender_preview.png" data-image="/img/bender.png" data-name="sticker-bender" class="img-fluid sticker">
					<img src="/img/hat_preview.png" data-image="/img/hat.png" data-name="sticker-hat" class="img-fluid sticker">
					<img src="/img/heart_preview.png" data-image="/img/heart.png" data-name="sticker-heart" class="img-fluid sticker">
					<img src="/img/watermelon_preview.png" data-image="/img/watermelon.png" data-name="sticker-watermelon" class="img-fluid sticker">
					<img src="/img/pizza_preview.png" data-image="/img/pizza.png" data-name="sticker-pizza" class="img-fluid sticker">
					<img src="/img/peace_preview.png" data-image="/img/peace.png" data-name="sticker-peace" class="img-fluid sticker">
					<img src="/img/dog_preview.png" data-image="/img/dog.png" data-name="sticker-dog" class="img-fluid sticker">
					<img src="/img/dragon_preview.png" data-image="/img/dragon.png" data-name="sticker-dragon" class="img-fluid sticker">
					<img src="/img/drink_preview.png" data-image="/img/drink.png" data-name="sticker-drink" class="img-fluid sticker">
				</div>
				<div class="col-10 border border-info border-bottom-0 border-top-0 border-right-0">
					<h5 class="text-center">
						Camera
					</h5>

					<!-- Camera -->
					<div id="camera" class="embed-responsive embed-responsive-4by3">
						<video id="video" class="embed-responsive-item">Video stream not available.</video>
					</div>

					<button id="startbutton" disabled="disabled">Take photo</button>

					<form action="/montages/upload" method="post" id="uploadForm" hidden>
						<input type="hidden" name="image" id="imageInput" />
						<input type="hidden" name="sticker" id="stickerInput" />
						<input type="submit" value="Upload Image" class="btn btn-primary" />
					</form>

					<div id="result" class="col p-0" hidden>
						<img id="photo" class="image img-fluid w-100" />
					</div>


					<canvas id="canvas" class="d-none"></canvas>
					<br />
					<!-- File upload -->
					<div>
						<p>No camera? Select image to upload: </p>
						<input type="file" name="fileToUpload" id="imgInp" accept="image/x-png,image/jpeg">
					</div>

				</div>
			</div>
		</div>
		<div class="col-2 border border-info p-0">
			<h5 class="text-center">
				Personal Gallery
			</h5>
	
			<?php foreach($data['montages'] as $montage) : ?>
			<a href="/montages/<?= $montage->montageId ?>"><img src="/photos/<?= $montage->montageFilename ?>" alt="..." class="img-thumbnail"></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<script src="/js/capture.js"></script>
<script src="/js/stickers.js"></script>
<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				result = document.getElementById('result');
				result.removeAttribute('hidden');
				form = document.getElementById('uploadForm');
				form.removeAttribute('hidden');
				document.getElementById('photo').setAttribute('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}

	document.getElementById('imgInp').addEventListener('change', function() {
		readURL(this);
	});
</script>
<!-- <script src="/js/uploadPreview.js"></script> -->
<br />
<?php require APPROOT . '/views/inc/footer.php'; ?>
