<div class="content_block go_left">
<div class="page_title"><?php echo $pagetitle; ?></div>
<?php if (isset($message) && $message){ echo $message; } ?>
<?php
if (isset($result) && $result){ 
    echo form_open_multipart(base_url().'admin/portfolio/edit/'.$result->port_id); ?>    
    <div class="clearfix bottom_space">
        <div class="go_left">
            <input type="hidden" name="old_image" value="<?php echo $result->port_img; ?>" />
            <img src="/media/images/portfolio/<?php echo $result->port_img; ?>" style="max-width:750px; max-height:450px;" />
        </div>
    </div>
    <div class="clearfix bottom_space">
        <div class="go_left">Image: 
            <input type="file" name="image" />
        </div>
    </div>
    <div class="clearfix bottom_space">
        <div class="go_left">Title: 
            <input type="text" name="title" value="<?php echo $result->port_title; ?>" />
        </div>
    </div>
    <div class="clearfix bottom_space">
        <div class="go_left">Link: 
            <input type="text" name="link" value="<?php echo $result->port_link; ?>" />
        </div>
    </div>
    <div class="clearfix bottom_space">
        <div class="go_left">Position: 
            <input type="text" name="position" size="3" value="<?php echo $result->position; ?>" />
        </div>
    </div>
    <div class="clearfix bottom_space">
            <input type="submit" name="update" value="Update" />
    </div>
<?php echo form_close();
 } ?>
</div>