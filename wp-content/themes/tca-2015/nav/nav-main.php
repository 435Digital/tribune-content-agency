<nav><ul class="nv-m back-blue link-white f-san f-up" id="main-nav"><?php $mp = array(

		  'container'       => false,
		  'echo'            => false,
		  'items_wrap'      => '%3$s',
		  'menu'      => 'main',
		  'depth'           => 0,
		);echo strip_tags(wp_nav_menu( $mp ), '<ul><li><a>' );
		?></ul></nav>