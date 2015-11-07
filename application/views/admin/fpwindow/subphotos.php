    <div class='page_title'><?php echo $pagetitle; ?></div>
    <?php if (isset($imgfiles) && $imgfiles){
        foreach($imgfiles AS $files){
            echo $files;
        }
    } ?>
    
    <!-- uploaded sub photos -->
    <?php if(is_array($sub_photos) && !empty($sub_photos)){ ?>
            <div>Uploaded images</div>
            <div class="clearfix bottom_space" style="padding-bottom:10px; border-bottom:1px solid #cacaca;">
    <?php   foreach ($sub_photos AS $fpphoto){ ?>
                <div class="go_left" id="img_<?php echo $fpphoto['photoID']; ?>" style="width:220px; margin-right:7px;">
                    <img src="/media/images/frontpage/thumbs/<?php echo $fpphoto['imgname']; ?>" width="200" height="150" />
                    <br/>
                    <button class="btn btn-primary delete" data-photoid="<?php echo $fpphoto['photoID'] ?>" 
						data-folder="<?php echo $fpphoto['foldername'] ?>"
						data-imgname="<?php echo $fpphoto['imgname'] ?>">
						Delete 
					</button>
                </div>
    <?php   } ?>
            </div>
    <?php } ?>
                
    <!--- form to upload images --->
    <?php echo form_open_multipart('/admin/fpwindows/subphotos/'.$item->id); ?>
    
    <div class="clearfix">
        <div class="block150 go_left">Sub Photo 1<br/><span class="note">(Dimensions: 260x173)</span></div>
        <div class="block250 go_left"><input type="file" name="image1" /></div>
    </div>
    <div class="clearfix">
        <div class="block150 go_left">Sub Photo 2<br/><span class="note">(Dimensions: 260x173)</span></div>       
        <div class="block250 go_left"><input type="file" name="image2" /></div>
    </div>
    <div class="clearfix">
        <div class="block250 go_left">
			<input type="submit" class="btn btn-primary" name="upload" value="Upload" />
		</div>
    </div>
    
    <?php echo form_close(); ?>

<script>
$('button.delete').on("click", function(){
    var response = confirm('Are you sure you want to delete?');
    if (response){
		var id = $(this).data("photoid");
		var foldername = $(this).data("folder");
		var imgname = $(this).data("imgname");
        //var url = "<?php echo base_url();?>admin/fpwindows/delete_subphoto";
        var url = "<?php echo base_url(); ?>admin/fpwindows/delete_subphoto";
        
        $.post(url, {'id': id, 'foldername': foldername, 'imgname': imgname}, function(data){
            if (data == "true"){
                alert('Item Deleted');
                $('#img_'+id).hide('slow');
            } else {
                alert(data);
            }
        });
    }
});
</script>
