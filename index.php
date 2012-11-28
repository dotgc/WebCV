<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WebCV Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="a web application to simulate & realize OpenCV action online">
    <meta name="author" content="Gaurav Chauhan, Gagrani, Saif Hasan, Alankar, Ravi, Yudhister">
 <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/css/docs.css" rel="stylesheet">
    <link href="bootstrap/css/operation_box.css" rel="stylesheet">
    <script src="bootstrap/js/jquery.min.js"></script>    
    <link href="bootstrap/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="bootstrap/js/jsCarousel/jsCarousel-2.0.0.css" rel="stylesheet" type="text/css" />
    <script src="bootstrap/js/jsCarousel/jsCarousel.js"></script>
   
    <style>
        .span5 img{
            border:3px solid grey;
            max-height:380px;
            max-width: 480px;
        }
        .initial{
            background-color:grey;
            
            margin:0 auto;
            padding:0 auto;
            -moz-border-radius-: 10px;
            -webkit-border-radius: 10px;
            -khtml-border-radius:10px; 
            border-radius:10px;
            -moz-box-shadow: 0 0 5px 5px white;
            -webkit-box-shadow: 0 0 5px 5px white;
            box-shadow: 0 0 5px 5px white;
            height: 380px;
            text-align: center;
        }
        .initial h1{
            line-height:400px;
        }
        .span2 select{
            width:160px;
        }
        .span2 button{
            width:160px;
        }
        .jscarousal-horizontal{
            width: 100%;
            position: fixed;
            bottom:0;
        }
        .jscarousal-contents-horizontal{
            width:95%;
        }
        .jumbotron{
            padding:0;
        }
        body {
            padding-bottom: 100px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
        <!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="./index.php">WebCV</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
                <li class=""><a href="./index.php">Home</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" id="drop4" role="button" data-toggle="dropdown" href="#">Documentation <b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop4">
                        <li class="dropdown-submenu">
                            <a tabindex="-1" href="#">Image Filters</a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:$('#gauss_filter_doc').modal()">Guassian Filter</a></li>
                                <li><a href="javascript:$('#box_filter_doc').modal()">Box Filter</a></li>
                                <li><a href="javascript:$('#median_filter_doc').modal()">Median Filter</a></li>
                                <li><a href="javascript:$('#bilateral_filter_doc').modal()">Bilateral Filter</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:$('#imgsharp_filter_doc').modal()">Image Sharpening</a></li>
                        <li><a href="javascript:$('#colred_doc').modal()">Color Reduction</a></li>
                        <li><a href="javascript:$('#hist_plot_doc').modal()">Plot Histogram</a></li>
                        <li><a href="javascript:$('#hist_eq_doc').modal()">Equalize Histogram</a></li>
                        <li><a href="javascript:$('#thresh_doc').modal()">Image Thresholding</a></li>
                        <li><a href="javascript:$('#facedetect_doc').modal()">Face Detection</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" id="drop3" role="button" data-toggle="dropdown" href="#">Upload Image <b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                        <li><a href="javascript:$('#webUpload').modal()">Upload from Web Link </a></li>
                        <li><a href="javascript:$('#localUpload').modal()">Upload from your Hard Disk</a></li>
                        <li class="divider"></li>
                        <li><a href="javascript:$('#camUpload').modal(); cameraStream();">Upload via Webcam</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav pull-right">
              <li class="">
                <a href="#">About Us</a>
              </li>
              <li class="">
                <a href="#">Contact</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    	
<!-- Subhead -->
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h2>WebCV, IIT Bombay</h2>
    <h4 class="lead">A web application to simulate & realize OpenCV actions online.</h4>
  </div>
</header>
<br/><br/>


    <div class="container">
        <div class="row" style="min-height:600px;">
            <div class="span5" id="input_image">
                <div class="initial"><h1>Input Image</h1></div>
            </div>
            <div class="span2" style="overflow:hidden;">
				<?php include("bar.php"); ?>
            </div>
            <div class="span5" id="output_image">
                 <div class="initial"><h1>Output Image</h1></div>
            </div>
        </div>
        
        <div class="row">
            <div class="span4">
            </div>
            <div class="span4">
            </div>
            <div class="span4">
            </div>
        </div>
    </div>
    <div id="refreshCarousal">

    <script>
		
		function trim1 (str) {
			str = str.replace(/^\s+/, '');
			for (var i = str.length - 1; i >= 0; i--) {
				if (/\S/.test(str.charAt(i))) {
					str = str.substring(0, i + 1);
					break;
				}
			}
			return str;
		}
		var processedImages = [];
        function changeButtonText(){
             
        }
        function Carousal(){
            $('#jsCarousal').jsCarousel({
                onthumbnailclick: 
                    function(src){
                       // $.post("connector.php", {imageUrl:src}, function(result){
                          displayResult ="<img src='" + trim1(src) +  "'/>"; 
                          $("#input_image").html(displayResult);
                       // });
                    }, 
                    autoscroll: false, 
                    masked: false, 
                    itemstodisplay: 13, 
                    orientation: 'h' 
                });
        }
        function PrintCarousal(){
            var temp = "<div id='jsCarousal'>";
            for (imageName in processedImages){
                temp += '<div><img alt="" src="' + processedImages[imageName] + '" /><br /><span class="thumbnail-text">' + "test" + imageName +'</span></div>';
            }
            temp += "</div>";
            document.getElementById("refreshCarousal").innerHTML = temp;
            Carousal();
        }
        
        function modifyQueue(imgUrl){
            if(processedImages.length > 17){
                processedImages.pop();
            }
            processedImages.unshift(imgUrl);
            document.getElementById("refreshCarousal").innerHTML = "";
            PrintCarousal();
        }
    </script>
    </div>
    <div id="webUpload" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Upload Image from Web URL</h3>
			</div>
			<div class="modal-body">
                <div id="showImage"></div>
				<input id="web_input_url" name="web_input_url" type="text" placeholder="Type Image URL here" type="url"> </input>
			</div>
			<div class="modal-footer">
				<button id="webupload" href="#" class="btn btn-info">Upload</a>
			</div>
		</div>

		<div id="localUpload" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close btn" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Upload Image from Your Local Hard Disk</h3>
			</div>
			<div class="modal-body">
                <ul id="image-list"></ul>
				<input id="local_input_url" type="file" name="localimage" placeholder="Select file from your computer" type="url"> </input>
				<div style="height:40px;"></div>
				<div class="progress progress-striped active">
					<div class="bar" style="width: 0%;"></div>
				</div>
			</div>
			<div class="modal-footer">
				<a id="localupload" href="javascript:upload_local_image()" class="btn btn-info">Upload</a>
			</div>
		</div>

		<div id="camUpload" class="modal hide fade" style="width:900px !important; left:550px;">
			<div class="modal-header">
				<button type="button" id="stop-button" class="close btn" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Upload Image from Camera</h3>
			</div>
			<div class="modal-body">
				<video autoplay id="vid"  style="display:inline;"></video>
                <canvas id="canvas" width="640" height="480" style="border:1px solid #d3d3d3;"></canvas><br>
                <!--<button onclick="snapshot()">Take Picture</button>-->
			</div>
			<div class="modal-footer">
                <button onclick="snapshot()" class="btn btn-success">Take Picture</button>
				<button onclick="saveImageData()" id="camupload" href="#" class="btn btn-info">Upload</a>
			</div>
		</div>

        <?php include("documentation.php"); ?>
</body>




<!-- Le scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.0.31/webfont.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
    <script src="bootstrap/js/google-code-prettify/prettify.js"></script>
    <script src="bootstrap/js/jsCarousel/jsCarousel.js"></script>
    <script src="bootstrap/js/bootstrap-transition.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>
    <script src="bootstrap/js/bootstrap-affix.js"></script>
    <script type="text/javascript">

    $(document).ready(function() {
       $('#operations').change(function() {
            var txt = $(this).val();
            var funct = "f(inputImg, " + txt +")"; 
            $('#cvAction').html(funct);
           // $('#refreshCarousal').dialog('open');
            return false;
        });
        $("#web_input_url").change(function(){
            txt = $(this).val();
            imgsrc = "<img src='" + txt + "'/>";
            //alert(imgsrc);
            $("#showImage").html(imgsrc);
        });
       /* $("#camupload").click(function(){
			//txt = $("#cam_input_url").val();
            $.post("file_upload.php", {imageUrl:txt}, function(result){
                displayResult ="<img src='" + result +  "'/>"; 
                $("#input_image").html(displayResult);
            });
        });*/
        /*$("#cvAction").click(function(){
            var me = $(this);
           // alert(me);
            modifyQueue(me);
        }); */
    });
    </script>
     <script src="bootstrap/js/file_upload.js"></script>
     <script src="bootstrap/js/operation_box.js"></script>
</html>
