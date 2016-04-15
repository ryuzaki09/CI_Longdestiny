<div id="accordion" style="width:140px; float:left; text-align:center; font-size:12px; margin-right:20px; padding:10px 0;">
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
    <h4><a href="#">Admin Menu</a></h4>
    <div class="marg7_0">
        <a href="/admin/home/menusetup">Menu setup</a><br />
        <a href="/admin/home/menulist">Menu List</a>
    </div>
</div>


<script>
$(function() {
    $( "#accordion" ).accordion({ active:false });
});
</script>
<div class="content_block go_left">
