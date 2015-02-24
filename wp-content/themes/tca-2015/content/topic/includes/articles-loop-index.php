<?php 
$paged_a = get_query_var('paged') ? get_query_var('paged') : 1;
/*function wpsites_exclude_post($query) {
				
				$query->set( 'offset', '4' );
					
				}

			add_action('pre_get_posts', 'wpsites_exclude_post');*/

			add_action('pre_get_posts', 'myprefix_query_offset', 1 );
			function myprefix_query_offset(&$query) {

			    //Before anything else, make sure this is the right query...
			    if ( ! $query->is_posts_page ) {
			        return;
			    }

			    //First, define your desired offset...
			    $init_count = 4;
			    $offset = ( $paged_a - 1 ) * $init_count;;
			    
			    //Next, determine how many posts per page you want (we'll use WordPress's settings)
			    $ppp = get_option('posts_per_page');

			    //Next, detect and handle pagination...
			    if ( $query->is_paged ) {

			        //Manually determine page query offset (offset + current page (minus one) x posts per page)
			        $page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );

			        //Apply adjust page offset
			        $query->set('offset', $page_offset );

			    }
			    else {

			        //This is the first page. Just use the offset...
			        $query->set('offset',$offset);

			    }
			}
			add_filter('found_posts', 'myprefix_adjust_offset_pagination', 1, 2 );
			function myprefix_adjust_offset_pagination($found_posts, $query) {

			    //Define our offset again...
			    $init_count = 4;
			    $offset = ( $paged_a - 1 ) * $init_count;;

			    //Ensure we're modifying the right query object...
			        //Reduce WordPress's found_posts count by the offset... 
			        return $found_posts - $offset;
			}
			
		$init_count = 4;

		//$paged_a = get_query_var('paged') ? get_query_var('paged') : 1;

		$offset = ( $paged_a - 1 ) * $init_count;

		 //$ppp = get_option( 'posts_per_page' );     

		$q_articles = new WP_Query( array( 
			'posts_per_page' => 2,
			'post_type' => 'article',
			'taxonomy' => $taxonomy,
			'term' => $slug,
			'paged' => $paged_a,
			'offset'     =>  $offset


		) );

		$count = $custom_posts->post_count;
		$found=$wp_query->found_posts;
		//wpsites_exclude_post($q_articles);
		
		

		if($q_articles->have_posts()==1){
		
			
		

			echo'<br>ARTICLES<br>';

			while ( $q_articles->have_posts() ) : $q_articles->the_post();

				 echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';

			endwhile;
			myprefix_query_offset($q_articles);
			myprefix_adjust_offset_pagination($found,$q_articles);
			echo get_next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts' ) );
			echo get_previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>' ) );
			//wp_pagenavi(); 

			wp_reset_query();
		}
?>