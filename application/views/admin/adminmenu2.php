<div id="accordion" style="width:140px; float:left; text-align:center; font-size:12px; margin-right:20px; padding:10px 0;">
    <!-- <h4><a href="#">Admin Home</a></h4> -->
    <!-- <div class="marg7_0"> -->
    <!--     <a href="<?php //echo base_url(); ?>admin/home">Home</a> -->
    <!-- </div> -->
    <!--  -->
    <!-- <h4><a href="#">Front Page</a></h4> -->
    <!-- <div class="marg7_0"> -->
    <!--     <a href="<?php //echo base_url(); ?>admin/fpwindows/addnew">Add new window</a><br/> -->
    <!--     <a href="<?php //echo base_url(); ?>admin/fpwindows/listing">Windows List</a> -->
    <!-- </div> -->
    <!--  -->
    <!-- <h4><a href="#">Photos</a></h4> -->
    <!-- <div class="marg7_0"> -->
    <!--     <a href="<?php //echo base_url(); ?>admin/photos/addnew">Add Photo</a><br/> -->
    <!--     <a href="<?php //echo base_url(); ?>admin/photos/albumlist">List Albums</a> -->
    <!-- </div> -->
    <!--  -->
    <!-- <h4><a href="#">Portfolio</a></h4> -->
    <!-- <div class="marg7_0"> -->
    <!--     <a href="/admin/portfolio/addnew">Add Portfolio</a><br/> -->
    <!--     <a href="/admin/portfolio/listing">List Portfolio</a> -->
    <!-- </div> -->
	<?php
	if(!empty($menu_array)){
		foreach($menu_array AS $parent):
			echo "<h4><a href='#'>".$parent['link_name']."</a></h4>";
			echo "<div class='marg7_0'>";
			if(!empty($parent['submenu'])){
				foreach($parent['submenu'] AS $submenu):
					echo "<a href='".$submenu['url']."'>".$submenu['link_name']."</a><br />";
				endforeach;

			}

			echo "</div>";

		endforeach;
	}

	?>
</div>


<script>
$(function() {
    $( "#accordion" ).accordion({ active:false });
});
</script>
<div class="content_block go_left">
