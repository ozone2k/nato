<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> &middot; <?php bloginfo('description'); ?></title>
<!-- Framework CSS -->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/blueprint/screen.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/blueprint/print.css" type="text/css" media="print">
<!--[if lt IE 8]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css" type="text/css" media="screen" charset="utf-8" />
<link media="screen" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/js/colorbox/colorbox.css" />
<link href='http://fonts.googleapis.com/css?family=Candal&v1' rel='stylesheet' type='text/css'>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script src="<?php bloginfo('template_url'); ?>/js/jquery-1.6.1.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/colorbox/jquery.colorbox.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.init.js"></script>
<?php wp_head(); ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24472298-1']);
  _gaq.push(['_setDomainName', '.renatoparente.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>

<div id="header">
    <div class="container">
        <div class="span-17">
            <h1 class="siteTitle"><a href="<?php bloginfo('home'); ?>"><?php bloginfo('name'); ?></a></h1>
            <div class="siteDescr"><?php bloginfo('description'); ?></div>
        </div>
        <div class="span-7 last">
        	<?php /*include (TEMPLATEPATH . '/searchform.php'); */?>
        </div>
    </div>
</div>

<div id="body">
	<div class="container">
