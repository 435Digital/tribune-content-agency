<?php
			$des = term_description();
			if (!empty($des)){
				echo '<div class="topic-description">'.$des.'</div>';
			}
			//this gets the list of topics

			include 'includes/products-loop.php';
			include 'includes/topics_loop.php';
			include 'includes/articles-loop.php';
			include 'includes/news-loop.php';
			

?>