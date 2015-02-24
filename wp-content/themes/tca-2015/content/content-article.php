<?php

echo get_terms('product_cat');

$terms = get_terms( 'product_cat');

// getting the name of the catogory, if statement based on whether or not it has parents
 foreach ( $terms as $term ) {
  	if($term->parent > 0){
      echo '<h1>' . $term->name . '</h1>';

       }
   }
    
foreach ( $terms as $term ) {
    if($term->parent > 0){
      echo '<h1>' . $term->slug . '</h1>';

       }
   }
    echo '<h1>'.get_the_title().'</h1>';

    echo '<p>'.the_content().'</p>';


    //description snipped to 75 words
     foreach ( $terms as $term ) {
     	if($term->parent > 0){
     		echo '<h1> About </h1>';
     		$descrip= $term->description;
     		$trimmed_content = wp_trim_words($descrip, 75); 
          $link = get_term_link($term);
      		echo '<p>' .$trimmed_content. '<a href= '.$link.' > >>Read more </a> </p>';
       }
    }
	//read more back to advice
    $i = 0;
    foreach ( $terms as $term ) {
    	if($i++ == 0) {
     	if($term->parent ==0){
     		$link = get_term_link($term);
     		$name = $term->name; 
     		echo '<a href= '.$link.' > Read more '.$name.' </a>';


     	}
       }
     } 



     //6 related articles

  		foreach ( $terms as $term ) {
        if($term->parent > 0){
          $slug= $term->slug;
          $loop = new  WP_Query( array('posts_per_page' => 6, 'taxonomy' => 'product_cat', 'term' => $slug,'post_type'=> array('article') ) );
          if ( $loop->have_posts() ){
        			 while ( $loop->have_posts() ) : $loop->the_post();
        		  		echo '<h2>';
                  the_time('m/d/Y');
        				  echo '<a href="'.get_permalink() .'">';
        				  the_title() ;
        				  echo '</a>';
        				  echo'</h2>';
        		
        		endwhile;
          }
	}
}

$termsfield = the_field('also_like', 'product-cat');
echo $termsfield;

if( $termsfield ){
   foreach( $termsfield as $term ){
    echo '<h1>' . $term->name . '</h1>';
    echo '<h1>' . $term->desciption . '</h1>';
    echo $termsfield;
    //<a href="<?php echo get_term_link( $term ); ">View all '<?php echo $term->name; ' posts</a>

      }
    }

  else{
    echo "Theres nothing in this field";
  }
//$alsolike = get_field('also_like', 'product-cat');
$term = get_term_by('slug', $atts['slug'], 'product_cat');
  $term_id = $term->term_id;
  $taxonomy_name = 'product_cat';
  $termchildren = get_term_children( $term_id, $taxonomy_name );
  $logo_url = get_field('also_like', $term);

  foreach ( $termchildren as $child ) {

        $term = get_term_by( 'id', $child, $taxonomy_name );
        echo $term;
        // $holder = $the_return;

        // $the_return = $holder.'<a href="' . get_term_link( $child, $taxonomy_name ) . '" class="sc-loop"><img src="'.$logo_url.'" class="sc-loop-logo">' .$term->name .'<a>';
      }

    return $the_return;
?>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
    <?php dynamic_sidebar('premium_content'); ?>
<?php endif; ?>