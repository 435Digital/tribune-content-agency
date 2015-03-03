<?php

$queried_object = get_queried_object();
$paged_a = get_query_var('paged') ? get_query_var('paged') : 1;  
	
	$taxonomy = $queried_object->taxonomy;
	
	$term_id = $queried_object->term_id;
	$term = get_term( $term_id, $taxonomy);
	$name = $term->name;
	$slug = $term->slug;

interface pageable{
  public function article();
}
echo '<main class="content-m f-ser"><div class="content-simple"><div class="column w3-4">';

	class page1_loop implements pageable{
  		public function article(){
  			include 'topic/topic_page1.php';
		}
	}

	class page1_loop_nxt implements pageable{
	  	public function article(){
	    	include 'topic/topic_page.php';
	  	}
	}

//articles


$art_lnk = new page1_loop_nxt();

if($paged_a == 1) {
	$ppp_a = 4;
	$art_lnk = new page1_loop();


}

$art_lnk->article();




echo '</div><aside class="w1-4"></aside></div></main>';
?>