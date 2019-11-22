<!-- Secondary Section -->
<div id="section-opt">
    <div class="container">
        <div class="row">
            <!-- Upcomming Movies -->
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="movie-heading overflow-hidden"> <span>Nové filmy</span>
                        <div class="disable-bottom-line"></div>
						<a href="<?php echo base_url();?>movies.html" class="btn btn-success btn-sm pull-right">Více<i class="fa fa-angle-double-right m-l-10" aria-hidden="true"></i></a>
                    </div>
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($new_videos as $new_video) :?>
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($new_video->videos_id); ?>" alt="<?php echo $new_video->title;?>"> <a href="<?php echo base_url('watch/'.$new_video->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                         <div class="video_quality"><span class="label label-primary"><?php echo $new_video->release ?></span></div> 
                                        <?php if($new_video->video_quality == "HD"): ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                        <?php else: ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                        <?php endif; ?>

                                         <?php if($new_video->cze_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                        <?php endif; ?>

                                        <?php if($new_video->de_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/de.png"></span>
                                        <?php endif; ?>

                                        <?php if($new_video->cze_sub != NULL): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">    
                                        <?php endif; ?> 
                                       
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('watch/'.$new_video->slug).'.html';?>"><?php echo $new_video->title;?> <!-- (<?php echo $new_video->release; ?>)--></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $new_video->runtime;?></span><!--<span>&nbsp;&#47;</span>  <span><?php echo $new_video->total_view;?>x shlédnuto</span>--> </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Upcomming Movies -->
            <!-- Latest Movies -->

            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="movie-heading overflow-hidden"> <span>Nejvíce sledované</span>
                        <div class="disable-bottom-line"></div>
						<a href="<?php echo base_url();?>movies.html" class="btn btn-success btn-sm pull-right">Více<i class="fa fa-angle-double-right m-l-10" aria-hidden="true"></i></a>
                    </div>
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($latest_videos as $latest_video) :?>
                            <?php if($latest_video->is_tvseries == "1"): ?>
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($latest_video->videos_id); ?>" alt="<?php echo $latest_video->title;?>"> <a href="<?php echo base_url('tv-series/watch/'.$latest_video->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                        <div class="video_quality"><span class="label label-primary"><?php echo $latest_video->release ?></span></div> 
                                        <?php if($new_video->video_quality == "HD"): ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                        <?php else: ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                        <?php endif; ?>

                                         <?php if($latest_video->cze_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                        <?php endif; ?>

                                        <?php if($latest_video->de_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/de.png"></span>
                                        <?php endif; ?>

                                        <?php if($latest_video->cze_sub != NULL): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">    
                                        <?php endif; ?> 
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('tv-series/watch/'.$latest_video->slug).'.html';?>"><?php echo $latest_video->title;?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $latest_video->runtime;?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $latest_video->total_view;?>x shlédnuto</span>--> </p>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($latest_video->videos_id); ?>" alt="<?php echo $latest_video->title;?>"> <a href="<?php echo base_url('watch/'.$latest_video->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                         <div class="video_quality"><span class="label label-primary"><?php echo $latest_video->release ?></span></div>
                                        <?php if($latest_video->video_quality == "HD"): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                        <?php else: ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                        <?php endif; ?>

                                         <?php if($latest_video->cze_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                        <?php endif; ?>

                                        <?php if($latest_video->de_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/de.png"></span>
                                        <?php endif; ?>

                                        <?php if($latest_video->cze_sub != NULL): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">    
                                        <?php endif; ?> 
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('watch/'.$latest_video->slug).'.html';?>"><?php echo $latest_video->title;?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $latest_video->runtime;?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $latest_video->total_view;?>x shlédnuto</span>--> </p>
                                    </div>
                                </div>
                            </div>

                            <?php endif; ?> 
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Latest Movies -->

           



        </div>
    </div>
</div>

<!-- Secondary Section -->
