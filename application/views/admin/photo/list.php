<div class="content_block go_left">
<div class="page_title"><?php echo $pagetitle; ?></div>
<?php
if (is_array($albums)){
    foreach($albums AS $list){ ?>
        
     <div id="item_<?php echo $list['albumID']; ?>" class="list_div clearfix" style="border-bottom:1px solid #cacaca;">
        <div class="go_left marg_right" style="width:400px;"><?php echo $list['folder_name'] ?></div>        
        <div class="go_left marg_right" style="width:50px;"><a href="javascript:void(0);" onclick="edit('<?php echo $list['albumID']; ?>');">Edit</a></div>
        <div class="go_left marg_right" style="width:100px;"><a href="album/<?php echo $list['albumID']; ?>">View Photos</a></div>
        <div class="go_left marg_right" style="width:50px;"><a href="javascript:void(0);" onclick="delete_item('<?php echo $list['albumID']; ?>','<?php echo $list['folder_name']; ?>');">Delete</a></div>
        <br/>
        <!--- Sub items --->
        <div style="display:none;" class="list_div" id="sub_window_<?php echo $list['albumID']; ?>">
            <div class="clearfix">
                <input type="hidden" id="old_album_name_<?php echo $list['albumID']; ?>" value="<?php echo $list['folder_name']; ?>" />
                <div class="block150 go_left">Title</div>
                <div class="block200 go_left"><input type="text" id="new_album_name_<?php echo $list['albumID']; ?>" value="<?php echo $list['folder_name']; ?>" /></div>
            </div>
            <div class="clearfix">
                <div class="go_left"><input type="button" id="update_title" value="Update" onclick="update_title('<?php echo $list['albumID']; ?>');" /></div>
            </div>
        </div>
     </div>
     
    
<?php } 
    
} ?>
</div>
<script>
function edit(id){
    if($('#sub_window_'+id).is(':visible')){
        $('#sub_window_'+id).slideUp();
    } else{
        $('#sub_window_'+id).slideDown('slow');
    }
}

function update_title(id){
    var old_album_name = $('#old_album_name_'+id).val();
    var new_album_name = $('#new_album_name_'+id).val();
    var url = "/admin/photos/update_album";
    
    $.post(url, {'albumID': id, 'old_album_name': old_album_name, 'new_album_name': new_album_name}, function(data){
       if(data =="true"){
           alert('Updated!');
       } else {
           alert(data);
       }
    });
    
}
    
function delete_item(id, foldername){
    var response = confirm('Delete album and all photos?');
    
    if(response){
        var url = "<?php echo base_url(); ?>admin/photos/delete_album";
        
        $.post(url, {'id': id, 'foldername': foldername}, function(data){
            if(data == "all deleted"){
                alert('All images and album are deleted');
                $('#item_'+id).hide('slow');
            } else if(data == "noimages"){
                alert('Album deleted, there are no images inside to delete');
                $('#item_'+id).hide('slow');
            } else {
                alert(data);
            }
        });
    }
}
</script>