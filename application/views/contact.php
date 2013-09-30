<form method="POST" action="#" id="contactform">                                            
    <div class="clearfix bottom_space">
        <div class="go_left" style="width: 110px; margin-right:25px;"><label for="name">Name:  <font size="1">(required)</font></label></div>
        <div class="go_left" style="width: 205px;"><input type="text" class="blueborder" name="name" id="name" maxlength="30" size="30" /></div>&nbsp;&nbsp;<span class="error"><?php echo($message1); ?></span>
    </div>
    <div class="clearfix bottom_space">  
        <div class="go_left" style="width:110px; margin-right:25px;"><label for="email">Email:  <font size="1">(required)</font></label></div>
        <div class="go_left" style="width:205px;"><input type="text" class="blueborder" name="email" id="email" size="30" /></div>&nbsp;&nbsp;<span class="error"><?php echo($message2); ?></span>
    </div>
    <div class="clearfix bottom_space">
        <div class="go_left" style="width:110px; margin-right:25px;"><label for="website">Website: <font size="1">(Optional)</font> </label></div>
        <div class="go_left" style="width:205px;"><input type="text" class="blueborder" name="website" id="website" size="30" /></div>
    </div>
    <div class="clearfix bottom_space">
        <div class="go_left" style="width:110px; margin-right:25px;"><label for="message">Message:  <font size="1">(required)</font></label></div>
        <div class="go_left" style="width:205px;"><textarea style="padding:5px;" class="blueborder" name="message" id="message" rows="5" cols="30"></textarea></div>&nbsp;&nbsp;<span class="error"><?php echo($message3); ?></span>
    </div>
    <div class="clearfix bottom_space">
        <div style="float:left; width: 220px;"><input type="checkbox" name="copy" id="copy" style="width:15px;" value="mailcopy" />&nbsp;<label for="copy">Send me a copy</label></div>                              
    </div>
    <div class="clearfix bottom_space">
        <div style="float:left; width: 205px;"><input type="button" id="send" value="send" name="send" /></div>
        <div style="float:left; width: 205px;"><input type="hidden" id="reset_form" value="Reset Form" onclick="this.form.reset();"></div>
    </div>
</form>

<script>
$('#send').click(function(){    
    var name = $('#name').val();
    var email = $('#email').val();
    var website = $('#website').val();
    var msg = $('#message').val();
    if($('#copy:checked').val() == "mailcopy"){
        var copy = $('#copy').val();
    } else {
        var copy = "";
    }
    
    if (name =="" || email =="" || msg==""){
        alert('Please enter the required fields');
    } else {
        var url = "frontpage/contact_msg";
        
        $.post(url, {'name': name, 'email': email, 'website': website, 'msg': msg, 'copy': copy}, function(data){
           if (data == "true"){
               alert('Message sent!');
               $('#reset_form').click();
               
           } else {
               //alert('Cannot send');
           alert(data);
	   }
        });
    }

});
    
</script>
