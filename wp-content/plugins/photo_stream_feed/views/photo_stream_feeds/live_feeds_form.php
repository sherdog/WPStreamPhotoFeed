<?php
$html = new WP_Html_Helper();
?>


<div class="wrap">
<h2>Connect</h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
			
			
                <div class="contaienr">
                	<div class="row">
                		<form method="post" name="post_live_feed" method="post" action="<?php echo plugins_url( 'photo_stream_feeds_form.php', __FILE__ ); ?>">
						
    						<?php 
    						
    						$html->print_text_field('ur', "URL", 'url', 'http://website.com', $live_feed->url);
    						$html->print_text_field('title', 'Title', 'title', '', $live_feed->title);
    						$html->print_text_field('hashtags', 'Hashtags', 'hashtags', '', $live_feed->hashtags);
    						$html->print_text_field('city', 'City', 'city', '', $live_feed->city);
    						$html->print_text_field('state', 'State', 'state', '', $live_feed->state);
    						$html->print_text_field('zip', 'Zipcode', 'zipcode', '', $live_feed->zip);
    						$html->print_dropdown("Platform", "platform", "platform", $platforms, $live_feed->platform);
    						$html->print_dropdown("Streamer", "streamer", "streamer", $streamers, $live_feed->streamer_id);
    						$html->print_text_field('streamer_name', 'Streamer Name', 'streamer_name', '','');
    						
                            ?>
                            						
    						<input  type="submit" value="Save" />
    					</form>
                	</div>
                </div>
                
                

			</div>
		</div>
		<br class="clear">
	</div>
</div>









