 
## NOTE: Documentation is still in Progress!

# Simple Video Portfolio

Simple Video Portfolio is a HTML 5 video player to showcase video based portfolios. It's set up to deliver the a great video experience no matter what browser or device you have.    

## Simple Video Portfolio [SVP] player

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
The sub folders by default will be in alphabetical order. Numbering the sub folders will make them appear in a particular order i.e. `01_Artwork`, `O2_Promos`, `03_Motion_Graphics`. However, we usually don't want to display these numbers in the interface. In the player.php configuration settings, we can tell the script to ignore the first _n_ characters (the default is 3). The folders will be then listed as `Artwork`, `Promos`, `Motion Graphics`.

### File names


### Escaping Characters

### Adding Descriptions to the Playlist


## Player Configuration Settings
In `player.php` you have a list of configuration options. They are broken down into sections that control different elements on the page.  

#### movie dimensions
	$w = 768;
	$h = 432;

#### server config
	$dir = 'video';
	$playerurl = 'player.php';
	$root_dir = ''; 
 
#### page elements
Set the name of the website and the style sheet. Choose whether or not to be a responsive site. Choose whether to use `mediaelementjs` to normalize the html 5 and flash player.

	$websitename = 'Simple Video Portfolio';
	$stylesheet = $root_dir . 'css/global.css';
	$responsive = true;
	$mediaelementplayer = true;

__Navigation Options__	
	
	$dropdown = true;
	$prev_next = false;
	$prev_text = '<span class="hidden">Previous</span>';
	$next_text = '<span class="hidden">Next</span>'; 
	$playlist = true;
	$playlist_descriptions = true;

#### Video Parameters
Sets the HTML 5 video tag and it's attributes. See the full list of (video tag attributes)[]. Set whether or not you have a flash fallback.

	$html5_video = true;
	$poster_image = true;
	$video_tag_attributes = 'controls="controls" autoplay';
	$flash_fallback = true;

#### content
	$header = true;
	$h1 = true;
	$h2 = true;
	$heading2 = '<a href="'. $root_dir. 'player.php" title="Home" rel="home">Simple Video Portfolio</a>';
	$footer = true;
	$footer_text = '<a href="https://github.com/alienresident/Simple-Video-Portfolio">Simple Video Portfolio</a> (Github)';

#### Prettify file and directories, and add playlist descriptions
	$names_file = 'names.txt';
	$playlist_descriptions_file = 'descriptions.txt';

#### Advanced Player configurable variables
 
	$offline = false; // for development only: use a local copy of jQuery rather than the Google CDN
   
#### filename variables: ignore 'n' characters from filenames
	$dir_offset_start = 3; // remove the first 'n' characters i.e. 3 = '01_' from O1_Reel 
	$file_offset_start = 0; // remove the first 'n' characters
	$file_offset_end = -3; // remove the last 'n' characters before file extension i.e. -3 = '-sd' from filename-sd.mp4

#### CSS body classes
	$body_classes = "player";

#### Video sources, codecs, and media queries.
What codecs and mediaquries are to be used with certain filenames: i.e '-sd' = (Standard Definition), 'avc1.64001E, mp4a.40.2' h264 high profile, aac audio, 'all and (max-width: 854px). Media Queries should only be used if `$responsive = true`;

	$video_sources = array();
	$video_sources[] = array('filename_stem' => '-hd', 'codec' =>'avc1.64001E, mp4a.40.2', 'media' =>'');
	$video_sources[] = array('filename_stem' => '-sd', 'codec' =>'avc1.64001E, mp4a.40.2', 'media' =>'');
	$video_sources[] = array('filename_stem' => '-sm', 'codec' =>'avc1.42E01E, mp4a.40.2', 'media' =>'all and (max-width: 512px)'); 
	$video_sources[] = array('filename_stem' => '-wb', 'codec' =>'vp8, vorbis', 'media' =>'');

#### Which h264 file to use a flash fallback
	$flash_fallback_source = '-sd';	
	