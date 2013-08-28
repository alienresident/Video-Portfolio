# Using the script to encode videos

##ffmpeg settings 
You can use use the `encode_video.sh` shell script to encode your videos. It comes with a preset for h264: HD, SD, sm, and a webm video. The HD and SD use the 

### Install ffmpeg using Homebrew on Mac OS X

First install __Homebrew__ on you machine — detailed [Homebrew installation instructions](http://brew.sh/).

Use this command to install __ffmpeg__ using Homebrew with the full webm and ogg  video support.
 
```brew install ffmpeg --with-fdk-aac --with-libvpx --with-libvorbis --with-theora```  

### Using the Script
from the scripts folder you can encode a video using this command  
```. encode_videos.sh VIDEO_FILE.MOV```  
or a bunch of videos in the same folder using:  
```for FILE in *.m* ; do . encode_videos.sh "$FILE"; done```  