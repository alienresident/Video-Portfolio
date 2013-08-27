<?php

/**
 * initialize files and directories
 */

$subdirectories = '';
$subdirectories_list = '';

$files = '';
$file_names = '';
$file_names_deduped = ''; 
$file_names_images = '';
$file_names_images_deduped = ''; 
 
/**
 * initialize page elements
 */
$select1 = '';
$select2 = '';
$next = '';
$prev = '';
$video_tag_open = "\n";
$video_tag_sources = "\n";
$flash_object_open = "";
$flash_object_close = "</object>\n";
$video_tag_close = "</video>\n";
$poster_image_file = '';
$video_image_source = '';
$playlist_list = '';

// constructor 

/**
 * if video $dir exists get list of subdirectories
**/
if(isset($dir)) {
  $subdirectories = get_subdirs_list($dir);
}

/**
 * reformat subdirectories using the patterns in $names_file
**/
if(is_array($subdirectories) and isset($names_file)) {
  $subdirectories_list = get_names($subdirectories, $type = 'dirs', $names_file, $dir_offset_start);
}

/**
 * get list of the files in the subdirectories
 */
if(isset($dirurl) and strlen($dirurl) > 0 and is_array($subdirectories)) {
  $files = get_file_list($dirurl, $subdirectories);
}

/**
 * reformat files, dedupe files, and get poster image name using the patterns in $names_file
 */
if(is_array($files)) {
  $file_names = get_names($files, $type = 'files', $names_file, $file_offset_start, $file_offset_end);
  $file_names_deduped = dedupe_files($file_names);
  $file_names_images = get_names($files, $type = 'filenames', $names_file, $file_offset_start, $file_offset_end);
}

/**
 * get dedupe poster image name
 */
if(is_array($file_names_images)) {
  $file_names_images_deduped = dedupe_files($file_names_images);
}

/**
 * start building template file 
 */
if(is_array($subdirectories_list) and isset($dirurl) and is_array($file_names_deduped)) {
  
  if(empty($fileurl)) {
    $first = array_slice($file_names_deduped, 0, 1, true);
    @$fileurl = key($first)+1;
  }
  
  $website_title = get_page_title($websitename, $subdirectories_list, $dirurl, $file_names_deduped, $fileurl);
  $heading1 = get_heading_title($subdirectories_list, $dirurl, $file_names_deduped, $fileurl);
  $select1 = get_select_options($subdirectories_list, $dirurl);
  
  if(count($file_names_deduped) > 1) {
    $select2 = get_select_options($subdirectories_list, $dirurl, $file_names_deduped, $fileurl);
  }
  
  if($poster_image) {
    $poster_image_file = set_poster_image($file_names_images, $file_names_images_deduped, $fileurl);
    $video_tag_open = set_video_tag_attributes($video_tag_attributes, $w, $h, $poster_image_file);
  } else {
    $video_tag_open = set_video_tag_attributes($video_tag_attributes, $w, $h);
  }
  
  $video_tag_sources = set_video_tag_sources($files, $file_names_deduped, $fileurl, $video_sources);
  $video_image_source = set_video_image_source($file_names_images, $file_names_images_deduped, $fileurl);
  
  if($flash_fallback) {
    $flash_object_open = set_flash_object_open($files, $file_names_deduped, $fileurl, $flash_fallback_source, $root_dir);
  }
  
  if($prev_next) {
    $prev = get_current_dir_position($dirurl, $subdirectories, $playerurl, $type = "prev", $prev_text, $next_text);
    $next = get_current_dir_position($dirurl, $subdirectories, $playerurl, $type = "next", $prev_text, $next_text); 
  }
  
  if(($playlist) && (count($file_names_deduped) > 1)) {
    $body_classes .= " playlist";
    if($playlist_descriptions) {
      $playlist_list  = set_playlist_list($subdirectories_list, $dirurl, $file_names_deduped, $fileurl, $playerurl, $file_names_images_deduped, $playlist_descriptions_file);
    } else {
      $playlist_list  = set_playlist_list($subdirectories_list, $dirurl, $file_names_deduped, $fileurl, $playerurl, $file_names_images_deduped);
    }
  }
  
} elseif(is_array($subdirectories_list) and isset($dirurl)) {
  $website_title = get_page_title($websitename, $subdirectories_list, $dirurl);
  $heading1 = get_heading_title($subdirectories_list, $dirurl);
  $select1 = get_select_options($subdirectories_list, $dirurl);
} else {
  $website_title = get_page_title($websitename);
}