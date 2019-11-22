<?php
$preJSON_ID = file_get_contents("https://api.themoviedb.org/3/search/person?api_key=1f0150a5f78d4adc2407911989fdb66c&language=cs-Cs&page=1&include_adult=true&query=".$slug);//.$star_slug);
$JSON_ID = json_decode( $preJSON_ID, true );
$preJSON2 = file_get_contents("https://api.themoviedb.org/3/person/".$JSON_ID["results"][0]["id"]."?api_key=1f0150a5f78d4adc2407911989fdb66c&language=cs-Cs");
$JSON_ = json_decode( $preJSON2, true );
?>
<!-- Breadcrumb -->
	<div id="title-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-sm-8 col-xs-12">
					<div class="page-title">
						<h1 class="text-uppercase">Hvězda: <?php echo $star_name; ?></h1>
					</div>
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 text-right">
					<ul class="breadcrumb">
					    <li>
					    	<a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i>Domů</a>
					    </li>
					    <!-- <li class="active">TV-Serialy</li> -->
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumb -->

<!-- ACTOR TAB INFORMATION -->
<div class="row">
                            <div class="col-md-3 m-t-10"><img class="img-responsive" style="min-width: 183px;float: right;padding: 20px;" src="https://image.tmdb.org/t/p/original/<?php echo $JSON_["profile_path"]; ?>" alt="<?php echo $star_name; ?>"></div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1><?php echo $star_name; ?></h1>
                                        <p><?php echo $JSON_["biography"]; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                        <p> <strong>Znáte jako: </strong>
                                            <a><?php 
                                            if($JSON_["known_for_department"] == "Acting"){
                                                echo "Herec";
                                            }
                                            if($JSON_["known_for_department"] == "Directing"){
                                                echo "Režisér";
                                            }
                                            if($JSON_["known_for_department"] == "Writer"){
                                                echo "Spisovatel";
                                            }
                                            ?></a>
                                        </p>

                                        <p> <strong>Pohlaví: </strong>
                                            <a><?php
                                                    if($JSON_["gender"] == "1"){
                                                        echo "Žena";
                                                    } else { echo "Muž"; }
                                                ?></a>
                                        </p>

                                        <!--<p> <strong>Známé záznamy: </strong>
                                            <a>{{ HOW_MUCH_MOVIES }}</a>
                                        </p>-->
                                        <p> <strong>Datum narození: </strong>
                                            <a><?php echo $JSON_["birthday"]; ?></a>
                                        </p>
                                        <p><strong>Místo narození: </strong>
                                            <a><?php echo $JSON_["place_of_birth"]; ?></a>
                                        </p>
                                        <?php
                                        if($JSON_["deathday"] == ""){ } else {
                                            echo "<p><strong>Datum úmrtí: </strong>
                                            <a>".$JSON_["deathday"]."</a>
                                            </p>";
                                        }
                                        ?>
                                        <p><strong><a href="https://www.imdb.com/name/<?php echo $JSON_["imdb_id"]; ?>" target="_blank"><img src="<?php echo base_url();?>assets/front_end/images/imdb-logo.png"></strong>
                                            <?php echo "Popularita:".$JSON_["popularity"];?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
</div>

<!-- Breadcrumb -->
    <div id="title-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="page-title">
                        <h1 class="text-uppercase">Filmy:</h1>
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
        <?php if ($total_rows>0){?>
            <!-- All Movies -->
			<?php if($total_rows > 24){
				echo $links;
			}
			?>
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($all_published_videos as $videos) :?>
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($videos->videos_id); ?>" alt="<?php echo $videos->title;?>"> <a href="<?php echo base_url('watch/'.$videos->slug.'.html');?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
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
	echo "<h2 class='text-center text-capitalize'>Žádný filmy nebyl nalezen na ".$star_name;
	} ?>
	</div>
<?php if($total_rows > 24){ echo $links; } ?>		
								
    </div>
</div>

<!-- Secondary Section -->