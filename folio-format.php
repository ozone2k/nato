			<?php    
				$imageArray = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full');
			    $imageURL = $imageArray[0]; // here's the image url
			?>
            <div class="project" style="background-image:url(<?php echo $imageURL ?>);">
				<div class="descr">
					<?php if(get_post_meta($post->ID, 'url', true)) { ?>
					<h2><a href="<?php echo get_post_meta($post->ID, 'url', true); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<?php } else { ?>
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<?php } ?>
                    <div class="excerpt">
                    	<?php the_excerpt(); ?> 
                    </div>
                    <p><a href="<?php the_permalink(); ?>" class="links">Read More</a>  <a href="<?php echo get_post_meta($post->ID, 'siteURL', true); ?>" target="_blank" class="links">Launch Site</a></p>
                    
					<?php
					
					$thePostTags = get_the_tags();
					$thePostIns = '<p class="tagslist">';
					$thePostTagsI = 0;
					foreach ($thePostTags as $tag){
						$thePostIns .= "{$tag->name}";
						$thePostTagsI ++;
						if($thePostTagsI < count($thePostTags)){
							$thePostIns .=", ";
						}
					}
					$thePostIns .= '</p>';
					echo $thePostIns;
                    
                    ?>
                    <!--<p class="comment-link"><?php comments_popup_link('', '1 Comment &#187;', '% Comments &#187;'); ?></p>-->
                </div>
            </div>
            
            <!--<div class="post clear" id="post-<?php the_ID(); ?>">
				<div class="thumbnail">
					<?php the_content(); ?>
				</div>
				<div class="entry">
					
					
					<?php echo get_post_meta($post->ID, 'description', true); ?>
				</div>
			</div>-->