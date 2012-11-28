
function go_back(fid) {
	$("#"+fid).hide();
	$("#fselect").fadeIn();
}

function select_function(fid) {
	$("#fselect").hide();
	$("#"+fid).fadeIn();
}

function perform_operation(params) {
	txt = $("#input_image img").attr("src");
	if(txt!=undefined) {
		$.post("connector.php?"+params, {imageUrl:txt }, function(result) {
			displayResult ="<img src='" + result +  "'/>"; 
			$("#output_image").html(displayResult);
			var me = $("#output_image img").attr("src");
			modifyQueue(me);
		});
	}
}


/***** Functions for each operation ******/
function perform_lpf() {
	//Low pass filter: (id: 0)
	var param_str = "param[]=0";
	param_str = param_str + "&param[]=" + $("#lpf_ft :selected").val();
	param_str = param_str + "&param[]=" + $("#lpf_wh :selected").val();
	param_str = param_str + "&param[]=" + $("#lpf_s").val();
	param_str = param_str + "&param[]=" + $("#lpf_ss").val();
	
	//Call the function to perform operation
	perform_operation(param_str);
}

function perform_si() {
	//Image Sharpening: (id: 1)
	var param_str = "param[]=1";
	param_str = param_str + "&param[]=" + $("#si_a").val();
	
	//Call the function to perform operation
	perform_operation(param_str);
	console.log("param_str= "+param_str);
}

function perform_cl_red() {
    //Color reduction : (id: 2)
    var param_str = "param[]=2";
	param_str = param_str + "&param[]=" + $("#num_color").val();
    
    perform_operation(param_str);
}


function perform_histplot() {
	//Histogram : (id: 3)
	var param_str = "param[]=3";

	perform_operation(param_str);
}

function perform_thresholding() {
	//Thresholding : (id: 4)
	var param_str = "param[]=4";
	param_str = param_str + "&param[]=" + $("#thresh_thresh").val();
	param_str = param_str + "&param[]=" + $("#thresh_max").val();
	param_str = param_str + "&param[]=" + $("#thresh_type :selected").val();
	
	perform_operation(param_str);
}

function perform_histeq() {
	//Histogram Equilization : (id: 5)
	var param_str = "param[]=5";
	
	perform_operation(param_str);
}

function perform_facedetect() {
	//Face Detection : (id: 6)
	var param_str = "param[]=6";
	
	perform_operation(param_str);
}
