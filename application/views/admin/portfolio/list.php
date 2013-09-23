<div class="content_block go_left">
<div class="page_title"><?php echo $pagetitle; ?></div>
<?php
if (is_array($result) && !empty($result)){
    foreach($result AS $output){ ?>
    <div id="portfolio_<?php echo $output['port_id']; ?>" class="clearfix bottom_space">
        <div class="go_left" style="width:250px; margin-right:15px; ">
            <img src="/media/images/portfolio/<?php echo $output['port_img']; ?>" style="max-width:250px; max-height:150px;" />
        </div>
        <div class="go_left">Title: <?php echo $output['port_title']; ?></div><br/>        
        <div class="go_left">Link: <a href="http://<?php echo $output['port_link']; ?>" target="_blank"><?php echo $output['port_link']; ?></a></div><br/>
        <div class="go_left">Position: <?php echo $output['position']; ?></div><br/><br/>
        <a href="/admin/portfolio/edit/<?php echo $output['port_id']; ?>">Edit</a><br/>
        <a href="javascript:void(0);" onclick="delete_port('<?php echo $output['port_id']; ?>','<?php echo $output['port_img']; ?>');">Delete</a>
    </div>
<?php }
}


?>
</div>
<script>
function delete_port(id, old_img){
    var response = confirm('Are you sure you want to delete?');
    
    if(response){
        var url = "<?php echo base_url(); ?>admin/portfolio/delete_portfolio";

        $.post(url, {'id': id, 'old_img': old_img}, function(data){
            if(data =="true"){
                alert('Deleted!');
                $('#portfolio_'+id).hide();
            } else {
                alert(data);
            }

        });
    }
    
}
</script>