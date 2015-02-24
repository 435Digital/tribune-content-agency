<!--just nav-->
<nav class="header" id="">
<?php $menuParameters = array(

  'container'       => false,
  'echo'            => false,
  'items_wrap'      => '%3$s',
  'menu'      => 'header',
  'depth'           => 0,
);

echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
?>
</nav>