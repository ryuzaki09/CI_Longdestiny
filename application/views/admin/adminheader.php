<!DOCTYPE html> 
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/admin.css" />
<link rel="stylesheet" href="/css/jquery.Jcrop.css" type="text/css" />
<link rel="stylesheet" src="/css/jquery-ui-1.10.0.custom.min.css" />
<link rel="stylesheet" href="/js/bootstrap/css/bootstrap.min.css" type="text/css" />

<script src="/js/jquery-1.9.0.min.js"></script>
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

<script type="text/javascript" src="/js/jquery-ui-1.10.0.custom.min.js"></script>

<title><?php echo($title) ?></title>
</head>
<body>
<a name="top"></a>
<div id="container">
	<div id="header">
        	<img src="/media/images/headerpic.jpg" />	
			<br/>
        </div>
