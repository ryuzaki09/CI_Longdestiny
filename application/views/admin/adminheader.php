<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin.css" />
<link rel="stylesheet" href="/css/jquery.Jcrop.css" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php 
if(isset($css) && $css){
    foreach($css AS $style){
        echo $style;
    }
};

if(isset($js) && $js){
    foreach($js AS $script){
        echo $script;
    }
};

?>

<script type="text/javascript" src="/js/jquery-ui-1.8.18.custom.min.js"></script>

<title><?php echo($title) ?></title>
</head>
<body>
<a name="top"></a>
<div id="container">
	<div id="header">
        	<img src="<?php echo base_url(); ?>media/images/headerpic.jpg" />	
			<br/>
        </div>