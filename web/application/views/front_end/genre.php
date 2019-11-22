<!-- Breadcrumb -->
	<div id="title-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-sm-8 col-xs-12">
					<div class="page-title">
						<h1 class="text-uppercase">Žánr: <?php echo $genre_name; ?></h1>
					</div>
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 text-right">
					<ul class="breadcrumb">
					    <li>
					    	<a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i>Domů</a>
					    </li>
					    <li class="active">Žánr</li>
					    <li class="active"><?php echo $genre_name; ?></li>
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
        <?php if ($total_rows>0){?>
            <!-- All Movies -->
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($all_published_videos as $videos) :?>
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive"  style="min-width: 165px;"  src="<?php echo $this->common_model->get_video_thumb_url($videos->videos_id); ?>" alt="<?php echo $videos->title;?>"> <a href="<?php if($videos->is_tvseries =='1'){ echo base_url('tv-series/watch/'.$videos->slug.'.html');}else{  echo base_url('watch/'.$videos->slug.'.html');}?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
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

                                        <?php if($videos->de_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/de.png"></span>
                                        <?php endif; ?>

                                        <?php if($videos->cze_sub != NULL): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">    
                                        <?php endif; ?> 
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php if($videos->is_tvseries =='1'){ echo base_url('tv-series/watch/'.$videos->slug.'.html');}else{  echo base_url('watch/'.$videos->slug.'.html');}?>"><?php echo $videos->title;?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $videos->runtime;?></span><span>&nbsp;&#47;</span> </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End All Movies -->

<?php }
else{
	echo "<h2 class='text-center'>V kategorii '".$genre_name."' nejsou žádné filmy. Některé žánry nefungují správně a proto doporučujeme použít vyhledávač.";
	} ?>

        </div>
<?php if($total_rows > 24){
				echo $links;
			}
			?>		
								
    </div>
</div>

<!-- Secondary Section -->