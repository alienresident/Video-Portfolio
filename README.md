 
## NOTE: Documentation is still in Progress!

# Simple Video Portfolio

Simple Video Portfolio is a HTML 5 video player to showcase video based portfolios. It's set up to deliver the a great video experience no matter what browser or device you have.    

## Simple Video Portfolio [SVP] 

* It creates a HTML 5 video player that works in: Chrome, Safari, iOs (newer and older iPhones and iPads), Firefox, Opera, IE9 & IE10 and even IE8 (using a flash fallback).
* You can easily add more videos without updating html. Simply upload the videos to your site.
* It doesn't require a CMS that needs to be updated and maintained.

## How it Works
The video player script looks for a folder (i.e. videos) in a directory (or directories) and adds them to the player.

	Directory Structure
	player.php
	videos/
		01_Artwork/
		O2_Promos/
		
In this example `player.php` is looking in the `videos` folder and sees 2 subfolders: `01_Artwork` and `O2_Promos`. It will look for videos in these folders and create a player. Since there are 2 subfolders in this example it will create navigation options so you can view the contents of both folders. Navigation options can be specified here. [TK] 

### Adding videos
You can add just one version of your video or for better compatibility to add multiple versions. It's recommended to add; a h264 video (high profile) for desktops, newer phones and tablets, and for the flash fallback; a webm video for Firefox and Opera browsers; and a h264 video (baseline profile) for older phones, tablets, and iPods.

You can either add as many different videos as you like to the same folder or add them to different folders. If there are different video titles in the folder they video player will create a drop down or a playlist so you can navigate between the videos. In this example `01_Artwork` has four 'flavors' of the same video (artwork_1). In `O2_Promos` we have four 'flavors' of two different videos (Trailer_1 and Promo_1).

	videos/
		01_Artwork/
			artwork_1-hd.mp4
			artwork_1-sd.mp4
			artwork_1-sm.mp4
			artwork_1-wb.webm
		O2_Promos/
			Trailer_1-hd.mp4
			Trailer_1-sd.mp4
			Trailer_1-sm.mp4
			Trailer_1-wb.webm
			Promo_1-hd.mp4
			Promo_1-sd.mp4
			Promo_1-sm.mp4
			Promo_1-wb.webm

## Naming Conventions

### Folder Names
To get the sub folders to appear in a particular order the easiest way is to number them i.e. `01_Artwork`, `O2_Promos`, `03_Motion_Graphics`. However, we don't want to display these numbers in the interface. In the player.php configuration settings, we can tell the script to ignore the first _n_ characters (the default is 3). The folders will be then listed as `Artwork`, `Promos`, `Motion Graphics`.

### File names

### Escaping Characters

### Adding Descriptions to the Playlist


## Player Configuration Settings




    
