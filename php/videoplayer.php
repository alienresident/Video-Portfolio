<?php include_once('videoplayer_functions.php'); ?>
<?php include_once('videoplayer_constructor.php'); ?>
<!doctype html>
<html>
  <head>
  <meta charset="utf-8">
  <title><?php print $website_title; ?></title>
<?php if($responsive): ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<?php endif; ?>
<?php if($mediaelementplayer): ?>
  <link rel="stylesheet" href="<?php print $root_dir ?>css/mediaelementplayer.min.css">
<?php endif; ?>
<?php if($stylesheet): ?>
  <link rel="stylesheet" href="<?php print $stylesheet ?>">
<?php endif; ?>
<?php if($dropdown): ?>
  <script>
    function reload(form) {
      var val=form.dirurl.options[form.dirurl.options.selectedIndex].value;
      self.location='<?php print $playerurl ?>?dirurl=' + val;
    }
    function reload2(form) {
      var val=form.dirurl.options[form.dirurl.options.selectedIndex].value;
      var val2=form.fileurl.options[form.fileurl.options.selectedIndex].value;
      self.location='<?php print $playerurl ?>?dirurl=' + val + '&fileurl=' + val2;
    }
  </script>
  <?php endif; ?>
  <?php if($mediaelementplayer): ?>
  <?php if($offline): ?>
    <script src="<?php print $root_dir ?>js/jquery-1.9.1.min.js"></script>
  <?php else: ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <?php endif; ?>
    <script src="<?php print $root_dir ?>js/mediaelement-and-player.min.js"></script>
<?php endif; ?>
</head>
<body class="<?php print $body_classes; ?>">
  <main role="main">
    <nav role="navigation">
<?php if($dropdown): ?>
      <form action="<?php print $_SERVER['PHP_SELF']; ?>" id="dropdown_menu" method="get">
        <select id="dirurl" role="listbox" onchange="reload(this.form)">
          <option value=''>Select a Directory</option>
          <?php print $select1; ?>
        </select>
          <?php print $select2; ?>
      </form>
<?php endif; ?>
<?php if($prev_next): ?>
      <ul role="menubar">
        <li role="menuitem"><?php print $prev; ?></li>
        <li role="menuitem"><?php print $next; ?></li>
      </ul>
<?php endif; ?>
    </nav>
    <article>
<?php if($header): ?>
    <header>
<?php if($h1): ?>
      <h1><?php if(isset( $heading1 )) { print $heading1; } ?></h1>
<?php endif; ?>
<?php if($h2): ?>
      <h2><?php if(isset( $heading2 )) { print $heading2; } ?></h2>
<?php endif; ?>
    </header>
<?php endif; ?>
    <figure class="videoplayer">
<?php if($html5_video): ?>
      <?php print $video_tag_open; ?>
      <?php print $video_tag_sources; ?>
<?php if($flash_fallback): ?>
          <!-- Flash fallback for non-HTML5 browsers without JavaScript -->
        <?php print $flash_object_open; ?>
<?php endif; ?>
            <!-- Image as a last resort -->
            <?php print $video_image_source; ?>
<?php if($flash_fallback): ?>
          <?php print $flash_object_close; ?>
<?php endif; ?>          
      <?php print $video_tag_close; ?>
<?php endif; ?>
<?php if($playlist): ?>
<aside role="complimentary">
  <nav role="navigation">
    <?php print $playlist_list; ?>
  </nav>
</aside>
<?php endif; ?>
    </figure>
    <?php if($footer): ?>
        <footer role="contentinfo">
          <p><?php print $footer_text; ?></p>
        </footer>
    <?php endif; ?>
  </article>
  </main>
<?php if($mediaelementplayer): ?>
  <script>
  $('audio,video').mediaelementplayer({
    success: function(player, node) {
       $('#' + node.id + '-mode').html('mode: ' + player.pluginType);
    }
  })
</script>
<?php endif; ?>
</body>
</html> 