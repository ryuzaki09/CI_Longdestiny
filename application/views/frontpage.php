<div class="container" id="container">
	<div class="item header">
		<h2 style="width:240px;">SIN</h2>
                <h2 style="width:240px;">LUONG</h2>
		<p class="subline">.com</p>
	</div>
	
     <?php if(is_array($data)){            
				foreach($data AS $list){ ?>
                	<div class="item block" data-bgimage="media/images/frontpage/<?php echo $list['image']; ?>">
                    	<div class="thumbs-wrapper">
                        	<div class="thumbs">                                            
                                          <?php                                          
                                            foreach($list_photos AS $photos):
                                                if($photos['windowID'] == $list['id']){ 
													echo "<img src='media/images/frontpage/thumbs/".$photos['imgname']."' />"; 
												}
                                            endforeach; ?>
                            </div>
                        </div>
                        <h2 class="title"><?php echo $list['title']; ?></h2>
                        <p class="subline"><?php echo $list['sub_title']; ?></p>
                        <div class="intro">
							<p><?php echo $list['desc1']; ?>&nbsp;
                            	<?php if($list['title'] =="Photos"){ 
                                		echo '<a href="photos">';                                             
                                      } elseif($list['title']=="Portfolio") {
                                         echo '<a href="portfolio">';
                                      } else {
                                         echo '<a href="#" class="more_link">';
                                      } ?> View More</a></p>
                        </div>
                        <div class="project-descr">
                        	<div style="margin:10px 20px;">
								<p><?php echo nl2br($list['desc2']); ?></p>
                                <?php if($list['title'] =="Contact"){ echo $contact_page; } ?>
                            </div>
                        </div>
                    </div>
                    <?php 
                }//end foreach 
         	} ?>
         
         <div class="item tweetblock twitter_block">		
            <div id="twitter-ticker">
            <!-- Twitter container, hidden by CSS and shown if JS is present -->
                <div id="top-bar">
                <!-- This contains the title and icon -->
                    <div id="twitIcon"><img src="media/images/twitter/twitter_64.png" width="64" height="64" alt="Twitter icon" /></div>
                    <!-- The twitter icon -->
                        <h2 class="tut">My tweets</h2>
                        <!-- Title -->
                </div> 
                <div id="tweet-container">
					<?php
					foreach($twitter AS $tweets):
						$tweets->text = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?&_/]+!', "<a target='_blank' href=\"\\0\">\\0</a>",$tweets->text);
						// $tweets->text = str_replace("http".$link, "<a href='http".$link."'>".$link."</a>", $tweets->tweet);
						echo "<li class='tweet-text'>";
						if($tweets->in_reply_to_screen_name){
							$reply_name = $tweets->in_reply_to_screen_name;
							echo str_replace("@$reply_name", "<a href='http://twitter.com/".$reply_name."' target='_blank'>@".$reply_name."</a>", $tweets->text);
						} elseif($tweets->retweeted_status->user->screen_name) {
							$reply_name = $tweets->retweeted_status->user->screen_name;
							echo str_replace("@$reply_name", "<a href='http://twitter.com/".$reply_name."' target='_blank'>@".$reply_name."</a>", $tweets->text);

						} else {
							echo $tweets->text;
						}
						echo "</li>";	
					endforeach;
					?>
				</div>
                <!-- The loading gif animation - hidden once the tweets are loaded -->
                <div id="scroll"></div>
                <!-- Container for the tweets -->
            </div>
		</div>    
        
        <!--<div class="item followblock" style="margin:5px; background-color:#9BC4E2; float:left; padding:20px; width:260px; height:370px;">
            <div>
                Follow Me
            </div>
	</div>-->			
	       
        
     <div class="clr">&nbsp;</div>
</div><!-- container -->

<footer class="reference clearfix" style="padding:5px; color:#fff;">
      <div style="float:left; margin:0 25px 0 10px;">SINLUONG.COM</div>
      <div style="float:right; margin-right:10px;">
          <div class="go_left" style="margin-right:15px;">Follow Me</div>
          <div class="go_left">
              <a href="https://twitter.com/ryuzaki09" target="_blank" data-show-count="false">
                  <img src="/media/images/followtwitter.png" style="width:25px; height:25px;" />
              </a>
              <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>          
          </div>
          <div class="go_left">
              <a href="https://plus.google.com/100822101722411523882?prsrc=3" rel="publisher" target="_blank" style="text-decoration:none;">
                <img src="/media/images/followgoogle+.png" style="width:25px; height:25px;" />
              </a>
          </div>
      </div>
	
</footer>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/jquery.gpCarousel.js"></script>
<script type="text/javascript">
    

    $(window).load(function(){
	// the main container
	var $GPContainer	= $('#container'),
	// the articles (the thumbs)
	$articles		= $GPContainer.children('div.block'),
	// total number of articles
	totalArticles	= $articles.length,
	// the fullview container
	$fullview		= $('<div id="fullview" class="full-view-elements"></div>').prependTo( $('body') ),
	// the overlay
	$overlay		= $('<div class="overlay"></div>').prependTo( $('body') ),
				
	GridPortfolio	= (function() {
            // current will be the index of the current article
            var animspeed				= 500,
            animeasing				= 'jswing', // try easeOutExpo
            current					= -1,
            // indicates if certain elements can be animated or not at a given time
            animrun					= false,
            init 					= function() {
            initPlugins();
            initEventsHandler();
            },
		// builds each article's carousel
                // initiallizes the mansory
		initPlugins				= function() {
		// apply carousel functionality to the thumbs-wrapper in each article
		$articles.find('div.thumbs-wrapper').gpCarousel();
					
		// apply mansory to the grid items
		$GPContainer.masonry({
			itemSelector	: '.item',
			columnWidth		: 5,
			isAnimated		: true
		});
                },
		// events
		initEventsHandler		= function() {
		// switch to fullview when we click the "View Project" link
		$articles.each( function(i) {
			$(this).find('a.more_link').bind('click.GridPortfolio', function(e) {
								
				if( animrun ) return false;
				animrun			= true;
										
				var $article	= $(this).closest('div.block');
				// update the current value
				current	= $article.index('.block');
				// hide scrollbar
				$('body').css( 'overflow', 'hidden' );
				// preload the fullview image and then start the animation (showArticle)
				var $intro		= $article.find('div.intro');
				$intro.addClass('intro-loading');
				$('<img/>').load(function() {
					$intro.removeClass('intro-loading');
					showArticle( $article, true );
					animrun	= false;
				}).attr('src', $article.data('bgimage'));
										
				return false;
                        });
		});
								
		// fullview navigation
		$('#fullview').find('span.full-nav-next').live('click.GridPortfolio', function(e) {
				if( animrun ) return false;
                        		animrun	= true;
									
					// circular navigation
					if( current === totalArticles - 1 )
						current = 0
						else
						++current;
						// update the fullview current articles number	
						$fullview.find('span.full-nav-current').html( current + 1 );
									
						showFullviewArticle();
		});
		$('#fullview').find('span.full-nav-prev').live('click.GridPortfolio', function(e) {
				if( animrun ) return false;
					animrun	= true;
									
					// circular navigation
					if( current === 0 )
						current = totalArticles - 1
							else	
							--current;
							// update the fullview current articles number	
							$fullview.find('span.full-nav-current').html( current + 1 );
									
								showFullviewArticle();
		});
								
		// switch to thumbs view
		$('#fullview').find('span.full-view-exit').live('click.GridPortfolio', function(e) {
				var $article	= $articles.eq( current );
					hideArticle( $article );
		});

		// window resize 
		// center the background image if in fullview
		// reinitialise jscrollpane
		$(window).bind('resize.GridPortfolio', function(e) {
				var $bgimage	= $fullview.find('img.bg-img');
					if( $bgimage.length )
						centerBgImage( $bgimage );
										
						$fullview.find('div.project-descr-full-wrapper').jScrollPane('reinitialise');
		});
	},
	// the clicked article will be cloned;
	// the clone will be positioned on top of the cloned article;
	// remove every element from the clone except the thumbs wrapper (basically the image);
	// enlarge the clone to the window's width & height;
	// move the thumbs wrapper to the position where the fullview's thumbs wrapper will be placed;
	// at the same time fade in the overlay;
	// build the fullview panel with the right data (template)
	// remove the clone
							
	// this function will also be used when we close the fullview article. In this case,
	// the difference is that we don't animate the values (just set the css values), and the clone is not removed, since we
	// will use it for the animation (back to the thumb position)
	showArticle				= function( $article, anim ) {
			// clone the article
			var	$clone	= $article.clone().css({
				left	: $article.offset().left + 'px',
				top		: $article.offset().top + 'px',
				zIndex	: 1001,
				margin	: '0px',
				height	: $article.height() + 'px'
                        }).attr( 'id', 'article-clone' );
								
			// this is the images container which is going to "fly" down
			var $thumbsWrapper	= $clone.find('div.thumbs-wrapper');
								
			// remove unnecessary elements from the clone
			$clone.children().not($thumbsWrapper).remove();
			$clone.find('div.thumbs-nav').remove();
								
			// position the clone on top of the article with the right css style
			var padding	= 20 + 20;
			// animate?
			$.fn.applyStyle = ( anim ) ? $.fn.animate : $.fn.css;
								
			var clonestyle 	= {
				width	: $(window).width() - padding + 'px',
				height	: $(window).height() - padding + 'px',
				left	: '0px',
				top		: $(window).scrollTop() + 'px'
			};
								
			$clone.appendTo( $('body') ).stop().applyStyle( clonestyle, $.extend( true, [], { duration : animspeed, easing : animeasing, complete : function() {
				// show the panel (it will be hidden behing the clone though, until this one is removed)
				$fullview.show()
									
				// use the template "fullviewTmpl" to build the fullview panel with the right data
				var articleFullviewData		= getArticleFullviewData($article);
				articleFullviewData.current	= current + 1;
				articleFullviewData.total	= totalArticles;
				var $fullview_content	= $('#fullviewTmpl').tmpl( articleFullviewData );
									
				$fullview_content.appendTo( $fullview );
									
				// call the gpCarousel plugin on the fullview thumbs-wrapper
				$fullview_content.find('div.thumbs-wrapper').gpCarousel({
                                    start	: $article.find('div.thumbs-wrapper').data('currentImage')
                                });
									
				//jscrollpane
				$fullview_content.find('div.project-descr-full-wrapper').jScrollPane('destroy').jScrollPane({
					verticalDragMinHeight: 40,
					verticalDragMaxHeight: 40
				});
									
				// center bg image
				centerBgImage( $fullview.find('img.bg-img') );
									
				// fade out overlay
				$overlay.stop().css( 'opacity', 0 );
									
				// fade out clone to show the fullview panel. After that remove the clone
				$clone.fadeOut( 300, function() { $clone.remove(); } );
			}}));
								
			// animate the images container to the position where is going to be on fullview
			var thumbsstyle 	= {
				right	: $(window).width() - $thumbsWrapper.width() - 1255 + 'px',  // 25 is the margin left / right of the fullview thumbs-wrapper
				top		: ($(window).height() / 2) - ($thumbsWrapper.height() / 2) - 125 + 'px' // 10 is the margin top / bottom of the fullview thumbs-wrapper
			};
			$thumbsWrapper.stop().applyStyle( thumbsstyle, $.extend( true, [], { duration : animspeed, easing : animeasing} ) );
								
			// fade in overlay
			( anim ) ? $overlay.show().fadeTo( animspeed, 0.7, animeasing ) : $overlay.show().css( 'opacity', 0.7 );
		},
		// close the fullview
		hideArticle				= function( $article ) {
                    // create the article's clone. the second argument is false to prevent the clone to be removed
                    showArticle( $article, false );
                    // hide the overlay for now
                    $overlay.hide();
                    // reference to the created clone and its thumbs wrapper
                    var $clone			= $('#article-clone'),
                    $thumbsWrapper	= $clone.find('div.thumbs-wrapper');
                    // fade in the clone
                    $clone.hide().fadeIn( 200, function() {
                        // remove the contents of the fullview container
			$fullview.empty();
			// animate the clone to the article position and size
			$(this).animate({
				left	: $article.offset().left + 'px',
				top		: $article.offset().top + 'px',
				//width	: $article.width() + 'px',
				width	: '260px',
				height	: $article.height() + 'px'
			}, animspeed, animeasing, function() {
				// remove the clone
				$clone.remove();
				// show the scrollbar
				$('body').css( 'overflow', 'visible' );
			});
									
			// animate the clone's thumbs wrapper so it moves to the article's thumbs wrapper position
			$thumbsWrapper.animate({
				left	: '0px',
				top		: '0px'
			}, animspeed, animeasing);
									
			// fade out the overlay
				$overlay.show().fadeTo( animspeed, 0, animeasing, function() { $overlay.hide() } );
                    });
		},
		// gets the article's necessary info to build the fullview panel
                    getArticleFullviewData	= function( $article ) {
				return {
					bgimage			: '<img src="' + $article.data('bgimage') + '" class="bg-img"></img>',
					title 			: $article.find('h2.title').text(),
					thumbs			: $article.find('div.thumbs').html(),
					subline			: $article.find('p.subline').text(),
					description		: $article.find('div.project-descr').html()
				}
		},
		// used when navigating in fullview
		// needs to get the next / previous article's info
		showFullviewArticle		= function() {
				var $article					= $articles.eq( current ),
				articleFullviewData			= getArticleFullviewData($article),
					
				$loading					= $fullview.find('span.loading-small'),
								
				$fullviewImage				= $fullview.find('img.bg-img'),
								
				$fullviewTitle				= $fullview.find('h2.title'),
									
				$fullviewSubline			= $fullview.find('p.subline'),
									
				$fullviewDescriptionWrapper	= $fullview.find('div.project-descr-full-wrapper'),
				$fullviewDescription		= $fullviewDescriptionWrapper.find('div.project-descr-full-content'),
									
				$fullviewProjectDescrFull	= $fullview.find('div.project-descr-full'),
				$fullviewThumbsWrapper		= $fullviewProjectDescrFull.find('div.thumbs-wrapper'),
				$newFullviewThumbsWrapper	= $('<div class="thumbs-wrapper"><div class="thumbs">' + articleFullviewData.thumbs + '</div></div>');
								
								// preload the article's background image
								$loading.show();
								$( articleFullviewData.bgimage ).load(function() {
									$loading.hide();
									var $bgImage	= $(this);
									$bgImage.insertBefore( $fullviewImage );
									// center the bg image
									centerBgImage( $bgImage );
									$fullviewImage.remove(); 
									
									$fullviewTitle.html( articleFullviewData.title );
									
									$fullviewSubline.html( articleFullviewData.subline );
									
									$fullviewDescriptionWrapper.jScrollPane('destroy');
									$fullviewDescription.html( articleFullviewData.description );
									$fullviewDescriptionWrapper.jScrollPane('destroy').jScrollPane({
										verticalDragMinHeight: 40,
										verticalDragMaxHeight: 40
									});
									
									$fullviewThumbsWrapper.remove();
									$fullviewProjectDescrFull.prepend( $newFullviewThumbsWrapper );	
									$newFullviewThumbsWrapper.gpCarousel();
									
									animrun	= false;
								}).attr('src', $article.data('bgimage'));
								
							},
							// centers the background image
							centerBgImage			= function( $img ) {
								var dim	= getImageDim($img);
								//set the returned values and show the image
								$img.css({
									width	: dim.width + 'px',
									//width	: '260px',
									height	: dim.height + 'px',
									left	: dim.left + 'px',
									top		: dim.top + 'px'
								});
							},
							//get dimentions of the image,
							//in order to make it full size and centered
							getImageDim				= function($i) {
								var $img     = new Image();
								$img.src     = $i.attr('src');
										
								var w_w	= $(window).width(),
								w_h	= $(window).height(),
								r_w	= w_h / w_w,
								i_w	= $img.width,
								i_h	= $img.height,
								r_i	= i_h / i_w,
								new_w,new_h,
								new_left,new_top;
										
								if(r_w > r_i){
									new_h	= w_h;
									new_w	= w_h / r_i;
								}
								else{
									new_h	= w_w * r_i;
									new_w	= w_w;
								}
										
								return {
									width	: new_w,
									height	: new_h,
									left	: (w_w - new_w) / 2,
									top		: (w_h - new_h) / 2
								};
										
							};
						
						return {
							init	: init
						};
						
					})()
				
				GridPortfolio.init();
				
			});
</script>
