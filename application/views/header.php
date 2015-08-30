<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <title><?php if($title){ echo $title;} else{  base_url(); }  ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="../favicon.ico">
		<meta name="description" content="Longdestiny Developer" />
		<meta name="keywords" content="Longdestiny, html, css, css3, jquery, grid, masonry, fullscreen, destiny, flipboard effect" />
		<meta name="author" content="Longdestiny" />                
                
                <?php
                if (isset($css) && $css){                    
                    foreach($css AS $style => $value){
                        echo $value;
                    }
                }
                if (isset($js) && $js){                    
                    foreach($js AS $script => $key){
                        echo $key;
                    }
                }
                ?>
                <!-- <link rel='stylesheet' type='text/css' href='css/style.css' /> -->
                <!-- <link rel='stylesheet' type='text/css' href='css/twitter.css' /> -->
                <!-- <link rel='stylesheet' type='text/css' href='css/jquery.jscrollpane.css' /> -->
                <!-- <link rel='stylesheet' type='text/css' href='js/twitter/jScrollPane.css' /> -->
                
                <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow&v1' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Ovo' rel='stylesheet' type='text/css' />                
                               
                
                <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script> -->
                <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
                                
                <script type="text/javascript" src="js/twitter/jScrollPane-1.2.3.min.js"></script>                
                <script type="text/javascript" src="/js/twitter/twitter.js"></script>
                
		
		<!-- Fullscreen jQuery template -->
		<script id="fullviewTmpl" type="text/x-jquery-tmpl"> 
			{{html bgimage}}
			<div class="full-view">
				<span class="full-view-exit">Exit full screen view</span>
				<div class="header">
					<h2 class="title">${title}</h2>
					<div class="full-nav">
						<span class="full-nav-prev">Previous</span>
						<span class="full-nav-pages">
							<span class="full-nav-current">${current}</span>/
							<span class="full-nav-total">${total}</span>
						</span>
						<span class="full-nav-next">Next</span>
					</div>
					<p class="subline">${subline}</p>
					<span class="loading-small"></span>
				</div>
				<div class="project-descr-full">
					<div class="thumbs-wrapper"><div class="thumbs">{{html thumbs}}</div></div>
					<div class="project-descr-full-wrapper">
						<div class="project-descr-full-content">{{html description}}</div><!-- project-descr-full-content -->
					</div>
				</div><!-- project-descr-full -->
			</div><!-- full-view -->
		</script>
                
        </head>
	<body>
