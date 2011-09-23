			<?php //GET ALL EXCEPT thumbnail
					$args = array(
					'order'          => 'ASC',
					'orderby'        => 'menu_order',
					'post_type'      => 'attachment',
					'post_parent'    => $post->ID,
					'post_mime_type' => 'image',
					'post_status'    => null,
					'exclude'        => get_post_thumbnail_id()
					);
					$attachments = get_posts($args);
			?>
            
            <div class=" span-13">
				<?php 
					//if ($attachments) {
					//	foreach ($attachments as $attachment) {
					//		echo wp_get_attachment_link($attachment->ID, 'large', false, false);
					//	}
					//} 
					//echo wp_get_attachment_link($attachments[0]->ID, 'large', false, false);
				?>
                
                <?php 
					if ($attachments) {
							$image_full = wp_get_attachment_image_src( $attachments[0]->ID, 'full' );
							$image_large = wp_get_attachment_image_src( $attachments[0]->ID, 'large' );
							echo "<a href='". $image_full[0] ."' class='largeImg'>" . "<img src='" . $image_large[0] . "'></a>";
					} 
				?>
                
                
                
                <!--<p class="comment-link"><?php comments_popup_link('', '1 Comment &#187;', '% Comments &#187;'); ?></p>-->
            </div>
        	
            <div class=" span-3">
            	<?php 
					if ($attachments) {
						foreach ($attachments as $key=>$attachment) {
							$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'large' );
							echo "<a href='". $image_attributes[0]."'";
							echo "class='thumbs ";
							if($key ==0){
								echo "sel";
							}
							echo "'>" . wp_get_attachment_image($attachment->ID, 'thumbnail') . "</a>";
						}
					} 
				?>
            </div>
        	<div id="postDescr" class="prepend-1 span-7 last">
                <p>
				<?php
				$url = wp_get_referer();
				$path_parts = pathinfo($url);
				if ($path_parts['dirname'] == 'http:'){
					echo '<a href="/" class="backHistoryBt">Back to Home</a>', "\n";
					
				}else{
					echo '<a href="'.$url.'" class="backHistoryBt">Back to '. ucfirst($path_parts['filename']) . '</a>', "\n";
				}
				?>
                </p>
                
                <h1 class="postTitle"><?php the_title(); ?></h2>

               <p><a href="<?php echo get_post_meta($post->ID, 'siteURL', true); ?>" target="_blank" class="links">Launch Site</a></p>
	
    			<?php the_content(); ?>
               
                
                
                
                <?php
                /*
                $thePostTags = get_the_tags();
                $thePostIns = '';
                $thePostTagsI = 0;
                foreach ($thePostTags as $tag){
                    $thePostIns .= "{$tag->name}";
                    $thePostTagsI ++;
                    if($thePostTagsI < count($thePostTags)){
                        $thePostIns .=", ";
                    }
                }
                echo "<p class='postTagsSingle'>" . $thePostIns . "</p>";
                
				*/
                ?>
                <?php the_tags('<h3>Technology Used:</h3><ul class="tagList"><li>','</li><li>','</li></ul>'); ?>
            </div>
            
            