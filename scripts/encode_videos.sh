#!/bin/bash

FILE=${1}  

for FILE; 
do 
  NEWFILE=${FILE%.mov};
  FOLDERLESS=${NEWFILE##*/};
  ffmpeg -y -i $FILE -c:v libx264 -preset medium -threads 4 -cpu-used 0 -quality good -b:v 2500k -profile:v high -s 1280x720 -an -pass 1 -f mp4 /dev/null -y && ffmpeg -i $FILE -c:v libx264 -preset medium -threads 4 -cpu-used 0 -quality good -b:v 2500k -profile:v high -s 1280x720 -c:a libfdk_aac -b:a 128k -pass 2 -movflags +faststart $FOLDERLESS-hd.mp4; 
  ffmpeg -y -i $FILE -c:v libx264 -preset medium -threads 4 -cpu-used 0 -quality good -b:v 1250k -profile:v high -s 768x432 -an -pass 1 -f mp4 /dev/null -y && ffmpeg -i $FILE -c:v libx264 -preset medium -threads 4 -cpu-used 0 -quality good -b:v 1250k -profile:v high -s 768x432 -c:a libfdk_aac -b:a 96k -pass 2 -movflags +faststart $FOLDERLESS-sd.mp4; 
  ffmpeg -y -i $FILE -c:v libx264 -preset medium -threads 4 -cpu-used 0 -quality good -b:v 550k -profile:v baseline -s 512x288 -an -pass 1 -f mp4 /dev/null -y && ffmpeg -i $FILE -c:v libx264 -preset medium -threads 4 -cpu-used 0 -quality good -b:v 550k -profile:v baseline -s 512x288 -c:a libfdk_aac -b:a 64k -pass 2 -movflags +faststart $FOLDERLESS-sm.mp4;
  ffmpeg -y -i $FILE -c:v libvpx -threads 4 -cpu-used 0 -quality good -qmin 0 -qmax 50 -crf 15 -b:v 2500k -s 1280x720 -an -pass 1 -f webm /dev/null -y && ffmpeg -i $FILE -c:v libvpx -threads 4 -cpu-used 0 -quality good -qmin 0 -qmax 50 -crf 15 -b:v 2500k -s 1280x720 -c:a libvorbis -b:a 128k -pass 2 $FOLDERLESS-wb.webm;
 done