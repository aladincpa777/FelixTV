<!-- Breadcrumb -->
	<div id="title-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-sm-8 col-xs-12">
					<div class="page-title">
						<h1 class="text-uppercase">Žánr: <?php echo $type_name; ?></h1>
					</div>
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 text-right">
					<ul class="breadcrumb">
					    <li>
					    	<a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i>Domů</a>
					    </li>
					    <li class="active">Žánr</li>
					    <li class="active"><?php echo $type_name; ?></li>
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
                                    <div class="movie-img"> <img class="img-responsive"  style="min-width: 165px;"  src="<?php echo $this->common_model->get_video_thumb_url($videos->videos_id); ?>" alt="<?php echo $videos->title;?>"> <a href="<?php echo base_url('watch/'.$videos->slug.'.html');?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                        <div class="video_quality"><span class="label label-primary"><?php echo $videos->video_quality ?></span></div>
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('watch/'.$videos->slug.'.html');?>"><?php echo $videos->title;?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $videos->runtime;?></span><span>&nbsp;&#47;</span> <span><?php echo $videos->total_view;?> views</span> </p>
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
	echo "<h2 class='text-center text-capitalize'>Zde bohužel nejsou žádné ".$type_name." Filmy :(";
	} ?>

        </div>
<?php if($total_rows > 24){
				echo $links;
			}
			?>		
								
    </div>
</div>

<!-- Secondary Section -->