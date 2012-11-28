#include <iostream>
#include <cstring>
#include <cstdlib>
#include <cv.h>
#include <highgui.h>
#include "colorReduction.cpp"
using namespace std;

void crop_image(char inpImageName[], char outImageName[], int x, int y, int width, int height);
void reduceColor(char input_image[], char output_image[], int _k);

/**
* This function is used for filtering of following types :-
* 1. CV_BLUR : Box Filtering with normalisation
* 2. CV_GAUSSIAN : Linear convolution with a gaussian kernel
* 3. CV_MEDIAN : median filter
* 4. CV_BILATERAL : bilateral filter
*
* @param inpImageName input File Name
* @param outImageName output File Name
* @param filterType type of filter same as mentioned in description
* @param W width of kernel
* @param H height of kernel, if 0 then a square filter is used (WxW), ignored by CV_MEDIAN, CV_BILATERLAL
* @param sigma standard deviation used for gaussian, if zero then its calculated from W,H
* @param spatialSigma Spatial deviatation in case of Bilateral Filter and sigma serves as color sigma
*/
void lowpassFilter(char inpImageName[], char outImageName[], int filterType, int W, int H = 0, float sigma = 0, float spatialSigma = 0) {
  IplImage* inp = 0;
  inp = cvLoadImage(inpImageName, CV_LOAD_IMAGE_UNCHANGED);
  if (!inp) {
    std::cerr << "Unable to load image\n";
    return;
  }
  IplImage* out = cvCreateImage(cvSize(inp->width, inp->height),
    inp->depth, inp->nChannels);
  cvSmooth(inp, out, filterType, W, H, sigma, spatialSigma);
  cvSaveImage(outImageName, out);
}

/**
* This is simple function to sharpen a image by adding details to a function
*
* @param inpImageName name of input file name
* @param outImageName name of output file name with which to save processed image
* @param a coefficient of sharpening, (a-1) times original image is added to details, if less than
* 1 then original it added to detail
*
*/
void sharpenImage(char inpImageName[], char outImageName[], float a) {
  IplImage* inp = 0;
  inp = cvLoadImage(inpImageName, CV_LOAD_IMAGE_UNCHANGED);
  if (!inp) {
    std::cerr << "Unable to load image\n";
    return;
  }
  IplImage* out = cvCreateImage(cvSize(inp->width, inp->height),
    inp->depth, inp-> nChannels);
  IplImage* detail = cvCloneImage(out);
  cvSmooth(inp, out, CV_GAUSSIAN, 19, 19, 3);

// A - smooth(A)
  cvSub(inp, out, detail);
  if ( a > 1 ) a = a - 1;
  else a = 1;
  cvScaleAdd(inp, cvScalar(a), detail, out);
  cvSaveImage(outImageName, out);
}




/*
* Functions for Plotting Histogram of an Image
*/
IplImage* DrawHistogram(CvHistogram *hist, int channels,float scaleX=1, float scaleY=1){
  float histMax = 0;
  cvGetMinMaxHistValue(hist, 0, &histMax, 0, 0);

  IplImage* imgHist = cvCreateImage(cvSize(256*scaleX, 64*scaleY), 8 ,3);
  cvZero(imgHist);

  for(int i=0;i<255;i++) {
    float histValue = cvQueryHistValue_1D(hist, i);
    float nextValue = cvQueryHistValue_1D(hist, i+1);
    CvPoint pt1 = cvPoint(i*scaleX, 64*scaleY);
    CvPoint pt2 = cvPoint(i*scaleX+scaleX, 64*scaleY);
    CvPoint pt3 = cvPoint(i*scaleX+scaleX, (64-nextValue*64/histMax)*scaleY);
    CvPoint pt4 = cvPoint(i*scaleX, (64-histValue*64/histMax)*scaleY);
    int numPts = 5;
    CvPoint pts[] = {pt1, pt2, pt3, pt4, pt1};
    cvFillConvexPoly(imgHist, pts, numPts, channels==0?
      cvScalar(255,255,255):
      (channels==1?
        cvScalar(255,0,0): 
        (channels==2? cvScalar(0,255,0): (channels==3? cvScalar(0,0,255): cvScalar(255,255,255)))
      )
    );
  }

  return imgHist;
}

void histogramPrint(char input_image[], char output_image[]){
  IplImage *img = 0,*img2 = 0;
  img = cvLoadImage(input_image,CV_LOAD_IMAGE_COLOR);
  img2 = cvLoadImage(input_image,CV_LOAD_IMAGE_GRAYSCALE);

  int numBins = 256;
  float range[] = {0, 255};
  float *ranges[] = { range };

  CvHistogram *hist = cvCreateHist(1, &numBins, CV_HIST_ARRAY, ranges, 1);
  cvClearHist(hist);
  IplImage* imgRed = cvCreateImage(cvGetSize(img), img->depth, 1);
  IplImage* imgGreen = cvCreateImage(cvGetSize(img), img->depth, 1);
  IplImage* imgBlue = cvCreateImage(cvGetSize(img), img->depth, 1);
  //IplImage* imgGrey = cvCreateImage(cvGetSize(img), 8, 1);

  cvSplit(img, imgBlue, imgGreen, imgRed, NULL);
  ////cout<<"Split Image\n";
  cvCalcHist(&imgRed, hist, 0, 0);
  IplImage* imgHistRed = DrawHistogram(hist,3);
  cvClearHist(hist);

  cvCalcHist(&imgGreen, hist, 0, 0);
  IplImage* imgHistGreen = DrawHistogram(hist,2);
  cvClearHist(hist);

  cvCalcHist(&imgBlue, hist, 0, 0);
  IplImage* imgHistBlue = DrawHistogram(hist,1);
  cvClearHist(hist);

  cvCalcHist(&img2, hist, 0, 0);
  IplImage* imgHistGrey = DrawHistogram(hist,0);
  cvClearHist(hist);
  //cout<<"Hist calculated\n";
  IplImage *completeHistSet = cvCreateImage( cvSize(256,256), 8, 3 );

  cvSetImageROI(completeHistSet, cvRect( 0, 0, 256,64 ) ); 
  cvCopy(imgHistRed, completeHistSet);
  cvResetImageROI(completeHistSet); 

  cvSetImageROI(completeHistSet, cvRect( 0, 64, 256,64 ) ); 
  cvCopy(imgHistGreen, completeHistSet);
  cvResetImageROI(completeHistSet);

  cvSetImageROI(completeHistSet, cvRect( 0, 128, 256,64 ) ); 
  cvCopy(imgHistBlue, completeHistSet);
  cvResetImageROI(completeHistSet);

  cvSetImageROI(completeHistSet, cvRect( 0, 192, 256,64 ) ); 
  cvCopy(imgHistGrey, completeHistSet);
  cvResetImageROI(completeHistSet);
  //cout<<"pasted to image\n";
  cvSaveImage(output_image,completeHistSet);
  cvReleaseImage(&img);
  cvReleaseImage(&img2);
  cvReleaseImage(&imgRed);
  cvReleaseImage(&imgGreen);
  cvReleaseImage(&imgBlue);
  cvReleaseImage(&completeHistSet);
  cvReleaseImage(&imgHistRed);
  cvReleaseImage(&imgHistGreen);
  cvReleaseImage(&imgHistBlue);
  cvReleaseImage(&imgHistGrey);
}


/*
* Function to perform Image Thresholding
*/
void thresholdImage(char input_image[], char output_image[], double threshold, double maxValue, int thresholdType) {
  IplImage *img = 0;
  img = cvLoadImage(input_image,CV_LOAD_IMAGE_GRAYSCALE);
  cvThreshold(img,img,threshold,maxValue,thresholdType);
  cvSaveImage(output_image,img);
}



/*
* Function for performing histogram Equilization
*/
void histogramEqual(char input_image[], char output_image[]){
  IplImage * input = cvLoadImage(input_image,CV_LOAD_IMAGE_GRAYSCALE);
  IplImage * out = cvCreateImage(cvGetSize(input), input->depth, 1);
  cvEqualizeHist(input,out);
  cvSaveImage(output_image,out);
  cvReleaseImage(&input);
  cvReleaseImage(&out);
}



/*
* Code for Face Detection
*
*/
IplImage* drawRectangles(IplImage * img, CvSeq * faces){
  int n = faces->total;
  for (int i=0;i<n;i++){
    CvRect *face = (CvRect*)cvGetSeqElem(faces, i);
    // draw a rectangle 
    cvRectangle(
      img,
      cvPoint(face->x, face->y),
      cvPoint(
        face->x + face->width,
        face->y + face->height
        ),
      CV_RGB(0, 255, 255),
      1, 8, 0
      );
  }

  return img;
}

CvHaarClassifierCascade* cascade_f = (CvHaarClassifierCascade*) cvLoad("haarcascade_face.xml", 0, 0, 0);
void facesDetect(char input_image[], char output_image[]){
  IplImage *img = 0;
  img = cvLoadImage(input_image,CV_LOAD_IMAGE_COLOR);
  CvMemStorage* storage = cvCreateMemStorage();
  CvSeq *faces;
  int i=1,face_count = 0;
  while(face_count==0 && i< img->height && i<img->width){
    faces = cvHaarDetectObjects(img, cascade_f, storage, 1.1, 3, 0, cvSize(i, i) );
    i++;
    face_count = faces->total;
  }

  if (face_count==0){
    //cout<<"No faces detected"<<endl;
  } else {
  //call a function with image as parameter and which returns an image with all the faces rectangled
    cvSaveImage(output_image,drawRectangles(img,faces));  
  }
  cvClearMemStorage(storage);
}



int main(int argc, char* argv[]) {
  if ( argc < 4 ) {
    std::cerr << "Usage : ./a.out <inpFile> <outFile> operation [<parameters>]\n";
    return -1;
  }

  char *inpImage, *outImage;
  inpImage = (char*) malloc(sizeof(char)*strlen(argv[1])+1);
  strcpy(inpImage, argv[1]);
  outImage = (char*) malloc(sizeof(char)*strlen(argv[2])+1);
  strcpy(outImage, argv[2]);
  int op = atoi(argv[3]);
  if ( op == 0 ) {
    if ( argc < 5 ) {
      std::cerr << "Usage : ./a.out inpImage outImage 1 Type Width [Height] [Sigma] [SpatialSigma]\n";
      return -1;
    }
    char* type = new char[strlen(argv[4])+1];
    strcpy(type, argv[4]);
    int W = 0;int H = 0; float sigma = 0; float spatialSigma = 0;
    if ( strcmp(type, "CV_GAUSSIAN")==0 ) { // gaussianBlur
      if ( argc < 7 ) {
        std::cerr << "Usage : ./a.out inpImage outImage 1 Type Width Height [Sigma]\n";
        return -1;
      } else if ( argc >= 8 ) {
        sigma = atof(argv[7]);
      }

      W = atoi(argv[5]);
      H = atoi(argv[6]);
      lowpassFilter(inpImage, outImage, CV_GAUSSIAN, W, H, sigma);
    } else if ( strcmp(type, "CV_BLUR") == 0) { // boxFilter
      if ( argc < 7 ) {
        std::cerr << "Usage : ./a.out inpImage outImage 1 Type Width Height\n";
        return -1;
      }
      W = atoi(argv[5]);
      H = atoi(argv[6]);
      lowpassFilter(inpImage, outImage, CV_BLUR, W, H);
    } else if ( strcmp(type, "CV_MEDIAN") == 0 ) { // medianBlur
      if ( argc < 6 ) {
        std::cerr << "Usage : ./a.out inpImage outImage 1 Type Width\n";
        return -1;
      }
      W = atoi(argv[5]);
      lowpassFilter(inpImage, outImage, CV_MEDIAN, W, W);
    } else if (strcmp(type, "CV_BILATERAL") == 0) {
      //bilateralFilter
      if ( argc < 9 ) {
        std::cerr << "Usage : ./a.out inpImage outImage 1 Type Width Height Sigma SpatialSigma\n";
        return -1;
      }

      W = atoi(argv[5]);
      H = atoi(argv[6]);
      sigma = atof(argv[7]);
      spatialSigma = atof(argv[8]);
      lowpassFilter(inpImage, outImage, CV_BILATERAL, W, H, sigma, spatialSigma);
    }
  } else if ( op == 1 ) {
    float a = 1.0;
    if ( argc >= 5 ) {
      a = atof(argv[4]);
    }

    sharpenImage(inpImage, outImage, a);
  } else if ( op == 2 ) {
    //Color reduction : (id: 2)
    int numColors;
    numColors = atoi(argv[4]);
    //Call THe Color Reduction Function from here . . . .TODO
    //Param: (InputImage, ouputImage, numColors)
    reduceColor(inpImage, outImage,numColors);


  } else if ( op == 3 ) {
    //Histogram : (id: 3)
    histogramPrint(inpImage, outImage);
  } else if ( op == 4 ) {
    //Thresholding : (id: 4)
    double thresholdValue, maxValue;
    char typeMap[][32] = {"CV_THRESH_BINARY",
    "CV_THRESH_BINARY_INV",
    "CV_THRESH_TRUNC",
    "CV_THRESH_TOZERO",
    "CV_THRESH_TOZERO_INV"};
    thresholdValue = (double) atof(argv[4]);
    maxValue = (double) atof(argv[5]);
    if(strcmp(typeMap[0], argv[6])) {
      thresholdImage(inpImage, outImage, thresholdValue, maxValue, CV_THRESH_BINARY);
    } else if(strcmp(typeMap[1], argv[6])) {
      thresholdImage(inpImage, outImage, thresholdValue, maxValue, CV_THRESH_BINARY_INV);
    } else if(strcmp(typeMap[2], argv[6])) {
      thresholdImage(inpImage, outImage, thresholdValue, maxValue, CV_THRESH_TRUNC);
    } else if(strcmp(typeMap[3], argv[6])) {
      thresholdImage(inpImage, outImage, thresholdValue, maxValue, CV_THRESH_TOZERO);
    } else if(strcmp(typeMap[4], argv[6])) {
      thresholdImage(inpImage, outImage, thresholdValue, maxValue, CV_THRESH_TOZERO_INV);
    } else {
      thresholdImage(inpImage, outImage, thresholdValue, maxValue, CV_THRESH_BINARY);
    }
  } else if ( op == 5 ) {
    //Histogram Equilization : (id: 5)
    histogramEqual(inpImage, outImage);
  } else if ( op == 6 ) {
    //Face Detection : (id: 6)
    facesDetect(inpImage, outImage);
  } else {
    std::cerr << " Operation " << op << " not defined till now\n";
  }

  return 0;
}
