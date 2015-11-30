<!-- <div class="content_block go_left"> -->
    <div class='page_title'><?php echo $pagetitle; ?></div>
<?php
if (is_array($listing)){
    foreach($listing AS $list){ ?>
        
     <div id="item_<?php echo $list['id']; ?>" class="list_div clearfix" style="border-top:1px solid #cacaca;">
        <div class="go_left marg_right" style="width:430px;"><?php echo $list['title'] ?></div>
        <div class="go_left marg_right" style="width:150px;"><a href="subphotos/<?php echo $list['id']; ?>">Upload Sub Photos</a></div>
        <div class="go_left marg_right" style="width:50px;"><a href="edit/<?php echo $list['id']; ?>">Edit</a></div>
        <div class="go_left marg_right" style="width:50px;"><a href="javascript:void(0);" onclick="delete_item('<?php echo $list['id']; ?>');">Delete</a></div>
     </div>
     
    
<?php } 
    
} ?>
<script>
function delete_item(id){
    var response = confirm('Delete Item?');
    
    if(response){
        var url = "<?php echo base_url(); ?>admin/fpwindows/delete_window";
        
        $.post(url, {id: id}, function(data){
            if(data == "true"){
                alert('Item Deleted');
                $('#item_'+id).hide('slow');
            } else{
                alert(data);
            }
        });
    }
}
</script>
