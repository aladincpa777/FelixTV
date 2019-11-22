<?php $q = $_POST['search']; ?>
<?php $s = $_GET['search']; ?>
<?php
$string = file_get_contents("http://tv.sosac.to/jsonsearchapi.php?q=".$q);
$json_a = json_decode($string, true);

$SEARCH_LIST_MOVIE_NAME = "";
$SEARCH_LIST_MOVIE_L = "";

foreach ($json_a as $person_name => $person_a) {
    $SEARCH_LIST_MOVIE_NAME = $person_a['cs'];
}
?>
<!-- Breadcrumb -->
	<div id="title-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="page-title">
						<h1 class="text-uppercase"><?php echo '"'.$q.'" vyhledané výsledky'; ?></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumb -->
	
	<!-- Secondary Section -->
<div id="section-opt">
    <div class="container">
        <div class="row">
            <!-- All Movies -->
			<?php if($total_rows>0){
				if($total_rows > 24){
				echo $links;
			}
			?>
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <!-- <h1><?php echo $json_a[0]['y']; ?></h1>
                            <h1><?php echo $SEARCH_LIST_MOVIE_NAME; ?></h1><br /><br />
                            <h1><?php echo $SEARCH_LIST_MOVIE_L; ?></h1> -->
                            <?php foreach ($all_published_videos as $videos) :?>
                                  <?php if($videos->is_tvseries == "1"): ?>
                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                        <div class="latest-movie-img-container">
                                            <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($videos->videos_id,$videos->title_en); ?>" alt="<?php echo $videos->title;?>"> <a href="<?php echo base_url('tv-series/watch/'.$videos->slug.'.html');?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                                <div class="overlay-div"></div>
                                                   <div class="video_quality"><span class="label label-primary"><?php echo $videos->release ?></span></div>
                                                <?php if($videos->video_quality == "HD"): ?>
                                                    <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                                     <?php else: ?>
                                                        <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                                    <?php endif; ?>

                                                     <?php if($videos->cze_lang != NULL): ?>
                                                        <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                                    <?php endif; ?>

                                                    <?php if($videos->cze_sub != NULL): ?>
                                                    <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                                    <img src="<?php echo base_url();?>assets/front_end/images/en.png">  
                                                <?php endif; ?> 
                                            </div>
                                            <div class="movie-title">
                                                <h1><a href="<?php echo base_url('tv-series/watch/'.$videos->slug.'.html');?>"><?php echo $videos->title;?></a></h1>
                                                <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $videos->runtime;?></span><!-- <span>&nbsp;&#47;</span> <span><?php echo $videos->total_view;?>x shlédnuto</span>--> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                         <div class="col-md-2 col-sm-3 col-xs-4">
                                        <div class="latest-movie-img-container">
                                            <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($videos->videos_id,$videos->title_en); ?>" alt="<?php echo $videos->title;?>"> <a href="<?php echo base_url('watch/'.$videos->slug.'.html');?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                                <div class="overlay-div"></div>
                                                   <div class="video_quality"><span class="label label-primary"><?php echo $videos->release ?></span></div>
                                                  <?php if($videos->video_quality == "HD"): ?>
                                                    <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                                     <?php else: ?>
                                                        <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                                    <?php endif; ?>

                                                     <?php if($videos->cze_lang != NULL): ?>
                                                        <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                                    <?php endif; ?>

                                                    <?php if($videos->cze_sub != NULL): ?>
                                                    <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                                    <img src="<?php echo base_url();?>assets/front_end/images/en.png">  
                                                <?php endif; ?> 
                                            </div>
                                            <div class="movie-title">
                                                <h1><a href="<?php echo base_url('watch/'.$videos->slug.'.html');?>"><?php echo $videos->title;?></a></h1>
                                                <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $videos->runtime;?></span><!-- <span>&nbsp;&#47;</span> <span><?php echo $videos->total_view;?>x shlédnuto</span>--> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?> 
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End All Movies -->
            <?php }else{
            	echo '<h4>Nic podobného jako "'.$search_keyword.'" jsme bohužel nenašli :(</h4>';
            	} ?>



        </div>
<?php if($total_rows > 24){
				echo $links;
			}
			?>		
								
    </div>
</div>

<!-- Secondary Section -->