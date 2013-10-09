 
### NOTE: Documentation is still in Progress!

# Video Portfolio

Video Portfolio is a simple HTML 5 video player to showcase video-based portfolios. It's set up to deliver a great video experience no matter what browser or device your viewers have. 

The video player is designed to be flexible, so while it has a lot of options, you can use the default setup and get started right away. Once it's set up all you need to do is upload your videos.      

## What it does

* It creates a HTML 5 video player that works in all major browsers: Chrome, Safari, iOs (newer and older iPhones and iPads), Firefox, Opera, IE9 & IE10 and even IE8 (using a flash fallback).
* You can easily add more videos without updating any HTML. Simply upload the videos to your site (via ftp).
* It doesn't require a CMS that needs to be updated and maintained.

## How it Works
The video player script looks for a folder (i.e. videos) in a directory (or directories) and adds them to the player.

__Directory Structure:__

	player.php
	videos/
		01_Artwork/
		O2_Promos/
		
In this example `player.php` is looking in the `videos` folder and sees 2 subfolders: `01_Artwork` and `O2_Promos`. It will look for videos in these folders and create a player. Since there are 2 subfolders in this example it will create navigation options so you can view the contents of both folders. Navigation options can be specified [here](#navigation-options) 

### How to Add Videos
You can add just one version of your video or for better compatibility add multiple versions. It's recommended to add; a h264 video (high profile) for desktops, newer phones and tablets, and for the flash fallback; a webm video for Firefox and Opera browsers; and a h264 video (baseline profile) for older phones, tablets, and iPods.

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



## Advanced Configuration Options

### Naming Conventions
We want to have pretty (legible, human readable) names for our directories and videos without the hassle of updating HTML. So we have to go through a few slightly tricky steps to do this. Essentially, we're converting machine-friendly text into human-friendly text (i.e. manipulating strings). We got some rules to follow _aka_ naming conventions to get this to work properly.

### Folder Names
The sub folders by default will be in alphabetical order. Numbering the sub folders will make them appear in a particular order i.e. `01_Artwork`, `O2_Promos`, `03_Motion_Graphics`. However, we usually don't want to display these ordering numbers in the interface. In the player.php configuration settings, we can tell the script to ignore the first _n_ characters (the default is 3). The folders will be then listed as `Artwork`, `Promos`, `Motion Graphics`. If you want to use a different naming scheme you can change the numbers of characters to remove. See `$dir_offset_start` under [filename variables](#filename-variables) in the player config file.

### Video File Names
The script compares the file names of each video to see if they are different versions of the same video i.e. `artwork_1-hd.mp4` and `artwork_1-sd.mp4`. It then  removes the last _n_ characters (the default is 3) i.e. `-hd` and `-sd` and compares the remaining name i.e. `artwork_1` to make sure it's the same.

If you want to use a different naming scheme you can change the number of characters to remove. Look for `$file_offset_end` variable—under [filename variables](#filename-variables) in the player config file—this should be a negative number. You can also control the order of the videos, in the same way as with folder names, by numbering them and using the `$file_offset_start` variable—also under [filename variables](#filename-variables)—to remove _n_ characters (this should be a positive number). 

#### Video Sources, Codecs, and Media Queries.
The `$video_sources` array (under [video sources](#video-sources) in the player config) tells the script what codec the video is encoded with. If the site is responsive it tells what the dimensions of the video are. These values are the ones from the [encoding script](https://github.com/alienresident/Video-Portfolio/blob/master/scripts/README.md).

	$video_sources = array();
	$video_sources[] = array('filename_stem' => '-hd', 'codec' =>'avc1.64001E, mp4a.40.2', 'media' =>'');
	[…]

__Responsive example:__ 
 
	$video_sources = array();
	$video_sources[] = array('filename_stem' => '-hd', 'codec' =>'avc1.64001E, mp4a.40.2', 'media' =>'all and (min-width: 1280px)');
	[…]
	
__Note:__ If you have changed the video file naming scheme be sure to change the `filename_stem` here too.
	

### Escaping or Substituting Characters in File and Folder Names
In the `names.txt` you can escape or substitute characters. As it's can be problematic to have spaces in filenames underscores `_` are convert to HTML non-breaking spaces `&nbsp;`. The pipe `|` acts as a divider between what to look for and what to replace it with. You can use [regular expressions](http://www.php.net/manual/en/reference.pcre.pattern.syntax.php) on the first half if you wish.
  
	/_/|&nbsp;
	
You can add in other characters here to. You can use this for abbreviations in filenames or folder name. 

	/Big_Bunny/|Big&nbsp;Buck&nbsp;Bunny

You can change the name of the `names.txt` to whatever you like by changing the `$names_file` variable (under [Prettify Names and Add Playlist Descriptions](#prettify-names-and-add-playlist-descriptions) in the player config).

### Adding Descriptions to the Playlist
Adding description to the playlist is very similar to adding file and folder names. The `descriptions.txt` is used to add descriptions in the playlist. For the playlist descriptions to show up `$playlist` and `$playlist_descriptions` must be set to `true`. As the filenames have already been processed be sure to use the escaped version from the `names.txt` i.e. `Big&nbsp;Buck&nbsp;Bunny` not `big_buck_bunny`.

You can also change the name of the `descriptions.txt` to whatever you like by changing the `$playlist_descriptions_file` variable  (under [Prettify Names and Add Playlist Descriptions](#prettify-names-and-add-playlist-descriptions) in the player config).

## Player Configuration Settings
In `player.php` you have a long list of configuration options. They are broken down into sections that control different elements on the page.  

#### Server Config 
	$dir = 'video';
	$playerurl = 'player.php';
	$root_dir = ''; 

Where the videos are. If you want to change `player.php` to something else i.e. `videos.php` be sure to update the `$playerurl` here. If your player is in a subdirectory add the correct relative path to root dir where the css, php, and javascript files are i.e. If you need to go up one level then `$root_dir = '../';`
   
#### Page Elements
	
	$websitename = 'Video Portfolio';
	$stylesheet = $root_dir . 'css/global.css';

	$responsive = true;
	$mediaelementplayer = true;

* Set the name of the website
* Set the location of the stylesheet.   
* Choose whether or not to be a responsive site.   
* Choose whether to use `mediaelementjs` to style the look of html 5 and flash player.

##### Navigation Options	
	
	$dropdown = true;
	$prev_next = false;
	$prev_text = '<span class="hidden">Previous</span>';
	$next_text = '<span class="hidden">Next</span>'; 
	$playlist = true;
	$playlist_descriptions = true;

#### Movie Dimensions
	$w = 1280;
	$h = 720;

The standard dimensions of the player. This is __not__ used if `$responsive` is set to `true`.

#### Video Parameters
Sets the HTML 5 video tag and it's attributes (full list of [video tag attributes](http://html5doctor.com/the-video-element/)). Set whether or not you have a flash fallback.

	$html5_video = true;
	$poster_image = true;
	$video_tag_attributes = 'controls autoplay';
	$flash_fallback = true;

#### Content
	$header = true;
	$h1 = true;
	$h2 = true;
	$heading2 = '<a href="'. $root_dir .  $playerurl .'" title="Home" rel="home">Video Portfolio</a>';
	$footer = true;
	$footer_text = '<a href="https://github.com/alienresident/Video-Portfolio">Video Portfolio</a> (Github)';

#### Prettify Names and Add Playlist Descriptions
	$names_file = 'names.txt';
	$playlist_descriptions_file = 'descriptions.txt';

### Advanced Configurable Variables
 
	$offline = false; // for development only: use a local copy of jQuery rather than the Google CDN

If your developing locally with no internet connection set this to true. Otherwise you can ignore this.
   
#### Filename variables
	$dir_offset_start = 3; // remove the first 'n' characters from the directory name i.e. 3 = '01_' from O1_Artwork
	$file_offset_start = 0; // remove the first 'n' characters from the filename
	$file_offset_end = -3; // remove the last 'n' characters before file extension i.e. -3 will remove '-sd' from filename-sd.mp4

#### CSS Body Classes
	$body_classes = "player";

#### Video Sources
What codecs and mediaquries are to be used with certain filenames: i.e '-sd' = (Standard Definition), 'avc1.64001E, mp4a.40.2' h264 high profile, aac audio, 'all and (max-width: 854px). Media Queries should only be used if `$responsive = true`;

	$video_sources = array();
	$video_sources[] = array('filename_stem' => '-hd', 'codec' =>'avc1.64001E, mp4a.40.2', 'media' =>'all and (min-width: 1280px)');
	$video_sources[] = array('filename_stem' => '-sd', 'codec' =>'avc1.64001E, mp4a.40.2', 'media' =>'');
	$video_sources[] = array('filename_stem' => '-sm', 'codec' =>'avc1.42E01E, mp4a.40.2', 'media' =>'all and (max-width: 512px)'); 
	$video_sources[] = array('filename_stem' => '-wb', 'codec' =>'vp8, vorbis', 'media' =>'');

#### Which h264 file to use a flash fallback
	$flash_fallback_source = '-hd';	


### Useful Links for HTML 5 Video
[The State Of HTML5 Video](http://www.longtailvideo.com/html5/)
