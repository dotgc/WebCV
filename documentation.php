<div id="gauss_filter_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Gaussian Filter</h3>
	</div>
	<div class="modal-body">
		<p>
			A <b>Gaussian blur</b> (also known as Gaussian smoothing) is the result of blurring an image by a Gaussian Function. The visual effect of this blurring technique is a smooth blur resembling that of viewing the image through a translucent screen. Mathematically, applying a Gaussian blur to an image is the same as convolving the image with a Gaussian function. Since the fourier transform of a Gaussian is another Gaussian, applying a Gaussian blur has the effect of reducing the image's high frequency components. A Gaussian blur is thus a <b>low pass filter</b>.
		</p>
		<p>
			Open Cv function to perform Gaussian filter which does simple convolve using gaussian function can be called using cvSmooth. For example :- <br/>
			<code>
				cvSmooth(inpIpl, outIpl, CV_GAUSSIAN, Width, Height=0, Sigma = 0)
			</code>
			<ul>
				<li> inpIpl is IplImage* object taken as input</li>
				<li> outIpl is IplImage* object in which to store the output of filter</li>
				<li> Width has to be odd number</li>
				<li> Height if not supplied is taken same as width, otherwise it also has to be a odd number</li>
				<li> Sigma if not supplied is calculated from the Width and Height, Otherwise it serves as the standard deviation for gaussian function</li>
			</ul>
		</p>
	</div>
</div>



<div id="box_filter_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Box Filter</h3>
	</div>
	<div class="modal-body">
		<p>
			<b>Box filtering</b> is basically an average-of-surrounding-pixel kind of image filtering. It is actually a convolution filter which is a commonly used mathematical operation for image filtering. A convolution filters provide a method of multiplying two arrays to produce a third one. In box filtering, <i>image sample</i> and the <i>filter kernel</i> are multiplied to get the filtering result.
		</p>
		<p>
			Open Cv function to perform box filter which does simple average of neighbouring point can be called using cvSmooth. For example :- <br/>
			<code>
				cvSmooth(inpIpl, outIpl, CV_BLUR, Width, Height=0)
			</code>
			<ul>
				<li> inpIpl is IplImage* object taken as input</li>
				<li> outIpl is IplImage* object in which to store the output of filter</li>
				<li> Width has to be odd number</li>
				<li> Height if not supplied is taken same as width, otherwise it also has to be a odd number</li>
				<li> This blurring is scaled by Width*Height, In case one does not need scaling then use CV_BLUR_NO_SCALE in place of CV_BLUR</li>
			</ul>
		</p>
	</div>
</div>




<div id="median_filter_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Median Filter</h3>
	</div>
	<div class="modal-body">
		<p>
			<b>Median filtering</b> is a nonlinear process useful in reducing impulsive, or <b>salt-and-pepper noise</b>. It is also useful in preserving edges in an image while reducing random noise. Impulsive or salt-and pepper noise can occur due to a random bit error in a communication channel. In a median filter, a window slides along the image, and the median intensity value of the pixels within the window becomes the output intensity of the pixel being processed.
		</p>
		<p>
			Open Cv function to perform Median filter can be called using cvSmooth. For example :- <br/>
			<code>
				cvSmooth(inpIpl, outIpl, CV_MEDIAN, Width, Height=0)
			</code>
			<ul>
				<li> inpIpl is IplImage* object taken as input</li>
				<li> outIpl is IplImage* object in which to store the output of filter</li>
				<li> Width has to be odd number</li>
				<li> Height if not supplied is taken same as width. Otherwise a Width x Height filter matrix is used.</li>
			</ul>
		</p>
	</div>
</div>





<div id="bilateral_filter_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Bilateral Filter</h3>
	</div>
	<div class="modal-body">
		<p>
			A <b>bilateral filter</b> is an edge-preserving and noise reducing smoothing filter. The intensity value at each pixel in an image is replaced by a weighted average of intensity values from nearby pixels. This weight is based on a Gaussian distribution. Crucially the weights depend not only on Euclidean distance but also on the radiometric differences (differences in the range, e.g. color intensity or Z distance). This preserves sharp edges by systematically looping through each pixel and according weights to the adjacent pixels accordingly.
		</p>
		<p>
			Open Cv function to perform Bilateral filter can be called using cvSmooth. For example :- <br/>
			<code>
				cvSmooth(inpIpl, outIpl, CV_Bilateral, Width, Height=0, colorSigma=0, spatialSigma=0)
			</code>
			<ul>
				<li> inpIpl is IplImage* object taken as input</li>
				<li> outIpl is IplImage* object in which to store the output of filter</li>
				<li> Width has to be odd number. If not supplied then computed using cvRound(spatialSigma*1.5)*2+1</li>
				<li> Height is not used, filter size is Width * Width</li>
				<li> colorSigma used as deviation for color domain</li>
				<li> spatialSigma used as deviation for spatial domain</li>
			</ul>
		</p>
	</div>
</div>



<div id="imgsharp_filter_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Image Sharpening</h3>
	</div>
	<div class="modal-body">
		<p>
			<b>Image sharpening</b> can be considered as adding the details back to the original image. Details can be obtained using a highpass filter. How much fraction of original image you want to add to the details determines the overall effect of sharpening. Low values means high contrast and high values indicate a very bright image as the original image colours are amplified that many times before adding to the details
			<br/>
			<code> Output Image = a * Original Image + Details </code>
		</p>
		<p>
			Open Cv functions can be used to add the details to image. Details can be computed using a high pass filter. For example :- <br/>
			<code>
				cvScaleAdd(const CvArr* A, CvScalar a, const CvArr* B, CvArr* C)
			</code>
			<br/>which results into C = s * A + B</br>
			<ul>
				<li> A is IplImage* original image</li>
				<li> a is amplification of original image</li>
				<li> B is IplImage* image details</li>
				<li> C is IplImage* output image</li>
			</ul>
		</p>
	</div>
</div>



<div id="colred_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Color Reduction</h3>
	</div>
	<div class="modal-body">
		<p>
			<b>Color quantization</b> is a process that reduces the number of distinct colors used in an image, usually with the intention that the new image should be as visually similar as possible to the original image.Color quantization is critical for displaying images with many colors on devices that can only display a limited number of colors and enables efficient compression of certain types of images.
		</p>
		<p>
			A number of clustering algorithms exist for color reduction, simplest being the <b>popularity algorithm</b>. It chooses the the top most popular colors in the image. But it may overlook certain less popular but important colors in the image. <b>Diversity algorithm</b> chooses the farthest spaced colors in the RGB space of the image. It may magnify certain very less popular colors into the image. The <b>modified diversity algorithm</b> combines the best of both algorithms. </br>
			There is no direct OpenCV function for color reduction. 
		</p>
		<p>
			<b>K-means algorithm</b> is another well known method that works successfully for certain kind of images
		</p>
	</div>
</div>



<div id="hist_plot_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Histogram Plotting</h3>
	</div>
	<div class="modal-body">
		<p>
			An image histogram is a type of histogram that acts as a graphical representation of the tonal distribution in a digital image. It plots the number of pixels for each tonal value. 
		</p>
		<p>
			The horizontal axis of the graph represents the tonal variations (0-255), while the vertical axis represents the number of pixels in that particular tone. The left side of the horizontal axis represents the black or dark areas, the middle represents medium grey and the right hand side represents bright and pure white areas. The output image is a composition of 4 histograms of Red, Green, Blue and Intensity.The image is first split into its 4 components and then histograms are created for each of them.<br/>
		</p>
		<p>
			<code>
				void cvCalcHist(IplImage** image, CvHistogram* hist, int accumulate=0, const CvArr* mask=NULL)
			</code>
			<ul>
				<li> image – Source images (though you may pass CvMat** as well)</li>
				<li> hist – Pointer to the histogram</li>
				<li> accumulate – Accumulation flag</li>
				<li> mask – The operation mask, determines what pixels of the source images are counted</li>
			</ul>
		</p>
	</div>
</div>



<div id="hist_eq_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Histogram Equilization</h3>
	</div>
	<div class="modal-body">
		<p>
			This method usually increases the global contrast of many images, especially when the usable data of the image is represented by close contrast values. Through this adjustment, the intensities can be better distributed on the histogram. This allows for areas of lower local contrast to gain a higher contrast. Histogram equalization accomplishes this by effectively spreading out the most frequent intensity values.		</p>
		<p>
			The OpenCV function to perform histogram equalization on Gray scale images is: <br/>
			<code>
				void cvEqualizeHist(const CvArr* src, CvArr* dst)
			</code>
			<ul>
				<li> src – Source 8-bit single channel image</li>
				<li> dst – Destination image of the same size and type as src</li>
			</ul>
		</p>
	</div>
</div>



<div id="thresh_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Histogram Thresholding</h3>
	</div>
	<div class="modal-body">
		<p>
			Thresholding is the simplest method of image segmentation. From a grayscale image, thresholding can be used to create binary images.This iterative algorithm is a special one-dimensional case of the k-means clustering algorithm, which has been proven to converge at a local minimum—meaning that a different initial threshold may give a different final result.
		</p>
			<code>
				double cvThreshold(const CvArr* src, CvArr* dst, double threshold, double max_value, int threshold_type)
			</code>
			<ul>
				<li> src – input array (single-channel, 8-bit or 32-bit floating point)</li>
				<li> dst – output array of the same size and type as src</li>
				<li> thresh – treshold value</li>
				<li> maxval – maximum value to use with the THRESH_BINARY and THRESH_BINARY_INV thresholding types</li>
				<li>type – thresholding type can be one of the below
					<ol>
						<li>THRESH_BINARY</li>
						<li>THRESH_BINARY_INV</li>
						<li>THRESH_TRUNC</li>
						<li>THRESH_TOZERO</li>
						<li>THRESH_TOZERO_INV</li>
					</ol>
				</li>
			</ul>
		</p>
	</div>
</div>



<div id="facedetect_doc" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Face Detection</h3>
	</div>
	<div class="modal-body">
		<p>
			<b>Face detection</b> is a computer technology that determines the locations and sizes of human faces in arbitrary (digital) images. It detects facial features and ignores anything else, such as buildings, trees and bodies.
		</p>
		<p> Face Detection using <b>Haar classifier</b>:</br>
			The content of a given part of an image is transformed into features, after which a classifier trained on example faces decides whether that particular region of the image is a face, or not.
		</p>
		<p>
			Haar-like features encode the existence of oriented contrasts between regions in the image. A set of these features can be used to encode the contrasts exhibited by a human face and their spatial relationships. Haar-like features are so called because they are computed similar to the coefficients in Haar wavelet transforms.
		</p>
		<p>
			To search for the object in the whole image one can move the search window across the image and check every location using the classifier. The classifier is designed so that it can be easily "resized" in order to be able to find the objects of interest at different sizes, which is more efficient than resizing the image itself. So, to find an object of an unknown size in the image the scan procedure should be done several times at different scales.
		</p>
	</div>
</div>

