<?php
			
			if (!empty(term_description( ))){
				echo '<div class="topic-description">'.term_description( ).'</div>';
			}
			//this gets the list of topics

			include 'includes/products-loop.php';
			include 'includes/articles-loop.php';
			include 'includes/topics_loop.php';
			include 'includes/news-loop.php';
			

?>