
var progress;

function errorHandler(evt) {
	switch(evt.target.error.code) {
		case evt.target.error.NOT_FOUND_ERR:
			alert('File Not Found!');
			break;
		case evt.target.error.NOT_READABLE_ERR:
			alert('File is not readable');
			break;
		case evt.target.error.ABORT_ERR:
			break; // noop
		default:
			alert('An error occurred reading this file.');
	};
}

function updateProgress(evt) {
	// evt is an ProgressEvent.
	if (evt.lengthComputable) {
		var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
		// Increase the progress bar length.
		if (percentLoaded < 100) {
			progress.style.width = percentLoaded + '%';
			progress.textContent = percentLoaded + '%';
		}
	}
}

$("#webupload").click(function(){
	txt = $("#web_input_url").val();
	$.post("file_upload.php", {imageUrl:txt}, function(result){
		displayResult ="<img src='" + result +  "'/>"; 
		$("#input_image").html(displayResult);
		modifyQueue(result);
	});
});

function upload_local_image() {
    //console.log("called");
	var file_path = document.getElementById("local_input_url").value;
	var file_name = document.getElementById("local_input_url").files[0];
	if(file_path == "") {
		alert("Please select file to upload");
		return;
	}

	progress = document.querySelector(".bar");
//console.log("test1");
	var reader = new FileReader();
	reader.onerror = errorHandler;
	reader.onprogress = updateProgress;
	reader.onabort = function(e) {
		alert('File read cancelled');
	};

	reader.onload = function(e) {
		// Ensure that the progress bar displays 100% at the end.
		progress.style.width = '100%';
		progress.textContent = 'Completed Uploading :)';
	}
//console.log("test2");
	// Read in the image file as a binary string.
	reader.readAsDataURL(file_name);
    console.log(file_name);
    formdata = new FormData();
    formdata.append("localimage", file_name);  
    console.log(formdata);
    if (formdata) {
        $.ajax({
            url: "file_upload.php",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (res) {
                displayResult ="<img src='" + res +  "'/>"; 
                $("#input_image").html(displayResult);
                modifyQueue(res);
            }
        });
    }
}



var video = document.querySelector("#vid");
var canvas = document.querySelector('#canvas');
var context = canvas.getContext('2d');
var localMediaStream = null;
var canvasimage;

var onCameraFail = function (e) {
    console.log('Camera did not work.', e);
};
function saveImageData(){
    console.log(canvasimage);
    if (canvasimage) {
        $.ajax({
            url: "file_upload.php",
            type: "POST",
            data: canvasimage,
            processData: false,
            contentType: false,
            success: function (res) {
                displayResult ="<img src='" + res +  "'/>"; 
                $("#input_image").html(displayResult);
                modifyQueue(res);
            }
        });
    }
}
function snapshot() {
    if (localMediaStream) {
        src = context.drawImage(video, 0, 0);
        canvasimage = canvas.toDataURL('image/png');
        //saveImageData(temp);
    }
}
function cameraStream(){
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
    window.URL = window.URL || window.webkitURL;
    navigator.getUserMedia({video:true}, function (stream) {
        video.src = window.URL.createObjectURL(stream);
        localMediaStream = stream;
    }, onCameraFail);
}
document.querySelector('#stop-button').addEventListener('click',
    function(e){
        video.pause();
        localMediaStream.stop();
    },false);
