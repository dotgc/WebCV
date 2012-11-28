<div id="fselect" class="obox">
	<div class="obox_header">
		<i class="icon-home obox_back"></i>
		<h3>Select Function</h3>
	</div>
	<ul>
		<a href="javascript:select_function('lpf_box')"><li>Image Filters</li></a>
		<a href="javascript:select_function('si_box')"><li>Sharpen Image</li></a>
		<a href="javascript:select_function('cl_red')"><li>Color Reduction</li></a>
		<a href="javascript:select_function('histplot')"><li>Plot Histogram</li></a>
		<a href="javascript:select_function('histeq_box')"><li>Equalize Histogram</li></a>
		<a href="javascript:select_function('thresh_box')"><li>Image Thresholding</li></a>
		<a href="javascript:select_function('fd_box')"><li>Face Detection</li></a>
	</ul>
</div>

<div id="lpf_box" class="obox" style="display:none">
	<div class="obox_header">
		<a href="javascript:go_back('lpf_box')">
			<i class="icon-circle-arrow-left obox_back"></i>
		</a>
		<h3>Image Filters</h3>
	</div>
	<ul>
		<label>Filter Type</label>
		<select id="lpf_ft" class="obox_input">
			<option value="CV_GAUSSIAN">Gaussian Filter</option>
			<option value="CV_BLUR">Box Filter</option>
			<option value="CV_MEDIAN">Median Filter</option>
			<option value="CV_BILATERAL">Bilateral Filter</option>
		</select>
	</ul>
	<ul>
		<label>Mask Size</label>
		<select id="lpf_wh" class="obox_input">
			<option value="3&param[]=3">3 x 3</option>
			<option value="5&param[]=5">5 x 5</option>
			<option value="7&param[]=7">7 x 7</option>
			<option value="9&param[]=9">9 x 9</option>
			<option value="11&param[]=11">11 x 11</option>
			<option value="13&param[]=13">13 x 13</option>
			<option value="15&param[]=15">15 x 15</option>
			<option value="17&param[]=17">17 x 17</option>
			<option value="19&param[]=19">19 x 19</option>
		</select>
	</ul>
	<ul>
		<label>Sigma</label>
		<input id="lpf_s" class="obox_input" type="text" value="0.0"></input>
	</ul>
	<ul>
		<label>Spatial Sigma</label>
		<input id="lpf_ss" class="obox_input" type="text" value="0.0"></input>
	</ul>
	<br/>
	<a href="javascript:perform_lpf()">
		<button class="btn btn-primary">Execute</button>
	</a>
</div>

<div id="si_box" class="obox" style="display:none">
	<div class="obox_header">
		<a href="javascript:go_back('si_box')">
			<i class="icon-circle-arrow-left obox_back"></i>
		</a>
		<h3>Sharpen Image</h3>
	</div>
	<ul>
		<label>Sharpening Cofficient</label>
		<input id="si_a" class="obox_input" type="text" value="0"></input>
	</ul>
	<br/>
	<a href="javascript:perform_si()">
		<button class="btn btn-primary">Execute</button>
	</a>
</div>


<div id="cl_red" class="obox" style="display:none">
	<div class="obox_header">
		<a href="javascript:go_back('cl_red')">
			<i class="icon-circle-arrow-left obox_back"></i>
		</a>
		<h3>Color Reduction</h3>
	</div>
	<ul>
		<label># of colors</label>
		<input id="num_color" class="obox_input" type="text" value="500"></input>
	</ul>
	<br/>
	<a href="javascript:perform_cl_red()">
		<button class="btn btn-primary">Execute</button>
	</a>
</div>


<div id="histplot" class="obox" style="display:none">
	<div class="obox_header">
		<a href="javascript:go_back('histplot')">
			<i class="icon-circle-arrow-left obox_back"></i>
		</a>
		<h3>Plot Histogram</h3>
	</div>
	<br/>
	<a href="javascript:perform_histplot()">
		<button class="btn btn-primary">Execute</button>
	</a>
</div>


<div id="thresh_box" class="obox" style="display:none">
	<div class="obox_header">
		<a href="javascript:go_back('thresh_box')">
			<i class="icon-circle-arrow-left obox_back"></i>
		</a>
		<h3>Thresholding</h3>
	</div>
	<ul>
		<label>Threshold</label>
		<input id="thresh_thresh" class="obox_input" type="text" value="0.0"></input>
	</ul>
	<ul>
		<label>Max Value</label>
		<input id="thresh_max" class="obox_input" type="text" value="0.0"></input>
	</ul>
	<ul>
		<label>Threshold Type</label>
		<select id="thresh_type" class="obox_input">
			<option value="CV_THRESH_BINARY">Binary Threshold</option>
			<option value="CV_THRESH_BINARY_INV">Inverse Binary</option>
			<option value="CV_THRESH_TRUNC">Thresholding by truncating</option>
			<option value="CV_THRESH_TOZERO">Threshold To Zero</option>
			<option value="CV_THRESH_TOZERO_INV">Threshold To Zero Inverse</option>
		</select>
	</ul>
	<br/>
	<a href="javascript:perform_thresholding()">
		<button class="btn btn-primary">Execute</button>
	</a>
</div>



<div id="histeq_box" class="obox" style="display:none">
	<div class="obox_header">
		<a href="javascript:go_back('histeq_box')">
			<i class="icon-circle-arrow-left obox_back"></i>
		</a>
		<h3>Equalize Hist..</h3>
	</div>
	<br/>
	<a href="javascript:perform_histeq()">
		<button class="btn btn-primary">Execute</button>
	</a>
</div>

<div id="fd_box" class="obox" style="display:none">
	<div class="obox_header">
		<a href="javascript:go_back('fd_box')">
			<i class="icon-circle-arrow-left obox_back"></i>
		</a>
		<h3>Face Detect</h3>
	</div>
	<br/>
	<a href="javascript:perform_facedetect()">
		<button class="btn btn-primary">Execute</button>
	</a>
</div>