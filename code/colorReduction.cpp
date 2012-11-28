#include<iostream>
#include<cv.h>
#include<highgui.h>
#include<algorithm>
#include<vector>
using namespace std;

//Function that helps us to access pixel data
uchar& pixel (IplImage* canvas, int row, int col, int channel){
	return ((uchar*)(canvas->imageData + canvas->widthStep*row))
			[col*canvas->nChannels+channel] ;
		}
int k=1000;

class Pixel{
	public:
		int count, r,g,b,last;
		bool selected;
		long dis;
		Pixel(){
			count=0;
			r=0;
			g=0;
			b=0;
			selected=false;
			dis=0;
			last=-1;
		}
		Pixel(int c,int red,int green, int blue){
			count =c;
			r=red;
			g=green;
			b=blue;
			selected=false;
			dis=0;
			last=-1;
		}

};
bool operator> (Pixel a, Pixel b){
	return (a.count)>(b.count);
}
bool operator< (Pixel a, Pixel b){
	return (a.count)<(b.count);
}

class Color{
	public:
	int r,g,b;
	Color(){
		r=0;
		g=0;
		b=0;
	}
	Color(int red,int green, int blue){
		r=red;
		g=green;
		b=blue;
	}
};// selected;
Color* selected;
Pixel* array= new Pixel[256*256*256];
void copyColor(int l,int i){//l is index in Color, i is index in Pixel
	//////cout<<"Copying"<<i<<"\n";
	selected[l].r=array[i].r;
	selected[l].g=array[i].g;
	selected[l].b=array[i].b;
	////cout<<"setting pixel colr\n";
	array[i].selected=true;
}
int distance1(int selColor, int fromColor){//first is index in Pixel array, 2nd is index in Color array
	int d= (array[selColor].r-selected[fromColor].r)*(array[selColor].r-selected[fromColor].r)
			+ (array[selColor].g-selected[fromColor].g)*(array[selColor].g-selected[fromColor].g)
			+ (array[selColor].b-selected[fromColor].b)*(array[selColor].b-selected[fromColor].b);
	return d;
}
long cumulativeDist(int selColor,int i){//selColor is index in Pixel array of whose dist is needed, i is index in Color array that has been assigned succesfully
	long d=0;
	int j;
	for(j=0;j<i;j++){
			d=d+distance1(selColor,j);
	}
	return d;
}

//optimise this
//runs over complete Pixel array and finds farthest color to selected colors
int farthest(int i){//i is largest index in Color array that has been assigned succesfully
	int index=0;
	long dis=0;
	long dis1=dis;
	for(int j=0;j<256*256*256;j++){
		if(array[j].count==0){
			////cout<<j<<endl;
			break;
		}
		if(!array[j].selected){
			//dis1=cumulativeDist(j,i);
			dis1 = array[j].dis;
			for(int p=array[j].last+1;p<=i;p++){
				dis1+=distance1(j,p);
			}
			array[j].dis = dis1;
			array[j].last = i;	
			if(dis<dis1){
				dis = dis1;
				index=j;
			}
		}
	}
	////cout<<"TotColors "<<j<<endl;
	return index;
}
long distance2(int r, int g,int b, int i){
	long d=0;
	d = (r-selected[i].r)*(r-selected[i].r)
			+ (g-selected[i].g)*(g-selected[i].g)
			+ (b-selected[i].b)*(b-selected[i].b);
	return d;
}
void reduceColor(char input_image[], char output_image[], int _k){
    k = _k;
    selected = new Color[k+1];
	//cout<<"In reduce color\n";
	IplImage* img = cvLoadImage(input_image,CV_LOAD_IMAGE_COLOR);
	IplImage* out = cvCreateImage(cvGetSize(img), img->depth, 3);
	////cout<<"Image imported\n";
	int width = img->width;
	int height = img->height;
	//cvNamedWindow("color");
	//cvShowImage("color",img);
	//cvWaitKey(0);
	int *distances= new int[256*256*256];
	//char distances[5];
	
	//cout<<"array created\n"<<array[1].r<<endl;
	for(int i=0;i<height;i++){
		for(int j=0;j<width;j++){
			int r=(int)(pixel (img, i, j, 2));
			int b=(int)(pixel (img, i, j, 0));
			int g=(int)(pixel (img, i, j, 1));
			//////cout<<r<<endl<<g<<endl<<b<<endl;
			int x = (r<<16)+(g<<8)+b;
			//////cout<<x<<endl;
			array[x].count+=1;
			array[x].r=r;
			array[x].b=b;
			array[x].g=g;
			distances[x]=-1;
		}
	}
	sort(array,array+(256*256*256),  greater<Pixel>());
	int j;
	for(j=0;j<256*256*256;j++){
		if(array[j].count==0){
			////cout<<j<<endl;
			break;
		}
	}
	//int k=100;//no. of colors to be made available
	
	
	//cout<<"Selected color array created\n"<<selected[0].r<<endl;
	
	copyColor(0,0);
	//////cout<<"done: 0\n";
	copyColor(1,farthest(0));
	//////cout<<"done: 1\n";
	for(int i=1;i<9 && i<k;i++){
		copyColor(i+1,farthest(i));
		//////cout<<"done: "<<i+1<<"\n";
	}
	int l=1;
	bool s=true;
	//int popindex=1;
	while(l<=k-10){
		if(s){
			//////cout<<"Pop\n";
			copyColor(l+8,l++);
		}else{
			//////cout<<"div\n";
			copyColor(l+8,farthest(8+l));
			l++;
		}
		//////cout<<"done: "<<l+8<<"\n";
		//s=!s;
	}
	//cout<<"Mapping colors "<<width<<","<<height<<"\n";
	for(int i=0;i<height;i++){
		for(int j=0;j<width;j++){
			int r1 = (int)(pixel(img,i,j,2));
			int g1 = (int)(pixel(img,i,j,1));
			int b1 = (int)(pixel(img,i,j,0));
			int r2=0,b2=0,g2=0,index=0;
			int x = (r1<<16)+(g1<<8)+b1;
			if(distances[x]==-1){
				long mindis=999999999;
				for(int p=0;p<k;p++){
					long l = distance2(r1,g1,b1,p);
					if(l<mindis){
						mindis=l;
						index=p;
					}
				}
				distances[x]=index;
			}else{
				index = distances[x];
			}
			r2=selected[index].r;
			g2=selected[index].g;
			b2=selected[index].b;
			uchar* out1;
			out1=&(pixel(out,i,j,0));*out1 = b2>255?255:b2;
			out1=&(pixel(out,i,j,1));*out1 = g2>255?255:g2;
			out1=&(pixel(out,i,j,2));*out1 = r2>255?255:r2;
			
			//////cout<<"write "<<i<<","<<j<<endl;
		}
	}
	//cvNamedWindow("reduce");
	//cvShowImage("reduce",out);
	//cvWaitKey(0);
	////cout<<"saving\n";
	cvSaveImage(output_image,out);
	//////cout<<"releasing\n";
	cvReleaseImage(&img);
	cvReleaseImage(&out);
	//cvDestroyWindow("color");
	//cvDestroyWindow("reduce");
	delete [] selected;
}
