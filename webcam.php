<video autoplay id="vid" style="display:inline;"></video>
<canvas id="canvas" width="640" height="480" style="border:1px solid #d3d3d3;"></canvas><br>
<button onclick="snapshot()">Take Picture</button>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

    var video = document.querySelector("#vid");
    var canvas = document.querySelector('#canvas');
    var context = canvas.getContext('2d');
    var localMediaStream = null;

    var onCameraFail = function (e) {
        console.log('Camera did not work.', e);
    };
    function saveImageData(src){
        $.post("imageUpload.php", {file:src}, function(result){
            alert("success");
        });
    }
    function snapshot() {
        if (localMediaStream) {
            src = context.drawImage(video, 0, 0);
            temp = canvas.toDataURL('image/jpeg');
            saveImageData(temp);
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
    cameraStream();
</script>