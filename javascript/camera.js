let streaming = false,
    video = document.getElementById('video'),
    canvas = document.getElementById('canvas'),
	capture = document.getElementById('capture'),
	captureBtn = document.getElementById('capture-btn'),
	upload = document.getElementById('uploadFile'),
	uploadBtn = document.getElementById('upload-btn'),
	input = document.getElementById('inputFile'),
	picture = document.getElementById('picture'),
	booth = document.getElementsByClassName('camera-booth'),
	miniature = document.getElementById('snapshots'),
	sidebar = document.getElementById('sidebar'),

    width = 640,
    height = 0,

	cactus = document.getElementById('cactus'),
	cat_1 = document.getElementById('cat_1'),

	ctx = canvas.getContext('2d');

	captureBtn.disabled = true;
	uploadBtn.disabled = true;
	
 	// navigator.getUserMedia = (navigator.mediaDevices.getUserMedia ||
    //                         navigator.webkitGetUserMedia ||
    //                         navigator.mozGetUserMedia ||
    //                         navigator.mediaDevices.getUserMedia ||
    //                         navigator.msGetUserMedia);

navigator.mediaDevices.getUserMedia(
	{
    	video: true,
    	audio: false
    }).then(
    function (stream) {
        // if (navigator.mozGetUserMedia) {
        //     video.mozSrcObject = stream;
        // }
        // else {
        //     var vendorURL = (window.URL || window.webkitURL || navigator.mediaDevices.getUserMedia);
        //     video.srcObject = stream;
		// }
		video.srcObject = stream;
        video.play();
    }).catch(
    function (error) {
        console.log("An error occured : " + error);
    }
);

video.addEventListener('canplay', function (event) {
    if (!streaming) {
		if (height = video.videoHeight / (video.videoWidth / width) == 0) {
			height = 480;
		}
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);
        streaming = true;
    }
}, false);

function ifChecked(check) {
	/*if (streaming) {
		if (check.id == 'cactus.png' || check.id == 'cat_1.png') {
			
		}
		/*if (check.id == 'cactus.png') {
			cactus.style.display = "block";
			cat_1.style.display = "none";
			
		}
		else if (check.id == 'cat_1.png') {
			cactus.style.display = "none";
			cat_1.style.display = "block";
		}
	}*/
	input.style.display = "block";
	captureBtn.disabled = false;
	uploadBtn.disabled = false;
};

function takePicture() {
	let snapshot = new Image();
	height = 480;
	canvas.width = width;
	canvas.height = height;

	snapshot.src = document.querySelector('input[name="img"]:checked').value;
	let separator = snapshot.src.split('/');
	let filter = '/filters/' + separator[separator.length - 1];
	
	ctx.drawImage(video, 0, 0, width, height, 0, 0, width, height);
	let data64 = canvas.toDataURL('image/png');
	snapshot.setAttribute('src', filter);
	if (filter == '/filters/cat_1.png') {
		ctx.drawImage(snapshot, width - 200, height - 108, 200, 108);
	}
	else if (filter == '/filters/cactus.png') {
		ctx.drawImage(snapshot, width - 170, height - 170, 170, 170);
	}
	let preview = canvas.toDataURL('image/png');
	picture.setAttribute('src', preview);

	ajaxToBack(filter, data64, preview);
};

function sendSnapshot() {
	let snap = new Image();
	let snapshot = new Image();
	height = 480;
	canvas.width = width;
	canvas.height = height;

	snapshot.addEventListener("load", function() {
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		ctx.drawImage(snapshot, 0, 0, snapshot.width, snapshot.height, 0, 0, width, height);
		let data64 = canvas.toDataURL(snapshot.type);
		window.URL.revokeObjectURL(snapshot.src);

		snap.src = document.querySelector('input[name="img"]:checked').value;
		let separator = snap.src.split('/');
		let filter = '/filters/' + separator[separator.length - 1];

		if (filter == '/filters/cactus.png') {
			ctx.drawImage(snap, width - 170, height - 170, 170, 170);
		}
		else if (filter == '/filters/cat_1.png') {
			ctx.drawImage(snap, width - 200, height - 108, 200, 108);
		}
		let preview = canvas.toDataURL('image/png');
		picture.setAttribute('src', preview);

		upload.onclick = function() {
			ajaxToBack(filter, data64, preview);
		}
	}, false);
	snapshot.src = window.URL.createObjectURL(input.files[0]);
}

function ajaxToBack(filter, data, preview) {
	let xhr = new XMLHttpRequest();
	let container = document.createElement("div");
	container.style.width = "33%";
	let img = document.createElement("img");
	let lineBreak = document.createElement("br");
	height = 480;

	sidebar.style.display = "inline-block";
	img.setAttribute('src', preview);
	img.height = height / 2.5;
	img.width = width / 2.5;
	miniature.appendChild(container);
	container.appendChild(img);
	container.appendChild(lineBreak);

	let keepButton = document.createElement("button");
	keepButton.type = "submit";
	keepButton.value = "save";
	keepButton.innerHTML = "Save";
	keepButton.onclick = function(event) {
		xhr.open("POST", "actions/montage.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("img=" + filter + "&file=" + data);
		container.removeChild(img);
		container.removeChild(this);
		container.removeChild(dropButton);
		container.removeChild(lineBreak);
		miniature.removeChild(container);
	}
	container.appendChild(keepButton);

	let dropButton = document.createElement("button");
	dropButton.type = "submit";
	dropButton.value = "discard";
	dropButton.innerHTML = "Discard";
	dropButton.onclick = function(event) {
		container.removeChild(img);
		container.removeChild(keepButton);
		container.removeChild(this);
		container.removeChild(lineBreak);
		miniature.removeChild(container);
	}
	container.appendChild(dropButton);	
};

capture.addEventListener('click', function (event) {
	height = 480;
	if (width && height) {
		takePicture();
	}
    event.preventDefault();
}, false);

input.addEventListener('change', function (event) {
	if (input.files[0] != null) {
		if (input.files[0].size > 1048576) {
			alert("File is too big. Files should not weigh more than 1MB.");
		}
		else
			sendSnapshot();
	}
	event.preventDefault();
}, false);