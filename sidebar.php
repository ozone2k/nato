		<div class="span-6 last" id="side-menu">
            <p class="tagline">Building <strong>websites</strong> and <strong>web applications</strong> from conception to <span class="fruitionTxt">fruition</span>.</p>
            
        	<div class="span-6 last asidesTop">
            	<div class="asidesContent">
                	<p id="socialme"> <a href="https://www.facebook.com/ozone2k" class="social fb" target="_blank"> </a> <a href="https://plus.google.com/109932418129975495808/about" class="social gp"> </a> <a href="http://www.linkedin.com/pub/renato-parente/33/64a/872" class="social in"> </a> <a href="http://twitter.com/ozone2k" class="social tw"> </a> </p>
                </div>
            </div>
            
            <div class="span-6 last asidesMiddle">
                <ul class="nav">
                    <?php wp_list_pages('&title_li='); ?>
					<?php wp_list_categories('exclude=4,7&title_li='); ?>
                </ul>
            </div>
            
            <div class="span-6 last asidesBottom">
				<div class="asidesContent">
                <p class="prepend-top filterByTagTitle">Filter Projects by Tag:</p>
					<?php
                        $tags = get_tags('hide_empty=false&orderby=count');
                        $html = '<div class="post_tags">';
                        $tagsI = 0;
                        foreach ($tags as $tag){
                            $tag_link = get_tag_link($tag->term_id);
                                    
                            $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
                            $html .= "{$tag->name}</a>({$tag->count})";
                            $tagsI ++;
                            if($tagsI < count($tags)){
                                $html .=", ";
                            }
                        }
                        $html .= '</div>';
                        echo $html;
                    ?>
                </div>
            </div>
         </div>