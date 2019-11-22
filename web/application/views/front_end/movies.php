<?php $movie_per_page              =   $this->db->get_where('config' , array('title'=>'movie_per_page'))->row()->value; ?>

<!-- Breadcrumb -->
	<div id="title-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-sm-8 col-xs-12">
					<div class="page-title">
						<h1 class="text-uppercase">Filmy</h1>
					</div>
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 text-right">
					<ul class="breadcrumb">
					    <li>
					    	<a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i>Domů</a>
					    </li>
					    <li class="active">Filmy</li>
					</ul>
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
			<?php if($total_rows > 0){  ?>
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($all_published_videos as $videos) :?>
                            <?php if($videos->is_tvseries == "1"): ?>
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($videos->videos_id,$videos->title_en); ?>" alt="<?php echo $videos->title;?>"> <a href="<?php echo base_url('tv-series/watch/'.$videos->slug.'.html');?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                        <div class="video_quality"><span class="label label-primary"><?php echo $videos->video_quality ?></span></div>
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('tv-series/watch/'.$videos->slug.'.html');?>"><?php echo "<b>".$videos->title."</b>";?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php $time = str_replace("M","m",$videos->runtime); echo $time; ?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $videos->total_view;?>x shlédnuto</span>--> </p>
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
                                        <?php endif; ?> 
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('watch/'.$videos->slug.'.html');?>"><?php echo "<b>".$videos->title."</b>";?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php $time = str_replace("M","m",$videos->runtime); echo $time; ?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $videos->total_view;?>x shlédnuto</span>--> </p>
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



        </div>
<?php if($total_rows > $movie_per_page){ echo $links; } }else{ echo '<center><h3> Opps!! No Movie Found</h3></center>'; } ?>		
								
    </div>
</div>

<!-- Secondary Section -->