<?php

    $seconds_to_cache = 86400;
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    header("Expires: $ts");
    header("Pragma: cache");
    header("Cache-Control: max-age=$seconds_to_cache");

     $visitors = file_get_contents("visitors");
     $visitorsArr = explode(",", $visitors);

     if ( !in_array($_SERVER["REMOTE_ADDR"], $visitorsArr )) {
          $visitorsArr[] = $_SERVER["REMOTE_ADDR"];

          $fh = fopen("visitors", 'w');
          fwrite($fh, implode(",", $visitorsArr));
          fclose($fh);

          $counter = (float)file_get_contents("counter");
          $counter++;
          $fh = fopen("counter", 'w');
          fwrite($fh, "" + $counter + "\n");
          fclose($fh);
     }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>My Wallpaper Gallery</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="My Wallpaper Gallery">
    <meta property="og:title" content="My Wallpaper Gallery">
    <meta property="og:url" content="http://wallpapers.carroarmato0.be/">
    <meta property="og:description" content="Collection of wallpapers gathered from all around the internet which appeal to my interests.">
    <?php
    	$xml = simplexml_load_file('http://wallpapers.carroarmato0.be/gallery.xml');
        $counter = 0;
        foreach ($xml->children() as $node ) {
            $arr = $node->attributes();
	    echo '<meta property="og:image" content="http://wallpapers.carroarmato0.be/' . (string)$arr["thumbURL"] . '">', "\n";
            $counter++;
            if ($counter == 20) break;
        }
    ?>
    <link href="res/css/style.css" rel="stylesheet" type="text/css" />
    <link href="res/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
    <script type="text/javascript" src="res/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script src="res/js/script.js" type="text/javascript"></script>
    <script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-263141-7']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
    </script>

</head>
<body>
    <div id="Content">
	 <div id="header">
             <h2>My Wallpaper Gallery</h2>
             <div id="fb-root"></div>
             <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            <div class="fb-like-box" data-href="https://www.facebook.com/pages/Wallpapers/208387139227021" data-width="270" data-show-faces="false" data-stream="false" data-header="true"></div>
             <h3>&nbsp;</h3>
             <h4></h4>
        </div>
        <div class="block" id="Prototype"></div>
        <div id="Container"></div>
    </div>

    <!-- The container for the description -->
    <div id="image_description">
        <span>Hover to view background</span><br />
        <a id="image_url" target="_blank">Click to open</a>
    </div>

    <!-- The container for the background-image -->
    <img id="bg" alt="background" style="display:none" />

    <!-- The container for the grid on top of the background-image -->
    <div id="bg_grid" style="display:none">&nbsp;</div>
</body>
</html>
