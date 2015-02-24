<?php
/* cron for four-three-five-rss plugin */

include_once( ABSPATH . WPINC . '/feed.php' );
$rss = fetch_feed($items['rss_url']);


//EOF