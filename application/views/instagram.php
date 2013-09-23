<link rel="stylesheet" type="text/css" href="css/instagram.css" />
<div class="cont">
	<div class="title"> Instagram</div>
	<?php
	$count =0;
	foreach($popular_media as $data) {
		/*
		// To see all the data that each media item contains uncomment the following		
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		*/
		if($count ==0){
			echo "<div class='clearfix bord_bot'>";
		}
		//display img data
		echo '<div class="list_cont">';
		// Display the thumbnail image
		echo '<p><img src="' . $data->images->thumbnail->url . '" /></p>';
		
		// Display the user name
		echo '<p class="author">Taken by ' . $data->user->username . '</p>'; 
		
		echo '</div>';
		
		$count++;		
		if($count ==4){
			echo "</div>";
			$count =0;
		}
	
	}
	
	
	?>
</div>