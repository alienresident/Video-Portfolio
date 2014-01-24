<?php

if(!class_exists('preg_find')) { include 'preg-find.php'; }

@$dirurl = $_GET['dirurl']; // This line is added to take care if your global variable is off

if(strlen($dirurl) > 0 && !is_numeric($dirurl)){ // Check if $dirurl exists and is numeric data or not.
  echo "Data Error";
  exit;
}

@$fileurl = $_GET['fileurl'];

/**
 * Use the $names_file to reformat/preg_replace filenames
 */
function video_code(&$video_code, $names_file) {
  // load the names files
  $file_handle = fopen($names_file, "rb");
    while (!feof($file_handle) ) {
      $line_of_text = fgets($file_handle);
      $parts = explode('|', $line_of_text);
      // use each line to replace folder and files names and create a pretty list
      $video_code = preg_replace($parts[0],$parts[1],$video_code);
      $video_code = preg_replace('/^\s+|\n|\r|\s+$/m', '',$video_code);
    }
    fclose($file_handle);
    return $video_code;
}

/**
 * get list of subdirectories and sort them
 */
function get_subdirs_list($dir) {
  $dirs = preg_find('/./', $dir, PREG_FIND_DIRONLY);
  array_multisort($dirs, SORT_ASC, SORT_STRING);
  return $dirs;
}

/**
 * get list of files and sort them
 */
function get_file_list($dirurl, $dirs) {
  if(isset($dirurl) and strlen($dirurl) > 0) {
    $dirlist = $dirs[$dirurl-1];
    $files = preg_find('/^.*?\.m|^.*?\.w/D', $dirlist, PREG_FIND_SORTKEYS);
    array_multisort($files, SORT_ASC, SORT_STRING);
  }
  return $files;
}

/**
 * found out if there's a previous or next folder for the navigation
 */
function get_current_dir_position($dirurl, $dirs, $playerurl, $type, $prev_text, $next_text) {
  $total_dirs = count($dirs);
  $url = $playerurl . '?dirurl=';
    if($total_dirs > 1) {
    switch ($dirurl) {
      case $dirurl == $total_dirs:
        $prev = '<span class="prev prev-next"><a href="'. $url . ($dirurl - 1) . '" title="Previous">'. $prev_text .'</a></span>';
        $next = "<span class=\"next last prev-next\">$next_text</span>";
        break;
      case $dirurl == 1:
        $prev = "<span class=\"prev last prev-next\">$prev_text</span>";
        $next = '<span class="next prev-next"><a href="'. $url . ($dirurl + 1) . '" title="Next">'. $next_text .'</a></span>';
        break;
      default:
        $prev = '<span class="prev prev-next"><a href="'. $url . ($dirurl - 1) . '" title="Previous">'. $prev_text .'</a></span>';
        $next = '<span class="next prev-next"><a href="'. $url . ($dirurl + 1) . '" title="Next">'. $next_text .'</a></span>';
        break;
    }
  }
  if($type == "prev") {
    return $prev;
  } elseif($type == "next") {
    return $next;
  }
}

/**
 * remove some of filename and directories and reformat them 
 */
function get_names($names, $type, $names_file, $offset_start, $offset_end = null, $imgfolder = "/images/", $imgtype = ".jpg" ) {
  foreach($names as $key => &$value) {
    if( ($type == 'dirs') || ($type == 'files') ) {
      $v1 = strrpos($value,"/") + 1;
    } 
    if( $type == 'dirs') {
      $value = substr($value,$v1);
    } elseif($type == 'files') {
      $v2 = strpos($value,".");
      $value = substr($value,$v1,($v2-$v1));
    } elseif ($type == 'filenames') {
      $imgname = pathinfo($value, PATHINFO_FILENAME);
      $foldername  = pathinfo($value, PATHINFO_DIRNAME);
      $value = $foldername . $imgfolder . $imgname;
    }
    if(!empty($offset_end)) {
      $value = substr($value, $offset_start, $offset_end);
    } else {
      $value = substr($value, $offset_start);
    }
    if ($type == 'filenames') {
      $value = $value . $imgtype;
    }
    if( ($type == 'dirs') || ($type == 'files') ) {
      $value = video_code($value, $names_file);
    }
  }
  return $names;
}


/**
 * dedupe files so we can use it for the poster image
 */
function dedupe_files( $filenames ) {
   $no_duplicates = array_intersect_key( $filenames , array_unique( array_map('serialize', $filenames ) ) );
   return $no_duplicates;
}

/**
 * get the page title from the filename
 */
function get_page_title($websitename, $dirs = null, $dirurl = null, $files = null, $fileurl = null) {
  if(is_array($dirs) and isset($dirurl) and is_array($files) and isset($fileurl)) {
    $foldername = get_name_from_url($dirs, $dirurl);
    $filename =   get_name_from_url($files, $fileurl);
    $website_title = $websitename . ' | ' . $foldername . ' | ' . $filename;
  } elseif(is_array($dirs) and isset($dirurl)) {
    $foldername = get_name_from_url($dirs, $dirurl);
    $website_title = $websitename . ' | ' . $foldername;
  } else {
    $website_title = $websitename;
  }   
  return $website_title;
}

/**
 * get the heading title from the file name
 */
function get_heading_title($dirs, $dirurl, $files = null, $fileurl = null) {
  if(is_array($dirs) and isset($dirurl) and is_array($files) and isset($fileurl)) {
    $foldername = get_name_from_url($dirs, $dirurl);
    $filename =   get_name_from_url($files, $fileurl);
    if(count($files) > 1) {
      $heading1 =  $foldername . ': ' . $filename;
    } else {
      $heading1 =  $foldername;
    }
  } elseif(is_array($dirs) and isset($dirurl)) {
    $foldername = get_name_from_url($dirs, $dirurl);
    $heading1 = $foldername;
  }   
  return $heading1;
}

/**
 * get the heading title from the file name
 */
function get_name_from_url($names, $url) {
  if(strlen($url) > 0 && !is_numeric($url)) {
  } else {
    if(!empty($url)) {
      $key = $url -1;
      $value = $names[$key];
      $name = $value;
      return $name;
    }
  }
}
/**
 * get the list of the subdirectories for the dropdown
 */
function get_select_options($dirs, $dirurl, $files = null, $fileurl = null) {
  $options = '';
  if(!empty($files)) {
    $options .= "<select id=\"fileurl\" role=\"listbox\" onchange=\"reload2(this.form)\">\n";
    $options .= set_select_options($files, $fileurl);
    $options .= "</select>\n";
  } elseif(!empty($dirs)) {
    $options = set_select_options($dirs, $dirurl);
  }
  return $options;
}

/**
 * fill out the list of the subdirectories for the dropdown
 */
function set_select_options($type, $url) {
  $option = '';
  foreach($type as $key => &$value) {
    $key = $key + 1;
    if($key == @$url) {
      $option .= "<option role=\"option\" aria-selected=\"true\" value=\"$key\" selected>$value</option>\n";
    } else {
      $option .= "<option role=\"option\" aria-selected=\"false\" value=\"$key\">$value</option>\n";
    }
  }
  return $option;
}

/**
 * get the deduped images 
 */
function get_image($file_names_images, $file_names_images_deduped, $fileurl) {
  $file_names = count($file_names_images);
  $unique_file_names = count($file_names_images_deduped);
  if($unique_file_names > 1) {
    // echo 'more than 1 image';
    $i = $fileurl - 1;
    $t = ($file_names / $unique_file_names) + $i;
  } else {
    $t = $file_names;
    $i = 0;
  }
  for ($i; $i < $t; $i++) {
    $image = $file_names_images[$i];
  }
  return $image;
}

/**
 * set the poster image
 */
function set_poster_image($file_names_images, $file_names_images_deduped, $fileurl) {
  $image = get_image($file_names_images, $file_names_images_deduped, $fileurl);
  $poster_image = "poster=\"$image\" ";
  return $poster_image;
}

/**
 * set the fallback image
 */
function set_video_image_source($file_names_images, $file_names_images_deduped, $fileurl) {
  $image = get_image($file_names_images, $file_names_images_deduped, $fileurl);
  $video_source_image = "<img src=\"$image\" style=\"width:100%; height:100%;\" alt=\"No video playback capabilities\">\n";
  return $video_source_image;
}

/**
 * set the video tag attributes
 */
function set_video_tag_attributes($video_tag_attributes, $w, $h, $poster_image_file = null) {
  $video_tag_open = "<video $poster_image_file$video_tag_attributes width=\"$w\" height=\"$h\">\n";
  return $video_tag_open;
}

/**
 * set the video tag sources
 */
function set_video_tag_sources($filenames, $filesdeduped, $fileurl, $video_sources) {
  $file_names = count($filenames);
  $unique_file_names = count($filesdeduped);
  if($unique_file_names > 1){
    // echo 'more than 1 video';
    $i = $fileurl - 1;
    $t = ($file_names / $unique_file_names) + $i;
  } else {
    $t = $file_names;
    $i = 0;
  }
  $sources = '';
  asort($filenames);
  for ($i; $i < $t; $i++) {
    $file = $filenames[$i];
    $stem = $video_sources[$i]['filename_stem'];
    $codec = $video_sources[$i]['codec'];
    $media = $video_sources[$i]['media'];
    //echo $media;
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $filename = pathinfo($file, PATHINFO_FILENAME);
    if(strstr($filename,$stem) == $stem) {
      if(!empty($media)) {
        $sources .= "\t<source src=\"$file\" type='video/$ext; codecs=\"$codec\"' media=\"$media\">\n";
      } else {
        $sources .= "\t<source src=\"$file\" type='video/$ext; codecs=\"$codec\"'>\n";
      }
    }
  }
  return $sources;
}

/**
 * set the flash fallback object tag
 */
function set_flash_object_open($filenames, $filesdeduped, $fileurl, $flash_fallback_source, $root_dir) {
  $file_names = count($filenames);
  $unique_file_names = count($filesdeduped);
  if($unique_file_names > 1){
    // echo 'more than 1 video';
    $i = $fileurl - 1;
    $t = ($file_names / $unique_file_names) + $i;
  } else {
    $t = $file_names;
    $i = 0;
  }
  $flash_object_open = '';
  asort($filenames);
  for ($i; $i < $t; $i++) {
    $file = $filenames[$i];
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $filename = pathinfo($file, PATHINFO_FILENAME);
    if(strstr($filename, $flash_fallback_source) == $flash_fallback_source) {
      $flash_object_open .= '<object style="width:100%; height:100%;" type="application/x-shockwave-flash" data="' . $root_dir . 'js/flashmediaelement.swf">';
      $flash_object_open .= '<param name="movie" value="' . $root_dir . 'js/flashmediaelement.swf">'; 
      $flash_object_open .= "\t\t<param name=\"flashvars\" value=\"controls=true&file=$file\" />\n";
    }
  }
  return $flash_object_open;
}

/**
 * set the playlist list 
 */
function set_playlist_list($dirs, $dirurl, $files, $fileurl = null, $playerurl, $file_names_images_deduped, $playlist_descriptions_file = null) {
  $list = '';
  if(!empty($files)) {
    $list .= "<ul id=\"playlist\" role=\"menu\">\n";
    $list .= set_playlist_list_items($files, $fileurl, $dirurl, $playerurl, $file_names_images_deduped, $playlist_descriptions_file);
    $list .= "</ul>\n";
  }
  return $list;
}

/**
 * set the playlist list items
 */
function set_playlist_list_items($type, $url, $dirurl, $playerurl, $file_names_images_deduped, $playlist_descriptions_file) {
  $listitem = '';
  $fullurl = $playerurl . '?dirurl='. $dirurl . '&fileurl='; 
  foreach($type as $key => &$value) {
    if(!is_null($playlist_descriptions_file)) { 
      $ref = $value;
      $description = video_code($ref, $playlist_descriptions_file);
      $description = " <span>$description</span>";
    } else {
      $description = '';
    }
    $image = "<img src=\"$file_names_images_deduped[$key]\">";
    $key = $key + 1;
    if($key == @$url) {
      $listitem .= "<li role=\"menuitem\" class=\"selected\"><a href=\"$fullurl$key\" title=\"$value\">$image</a><a href=\"$fullurl$key\" title=\"$value\">$value</a>$description</li>\n";
    } else {
      $listitem .= "<li role=\"menuitem\"><a href=\"$fullurl$key\" title=\"$value\">$image</a><a href=\"$fullurl$key\" title=\"$value\">$value</a>$description</li>\n";
    }
  }
  return $listitem;
}