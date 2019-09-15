window.onload = function() {
	// GET ALL THE ELEMENST
	var result = document.getElementById("result");
	var photo = document.getElementById("photo");
	var camera = document.getElementById("camera");

	var stickerList = document.getElementsByClassName("sticker");

	var uploadForm = document.getElementById("uploadForm");
	var imageInput = document.getElementById("imageInput");
	var stickerInput = document.getElementById("stickerInput");

	function selectSticker(event) {
		if (document.getElementsByClassName(event.target.getAttribute('data-name')).length > 0) {
			removeSticker(event);
		} else {
			addSticker(event);
		}
	}

	// CREATE THE STICKER ELEMENT ON THE CAMERA AND RESULT
	function addSticker(event) {
		// Put new sticker on result
		var newSticker = document.createElement("img");
		newSticker.src = event.target.getAttribute('data-image');
		newSticker.classList.add("overlay");
		newSticker.classList.add("sticker-selected");
		newSticker.classList.add(event.target.getAttribute('data-name'));
		result.appendChild(newSticker);
		currentResultSticker = newSticker;

		// Put new sticker on camera
		var newSticker = document.createElement("img");
		newSticker.src = event.target.getAttribute('data-image');
		newSticker.classList.add("overlay");
		newSticker.classList.add(event.target.getAttribute('data-name'));
		camera.appendChild(newSticker);
		currentCameraSticker = newSticker;

		document.getElementById('startbutton').removeAttribute('disabled');
	}

	function removeSticker(event) {
		for (var i = 0; i < 2; i++) {
			var sticker = document.getElementsByClassName(event.target.getAttribute('data-name'))[0];
			sticker.parentNode.removeChild(sticker);
		}
	}

	// ADD LISTENER FOR CLICK WITH THE CALLBACK addSticker TO ALL THE STICKERS
	for (var i = 0; i < stickerList.length; i++) {
		stickerList[i].addEventListener('click', selectSticker, false);
	}

	// LISTEN TO SUBMIT ON FORM
	uploadForm.addEventListener('submit', function(event) {
		// Prevent sending the form
		event.preventDefault();

		// Take value from photo.src and put it in the image input in the form
		imageInput.value = photo.src;

		stickers = document.getElementsByClassName('sticker-selected');

		var stickerList = [];
		for (var i = 0; i < stickers.length; i++) {
			stickerList.push(stickers[i].src);
		}
		stickerInput.value = JSON.stringify(stickerList);

		if (window.getComputedStyle(result).display === "none") {
			return;
		}

		uploadForm.submit();
	});
};