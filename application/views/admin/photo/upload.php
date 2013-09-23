<div class="content_block go_left">
<div class="page_title"><?php echo $pagetitle; ?></div>
<!-- Display image names after uploading -->
<?php if(isset($imgfiles) && is_array($imgfiles)){
	foreach($imgfiles AS $img){
		echo $img;
	}
} ?>
<!-- Display any error messages  -->
<?php if(isset($message) && $message){ 
        echo "<div class='error' style='margin-bottom:10px;'>";
        echo $message; 
        echo "</div>";
        } ?>


<?php echo form_open_multipart(base_url().'admin/photos/addnew'); ?>
<div class="clearfix list_div">
	<div class="go_left label2">Upload to Folder</div>
	<div class="go_left">
		<select name="folder_name1">
			<option value="">Select a Folder</option>
                        <?php if(is_array($albums)){ 
                                foreach($albums AS $folders){                                    
                                    echo "<option value='".$folders['folder_name']."'>".$folders['folder_name']."</option>";
                                }
                        } ?>
		</select>
                
	</div>
</div>
<div class="clearfix list_div">
	<div class="go_left label2">Create new Folder</div>
	<div class="go_left"><input type="text" name="folder_name2" /></div>
</div>
<div class="clearfix list_div">
	<div class="go_left label2">Image1</div>
	<div class="go_left"><input type="file" name="img1" /></div>
</div>
<div class="clearfix list_div">
	<div class="go_left label2">Title 1</div>
	<div class="go_left"><input type="text" name="title1" /></div>
</div>
<div class="clearfix list_div">
	<div class="go_left label2">Image2</div>
	<div class="go_left"><input type="file" name="img2" /></div>
</div>
<div class="clearfix list_div">
	<div class="go_left label2">Title 2</div>
	<div class="go_left"><input type="text" name="title2" /></div>
</div>
<div class="clearfix list_div">
	<input type="submit" name="upload" value="Upload" />
</div>
<?php echo form_close(); ?>
<!--<div id="edit" class="clearfix list_div">
	<a href="<?php echo base_url().'admin/fpwindows/listing'; ?>">Windows list</a><br/>
	<a href="http://www.facebook.com">Facebook</a>
</div>
<div class="clearfix list_div">
	<a href="<?php echo base_url().'admin/fpwindows/listing'; ?>">Windows list</a><br/>
	<a href="http://www.facebook.com">Facebook</a>
</div>-->
</div><!-- content_block -->

<!--<script>
//find all href links except self domain
$("#edit > a[href^='http:']:not([href*='" + window.location.host + "'])").each(function() {               
        $(this).attr("target", "_blank");
});

</script>-->