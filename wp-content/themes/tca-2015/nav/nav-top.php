<!--just nav-->
<div class="nav-top" id="">
  <span>
    <?php $menuParameters = array(

      'container'       => false,
      'echo'            => false,
      'items_wrap'      => '%3$s',
      'menu'      => 'top',
      'depth'           => 0,
    );
    echo strip_tags(wp_nav_menu( $menuParameters ),'<a>');
    ?>
  </span>
</div>