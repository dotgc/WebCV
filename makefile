all:output
output: code/project.cpp code/colorReduction.cpp
	g++ code/project.cpp `pkg-config --cflags --libs opencv` -o output
clean:
	rm -rf output
