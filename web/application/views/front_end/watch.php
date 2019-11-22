<!-- ### REPLACE STRING -->
<?php
//$latest_path = str_replace("‐"," ",$last);
//$urlarray=explode("/",$video_file->file_url);
//$movie_name = end(explode('/', trim($_SERVER['REQUEST_URI'], '/')));
//$movie_name = str_replace( '-', ' ', $movie_name );
//$movie_name = str_replace( '.html', '', $movie_name );
//$movie_name = ucfirst($movie_name);
//$movie_name = str_replace( '-', ' ', $movie_name );
//$movie_name2 = str_replace("‐"," ",$movie_name);
//$movie_name3 = str_replace(".html","",$movie_name2);

 $CZECH = "";
 $ENG_DAB = "";
// ================ STREAM ================
if ($watch_videos->stream != NULL){
        $stream_payload = file_get_contents('http://s.felixtv.cz/STREAM_CONTROLLER.php?q='.$watch_videos->stream."&LANG=CZ"); // CZECH LANGUAGE
        $stream_en_payload = file_get_contents('http://s.felixtv.cz/STREAM_CONTROLLER.php?q='.$watch_videos->stream.'&LANG=EN'); // ENGLISH LANGUAGE 

        if (empty($stream_payload)){
                $CZECH = "0";
        } else {
                $CZECH = "1";
                $video_stream = "http://s.felixtv.cz/web_stream.php?q=".$stream_payload; // Proxify stream
        }

        if (empty($stream_en_payload)){
          $ENG_DAB = "0";
        } else {
          $ENG_DAB = "1";
          $video_stream_en = "http://s.felixtv.cz/web_stream.php?q=".$stream_en_payload; // Proxify stream
        }

        //if ($stream_payload == 'Server side error (Code: 178)' || empty($stream_payload) || $stream_payload == 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09' && ($stream_en_payload == 'Server side error (Code: 180)' || $stream_en_payload == 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09' || $stream_en_payload == 'Server side error (Code: 178)')) {
        //    $stream_payload = file_get_contents('http://s.felixtv.cz/streamuj_get25.php?q='.$watch_videos->stream."&SOS=1"); // CZECH LANGUAGE
        //    $ENG_DAB = "0";
        //    $CZECH = "1";
        //    $video_stream = "http://s.felixtv.cz/web_stream.php?q=".$stream_payload; // Proxify stream
        //}
		// ================ SUBTITLES ================
        $path = $_SERVER["DOCUMENT_ROOT"].'/CAPTIONS_DB/'.$watch_videos->imdbid.".vtt";
        if (file_exists($path)) {
            $SUBTITLES_CHECKER = "TRUE";
        } else {
            $SUBTITLES_CHECKER = "FALSE";
                $stream_subtitles_payload = file_get_contents('http://s.felixtv.cz/STREAM_CONTROLLER.php?q='.urlencode($watch_videos->stream).'&s=true'); // SUBTITLES
                if ($stream_subtitles_payload != NULL || $stream_subtitles_payload != ''){
                    $SUBTITLES_CHECKER = "TRUE";
                            //$stream_subtitles_payload = file_get_contents('http://89.203.248.240/streamuj_get25.php?q='.$watch_videos->stream.'&s=true');
                            file_put_contents($watch_videos->imdbid.'.srt', $stream_subtitles_payload);
                            require('SrtParser/srtFile.php');
                            try{
                                $srt = new \SrtParser\srtFile($watch_videos->imdbid.'.srt');
                                $srt->setWebVTT(true);
                                $srt->build(true);
                                $srt->save('CAPTIONS_DB/'.$watch_videos->imdbid.'.vtt', true);
                                unlink($watch_videos->imdbid.'.srt');
                            }
                            catch(Exception $e){
                                echo 'Error: '.$e->getMessage()."\n";
                                }
                }
        }
        // END SUBTITLES SCRIPT
}

// ================ GET DESCRIPT ================
if ($watch_videos->imdbid != NULL || $watch_videos->imdbid != ""){
    $description_preloader_json = file_get_contents("http://api.themoviedb.org/3/movie/".$watch_videos->imdbid."?api_key=1f0150a5f78d4adc2407911989fdb66c&language=cs-Cs");
    $arJson = json_decode( $description_preloader_json, true );
    $description_json = $arJson["overview"];
} else {
   //$description_preloader_json = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=1f0150a5f78d4adc2407911989fdb66c&query=".urlencode($watch_videos->title)."&language=cs-CZ"); 
   // $arJson = json_decode( $description_preloader_json, true );
    $description_json = $watch_videos->description;
    // $description_json = $arJson["results"][0]["overview"];
}

// VOTE SCORE BY TMDB
if ($watch_videos->imdbid != NULL || $watch_videos->imdbid != ""){
    //$VOTER_preloader_json = file_get_contents("https://api.themoviedb.org/3/find/".$watch_videos->imdbid."?api_key=1f0150a5f78d4adc2407911989fdb66c&language=cs-CS&external_source=imdb_id");
    //$VOTERJson = json_decode( $VOTER_preloader_json, true );
    //$MOVIE_SCORE = $VOTERJson["movie_results"][0]["vote_average"];
    $MOVIE_SCORE = $watch_videos->imdb_rating;
    } else {
        $MOVIE_SCORE = $watch_videos->imdb_rating;
    }
//function Descramble($msg_text){
//        $msg_text = openssl_decrypt($msg_text, 'aes-256-cbc', 'FelixTV_is_Best_Service_Ever', 0, '1234567890123456');           
//        return $msg_text;
//}

// ================ GET TRAILER ================
if ($watch_videos->imdbid != NULL && $watch_videos->imdbid != ""){
    //$trailer_preloader_json = file_get_contents("http://api.themoviedb.org/3/movie/".$watch_videos->imdbid."/"."videos?api_key=1f0150a5f78d4adc2407911989fdb66c&append_to_response=videos&language=cs-Cs");
    //$trJson = json_decode( $trailer_preloader_json, true );
    //$trailer_json_id = $trJson["results"][0]["key"];
    // ** LATEST ** //
    //$preJSON = file_get_contents("http://api.themoviedb.org/3/movie/".$watch_videos->imdbid."?api_key=1f0150a5f78d4adc2407911989fdb66c&append_to_response=videos");
    //$JSON = json_decode( $preJSON, true );
    //$trailer_json_id = $JSON["videos"]["results"][0]["key"];
}
?>
<!-- Breadcrumb -->
<div id="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase">
                        <?php echo $watch_videos->title." (<font color='orange' size='5' font-weight: bold>".$watch_videos->release."</font>)";?>                           
                    </h1>
                    <?php if($watch_videos->HD != NULL): ?>
                        <img src="<?php echo base_url();?>assets/front_end/images/hd.png">  
                     <?php endif; ?>
                     <?php if($watch_videos->cze_lang != NULL): ?>
                        <img src="<?php echo base_url();?>assets/front_end/images/cs.png">  
                     <?php endif; ?>  
                     <?php if($watch_videos->cze_sub != NULL): ?>
                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">   
                     <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i>Domů</a></li>
                    <li class="active"><a href="<?php echo base_url('movies.html'); ?>">Filmy</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->
<div id="movie-details">
    <div class="container"><div class="row">
            <div class="col-md-9 col-sm-8">            
                <div class="movie-payer">
                    <div class="responsive-embed responsive-make">

<!-- <style>
video {
    object-fit: fill;
    width: 100%;
    height: auto;
}
</style>-->
                        <!-- play from mp4 url file -->
                                   <video id="play" class="video-js sleev vjs-16-9">
                                            <?php if ($CZECH == "1") { ?>
                                                <source src="<?php echo $video_stream; ?>" type="video/mp4" srclang="cz" quality="HD" title="Čeština" label="Čeština"> 
                                            <?php } ?>
                                            <?php if ($ENG_DAB == "1") { ?>
                                             <source src="<?php echo $video_stream_en; ?>" srclang="en" type="video/mp4" quality="HD" title="Angličtina" label="Angličtina">
                                            <?php } ?>
                                            <?php if ($SUBTITLES_CHECKER == "TRUE") { ?>
                                           <track src="<?php echo base_url().'CAPTIONS_DB/'.$watch_videos->imdbid.'.vtt';?>" kind="captions" srclang="en" label="Čeština tit.">
                                            <?php } ?>
                                        
                                   </video>
                                    <script>
                                        var Player = videojs("play", { 
                                        "controls": true, 
                                        "autoplay": true, 
                                        "preload": "auto" ,
                                        "playbackRates": [0.5, 1, 1.5, 2],
                                        //"width": 640,
                                        //"height": 265

                                        });videojs('play').videoJsResolutionSwitcher();
                                    </script>
                                                                   
                               
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ad_300x250 m-b-10">
                             <?php $ad_250x300=$this->db->get_where('config' , array('title' =>'ad_250x300_type'))->row()->value;
                                    if ($ad_250x300 !=0){
                                    if ($ad_250x300==1){
                                        echo '<a href="'.$this->db->get_where('config' , array('title' =>'ad_250x300_url'))->row()->value.'"><img src="'.$this->db->get_where('config' , array('title' =>'ad_250x300_image_url'))->row()->value.'" width="265"></a>';
                                    }else if ($ad_250x300==2){
                                        echo $this->db->get_where('config' , array('title' =>'ad_250x300_code'))->row()->value;
                                        }
                                        } 
                                ?>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-9 col-sm-8">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#info">Informace</a></li>
                    <!--<li><a data-toggle="tab" href="#actor_tab">Herci</a></li>-->
                    <!--<li><a data-toggle="tab" href="#director_tab">Režisér</a></li>-->
                    <!--<li><a data-toggle="tab" href="#writer_tab">Spisovatel</a></li>-->
                    <?php if($total_download_links >0 && $watch_videos->enable_download =='1'): ?>
                    <li><a data-toggle="tab" href="#download">Stáhnout</a></li>
                    <?php endif; ?>
                    <?php if($watch_videos->trailer =='0'): ?>
                    <!-- <li><a data-toggle="tab" href="#trailler">Trailer</a></li> -->
                    <?php endif; ?>
                </ul>
                <div class="tab-content">
                    <div id="info" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-3 m-t-10"><img class="img-responsive" style="min-width: 183px;" src="<?php echo $this->common_model->get_video_thumb_url($watch_videos->videos_id,$watch_videos->title_en); ?>" alt="<?php echo $watch_videos->title;?>"></div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1>
                                            <?php echo $watch_videos->title;?>
                                        </h1>
                                        <?php if ($watch_videos->title_en == $watch_videos->title || $watch_videos->title_en == ''){

                                        } else {
                                           echo  '<h3>Anglicky:'.$watch_videos->title_en.'</h3>';
                                        }
                                        ?>
                                        <button class="btn btn-xs btn-success" onclick="wish_list_add('fav','<?php echo $watch_videos->videos_id;?>')"><span class="btn-label"><i class="fa fa-heart-o"></i></span>Oblíbené</button>
                                        <button class="btn btn-xs btn-success" onclick="wish_list_add('wl','<?php echo $watch_videos->videos_id;?>')"><span class="btn-label"><i class="fa fa-clock-o"></i></span>Později</button>
                                        <button class="btn btn-xs btn-success" onclick="wish_list_add('rt','<?php echo $watch_videos->videos_id;?>')" title="Něco je špatně?"><span class="btn-label"><i class="fa fa-flag-o"></i></span>Nahlásit</button>
                                        
                                        <?php  if($this->db->get_where('config' , array('title' =>'social_share_enable'))->row()->value =='1'):?>
                                        
                                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                        <div class="addthis_inline_share_toolbox_yl99 m-t-30 m-b-10" data-url="<?php echo base_url().'watch/'.$watch_videos->slug.'.html';?>" data-title="Watch & Download <?php echo $watch_videos->title;?>"></div>
                                        <!-- Addthis Social tool -->
                                    <?php endif; ?>
                                        <p>
                                            <!-- <?php echo $watch_videos->description; ?> -->
                                            <?php echo $description_json; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                        <p> <strong>Žánr: </strong>
                                            <?php if($watch_videos->genre !='' && $watch_videos->genre !=NULL):
                                                $i = 0;
                                                $genres =explode(',', $watch_videos->genre);                                                
                                                foreach ($genres as $genre_id):
                                                if($i>0){ echo ',';} $i++;
                                                 // REPLACE CZECH ALPHABET ///
                $url_slug_preparing = $this->common_model->get_genre_name_by_id($genre_id);
                // ============================== REPLACE ENGLISH => CZECH ===============================
                if ($url_slug_preparing == "Action"){ $url_slug_preparing = "Akční"; }
                if ($url_slug_preparing == "Crime"){ $url_slug_preparing = "Krimi"; }
                if ($url_slug_preparing == "Animation"){ $url_slug_preparing = "Animované"; }
                if ($url_slug_preparing == "Family"){ $url_slug_preparing = "Rodinné"; }
                if ($url_slug_preparing == "Comedy"){ $url_slug_preparing = "Komedie"; }
                if ($url_slug_preparing == "Adventure"){ $url_slug_preparing = "Dobrodružné"; }
                if ($url_slug_preparing == "Romance"){ $url_slug_preparing = "Romantické"; }
                if ($url_slug_preparing == "History"){ $url_slug_preparing = "Historie"; }
                if ($url_slug_preparing == "Biography"){ $url_slug_preparing = "Životopisné"; }
                if ($url_slug_preparing == "Music"){ $url_slug_preparing = "Hudební"; }
                if ($url_slug_preparing == "Short"){ $url_slug_preparing = "Kratké"; }
                if ($url_slug_preparing == "War"){ $url_slug_preparing = "Válečné"; }
                if ($url_slug_preparing == "Mystery"){ $url_slug_preparing = "Mysteriózní"; }
                if ($url_slug_preparing == "Action"){ $url_slug_preparing = "Akční"; }
                $GENRE_NAME_TEXT = $url_slug_preparing;
                // =======================================================================================
                $url_slug_preparing = str_replace( 'á', 'a', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'č', 'c', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ď', 'd', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'é', 'e', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'í', 'i', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ň', 'n', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ó', 'o', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ř', 'r', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'š', 's', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ť', 't', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ú', 'u', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ů', 'u', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ý', 'y', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'ž', 'z', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Á', 'a', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Č', 'c', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ď', 'd', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'É', 'e', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Í', 'i', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ň', 'n', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ó', 'o', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ř', 'r', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Š', 's', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ť', 't', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ú', 'u', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ů', 'u', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ý', 'y', $url_slug_preparing);
                $url_slug_preparing = str_replace( 'Ž', 'z', $url_slug_preparing);                                            ?>
                                            <a href="https://felixtv.cz/genre/<?php echo strtolower(url_title($url_slug_preparing));?>.html"><?php echo $GENRE_NAME_TEXT;?></a>
                                        <?php endforeach; endif;?>
                                        </p>
                                        <p> <strong>Herci: </strong>
                                            <?php if($watch_videos->stars !='' && $watch_videos->stars !=NULL):
                                                $i = 0;
                                                $stars =explode(',', $watch_videos->stars);                                                
                                                foreach ($stars as $star_id):
                                                if($i>0){ echo ',';} $i++;                                           ?>
                                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>"><?php echo $this->common_model->get_star_name_by_id($star_id);?></a>
                                        <?php endforeach; endif;?>
                                        </p>

                                        <p> <strong>Režisér: </strong>
                                            <?php if($watch_videos->director !='' && $watch_videos->director !=NULL):
                                                $i = 0;
                                                $stars =explode(',', $watch_videos->director);                                                
                                                foreach ($stars as $star_id):
                                                if($i>0){ echo ',';} $i++;                                           ?>
                                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>"><?php echo $this->common_model->get_star_name_by_id($star_id);?></a>
                                        <?php endforeach; endif;?>
                                        </p>

                                        <p> <strong>Spisovatel: </strong>
                                            <?php if($watch_videos->writer !='' && $watch_videos->writer !=NULL):
                                                $i = 0;
                                                $stars =explode(',', $watch_videos->writer);                                                
                                                foreach ($stars as $star_id):
                                                if($i>0){ echo ',';} $i++;                                           ?>
                                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>"><?php echo $this->common_model->get_star_name_by_id($star_id);?></a>
                                        <?php endforeach; endif;?>
                                        </p>
                                        <p> <strong>Země: </strong>
                                            <?php if($watch_videos->country !='' && $watch_videos->country !=NULL):
                                                $i = 0;
                                                $countries =explode(',', $watch_videos->country);                                                
                                                foreach ($countries as $country_id):
                                                if($i>0){ echo ',';} $i++;
                                                ?>
                                            <a href="<?php echo $this->common_model->get_country_url_by_id($country_id);?>"><?php echo $this->common_model->get_country_name_by_id($country_id);?></a>
                                        <?php endforeach; endif;?>
                                        </p>
                                        <p><strong>Zveřejněno: </strong>
                                            <?php echo $watch_videos->release;?>
                                        </p>
                                    </div>
                                    <div class="col-md-6 text-left">
                                        <p><strong>Délka:</strong>
                                            <?php echo $watch_videos->runtime;?>
                                        </p>
                                        <p><strong>Kvalita:</strong>  <span class="label label-primary"><?php echo $watch_videos->video_quality; ?></span></p>
                                        <p><strong>Hodnocení:</strong>
                                            <?php echo $watch_videos->rating;?>
                                        </p>
                                        <?php if($watch_videos->imdb_rating !='' && $watch_videos->imdb_rating !=NULL): ?>
                                        <p><strong><a href="https://www.imdb.com/title/<?php echo $watch_videos->imdbid; ?>" target="_blank"><img src="<?php echo base_url();?>assets/front_end/images/imdb-logo.png"></strong>
                                            <?php echo $MOVIE_SCORE." / 10";?></a>
                                        </p>
                                    <?php endif; ?>
                                        <div class='rating_selection pull-left'> <strong id="rated">Hodnocení(<?php echo $watch_videos->total_rating;?>)</strong><br>
                                            <input checked id='rating_0' class="rate_now" name='rating' type='radio' value='0'>
                                            <label for='rating_0'> <span>Nehodnoceno</span> </label>
                                            <input id='rating_1' class="rate_now" name='rating' type='radio' value='1'>
                                            <label for='rating_1'> <span>Hodnoceno 1 Hvězdou</span> </label>
                                            <input id='rating_2' class="rate_now" name='rating' type='radio' value='2'>
                                            <label for='rating_2'> <span>Hodnoceno 2 Hvězdami</span> </label>
                                            <input id='rating_3' class="rate_now" name='rating' type='radio' value='3' checked>
                                            <label for='rating_3'> <span>Hodnoceno 3 Hvězdami</span> </label>
                                            <input id='rating_4' class="rate_now" name='rating' type='radio' value='4'>
                                            <label for='rating_4'> <span>Hodnoceno 4 Hvězdami</span> </label>
                                            <input id='rating_5' class="rate_now" name='rating' type='radio' value='5'>
                                            <label for='rating_5'> <span>Hodnoceno 5 Hvězdami</span> </label>
                                            <br>
                                        </div><br>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php if($total_download_links >0 && $watch_videos->enable_download =='1'): ?>
                    <div id="download" class="tab-pane fade">                        
                        <h3>DownloadLinks:</h3>
                        <ul class="list-unstyled">
                      <?php foreach($download_links as $dw_link): ?>
                            <li><a class='btn btn-xs btn-success' href="<?php echo $dw_link['download_url'] ?>"><span class="btn-label"><i class="fa fa-download"></i></span><?php echo $dw_link['link_title'] ?></a></li><br>
                      <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                    <div id="actor_tab" class="tab-pane fade">
                        <?php if($watch_videos->stars !='' && $watch_videos->stars !=NULL):
                                $stars =explode(',', $watch_videos->stars);                                                
                                foreach ($stars as $star_id):
                                                                           ?>
                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>">
                                <?php echo $this->common_model->get_star_name_by_id($star_id); ?><!-- <img class="img-thumbnail img-responsive col-sm-2 m-r-20" max-width="50" src="<?php echo $this->common_model->get_image_url('star',$star_id) ?>" alt="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>" title="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>">-->
                            </a> <br />
                        <?php endforeach; endif;?>
                    </div>
                    <div id="director_tab" class="tab-pane fade">

                        <?php if($watch_videos->director !='' && $watch_videos->director !=NULL):
                                $stars =explode(',', $watch_videos->director);                                                
                                foreach ($stars as $star_id):
                                                                           ?>
                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>">
                                <img class="img-thumbnail img-responsive col-sm-2 m-r-20" max-width="50" src="<?php echo $this->common_model->get_image_url('star',$star_id) ?>" alt="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>" title="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>">
                            </a>
                        <?php endforeach; endif;?>
                    </div>
                    <div id="writer_tab" class="tab-pane fade">

                        <?php if($watch_videos->writer !='' && $watch_videos->writer !=NULL):
                                $stars =explode(',', $watch_videos->writer);                                                
                                foreach ($stars as $star_id):
                                                                           ?>
                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>">
                                <img class="img-thumbnail img-responsive col-sm-2 m-r-20" max-width="50" src="<?php echo $this->common_model->get_image_url('star',$star_id) ?>" alt="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>" title="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>">
                            </a>
                        <?php endforeach; endif;?>
                    </div>
                    <?php if($watch_videos->trailer =='0'): ?>
                    <div id="trailler" class="tab-pane fade">
                      <h3>Trailer</h3>
                       <!-- play trailler from youtube -->
                        <style type="text/css">
                            .video-embed-container {
                                position: relative;
                                padding-bottom: 56.25%;
                                padding-top: 30px; height: 0; overflow: hidden;
                                }
                                .video-embed-container iframe,
                                .video-embed-container object,
                                .video-embed-container embed {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                }
                        </style>
                        <div class="video-embed-container">
                         <?php 
                            //$yt_trailer = "https://www.youtube.com/embed/".$trailer_json_id."?rel=0&color=white&modestbranding=1&showinfo=0&wmode=transparent&autoplay=1"; 
                            //$yt_trailer_searcher = "https://www.youtube.com/embed?listType=search&list=".$watch_videos->title_en." CZ Trailer";
                        ?>
                        <?php if($watch_videos->imdbid != NULL && $watch_videos->imdbid != ""): ?>
                                <!--<iframe width="853" height="480" src="<?php echo $yt_trailer; ?>" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>-->
                            <?php else: ?>
                                <!--<iframe width="853" height="480" src="<?php echo $yt_trailer_searcher; ?>" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>-->
                       <?php endif; ?>
                   </div>
                      <p></p>
                    </div>
                <?php endif; ?>
                  </div>

                <div class="movie-details-container">
                    <?php   
                        $comments_method = $this->db->get_where('config' , array('title' =>'comments_method'))->row()->value;
                        $facebook_comment_appid = $this->db->get_where('config' , array('title' =>'facebook_comment_appid'))->row()->value;
                        if(($comments_method =='both' || $comments_method =='facebook') && $facebook_comment_appid !='') :
                    ?>
                    <!-- facebook comments -->
                    <div class="row">
                        <div class="col-md-12">                        
                        <h2 class="border">Facebook Comments</h2>
                        <div class="fb-comments" data-href="<?php echo base_url();?>/watch/<?php echo $watch_videos->slug;?>.html" data-width="800" data-numposts="30"></div>
                        <div id="fb-root"></div>
                        <script>
                            (function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=<?php echo $this->db->get_where('config' , array('title' =>'facebook_comment_appid'))->row()->value; ?>";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));
                        </script>                        
                        </div>
                    </div>
                    <!-- END facebook comments -->
                <?php endif; ?>
                    <?php $total_comments = count($this->db->get_where('comments', array('video_id' =>$watch_videos->videos_id , 'comment_type'=>'1'))->result_array());
                    if ($total_comments >0) :
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-sidebar">
                                <!--Comments Area-->
                                <div class="comments-section">
                                    <div class="section-title">
                                        <h4 class="text-left title-bottom text-uppercase tp-mb30 tp-pb5">
                                            <?php echo $total_comments; ?> Comments found</h4>
                                    </div>
                                    <div class="comment-box">
                                        <?php   $this->db->order_by('comments_id','DESC');
                                            $comments =   $this->db->get_where('comments', array('video_id' =>$watch_videos->videos_id , 'comment_type'=>'1','publication'=>'1'))->result_array();
                                        foreach ($comments as $comment):
                                     ?>
                                        <div class="comment" id="comment<?php echo $comment['user_id']; ?>">
                                            <div class="author-thumbnail"><img src="<?php echo $this->common_model->get_image_url('user',$comment['user_id']); ?>" alt="<?php echo $this->common_model->get_name_by_id($comment['user_id']); ?>"></div>
                                            <div class="comment-text"><strong><?php echo $this->common_model->get_name_by_id($comment['user_id']); ?></strong> - posted
                                                <?php echo $this->common_model->time_ago($comment['comment_at'], false); ?>
                                            </div>
                                            <div class="text">
                                                <?php echo $comment['comment']; ?>
                                            </div>
                                        </div>

                                        <?php   $this->db->order_by('comments_id','ASC');
                                                $comment_replays =   $this->db->get_where('comments', array('video_id' =>$watch_videos->videos_id , 'comment_type'=>'2', 'replay_for'=>$comment['comments_id'],'publication'=>'1'))->result_array();
                                        foreach ($comment_replays as $comment_replay):
                                     ?>
                                        <div class="comment coment-replay">
                                            <div class="author-thumbnail"><img src="<?php echo $this->common_model->get_image_url('user',$comment_replay['user_id']); ?>" alt="<?php echo $this->common_model->get_name_by_id($comment_replay['user_id']); ?>"></div>
                                            <div class="comment-text"><strong><?php echo $this->common_model->get_name_by_id($comment_replay['user_id']); ?></strong> - posted
                                                <?php echo $this->common_model->time_ago($comment_replay['comment_at'], false); ?>
                                            </div>
                                            <div class="text">
                                                <?php echo $comment_replay['comment']; ?>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php   
                                            if(($comments_method =='both' || $comments_method =='ovoo')) :
                                        ?>
                                        <div class="comment coment-replay">
                                            <form class="custom-form" method="post" action="<?php echo base_url('comments/replay'); ?>">
                                                <textarea name="comment" id="comment" class="form-control" rows="2" placeholder="Repay" required></textarea>
                                                <input type="hidden" name="video_id" value="<?php echo $watch_videos->videos_id; ?>">
                                                <input type="hidden" name="replay_for" value="<?php echo $comment['comments_id']; ?>">
                                                <input type="hidden" name="url" value="<?php echo base_url(uri_string());; ?>">
                                                <div>
                                                    <?php if($this->session->userdata('login_status') == 1){ ?>
                                                    <button type="submit" value="submit" class="btn btn-success btn-sm pull-right m-t-20"> <span class="btn-label"><i class="fi ion-ios-undo-outline"></i></span>Replay </button>
                                                    <?php }else{ ?>
                                                    <a class="btn btn-success btn-sm pull-right m-t-20" href="<?php echo base_url('login'); ?>"> <span class="btn-label"><i class="fi ion-log-in"></i></span>Login to Replay </a>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        </div>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php   
                                if(($comments_method =='both' || $comments_method =='ovoo')) :
                            ?>
                            <div id="comment-container">
                                <div class="movie-heading overflow-hidden"> <span class="wow fadeInUp" data-wow-duration="0.8s">Leave a comment</span>
                                    <div class="disable-bottom-line wow zoomIn" data-wow-duration="0.8s"></div>
                                </div>
                                <form class="comment-form" method="post" action="<?php echo base_url('comments/comment'); ?>">
                                <input type="hidden" name="video_id" value="<?php echo $watch_videos->videos_id; ?>">
                                <input type="hidden" name="url" value="<?php echo base_url(uri_string()); ?>">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <textarea name="comment" id="cmnt-user-msg" rows="4" class="form-control" placeholder="MESSAGE" required></textarea>
                                                <div class="input-top-line"></div>
                                                <div class="input-bottom-line"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <?php if($this->session->userdata('login_status') == 1){ ?>
                                            <button type="submit" value="submit" class="btn btn-success"> <span class="btn-label"><i class="fi ion-ios-compose-outline"></i></span>Post Comments </button>
                                            <?php }else{ ?>
                                            <a class="btn btn-success" href="<?php echo base_url('login'); ?>"> <span class="btn-label"><i class="fi ion-log-in"></i></span>Login to Comments </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                            <div class="similler-movie">
                                <div class="movie-heading overflow-hidden"> <span class="fadeInUp" data-wow-duration="0.8s"> Mohlo by se líbit </span>
                                    <div class="disable-bottom-line" data-wow-duration="0.8s"> </div>
                                </div>
                                <div class="row">
                                    <div class="movie-container">
                                        <?php 
                                            $i=0;
                                            $this->db->where('videos_id !=',$watch_videos->videos_id);
                                            $this->db->where('is_tvseries','0');
                                            $this->db->like('genre',$watch_videos->genre);
                                            $this->db->limit(4);   
                                            $related_videos = $this->db->get('videos')->result();         
                                            foreach ($related_videos as $v):
                                            $i++;
                                        ?>
                                        <div class="col-md-3 col-sm-3 col-xs-2">
                                            <div class="latest-movie-img-container">
                                                <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($v->videos_id,$v->title_en); ?>" alt="<?php echo $v->title;?>"> <a href="<?php echo base_url('watch/'.$v->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                                    <div class="overlay-div"></div>
                                                        <div class="video_quality"><span class="label label-primary"><?php echo $v->release; ?></span></div>
                                                </div>
                                                <div class="movie-title">
                                                    <h1><a href="<?php echo base_url('watch/'.$v->slug).'.html';?>"><?php echo $v->title;?></a></h1>
                                                    <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $v->runtime;?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $v->total_view;?> views</span>--> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($i%4==0){ echo "</div></div><div class='row'><div class='movie-container'>";} ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 m-t-10">                
                <div class="sidebar">
                    <div class="sidebar-movie most-liked">
                        <h1 class="sidebar-title">Nejvíce sledované</h1>
                        <?php   $this->db->order_by('total_rating','ASC');
                                $most_rated_videos =   $this->db->get_where('videos', array('publication'=> '1'), 5)->result();         
                                    foreach ($most_rated_videos as $most_rated_video):
                        ?>

						<?php if($most_rated_video->is_tvseries == "1"): ?>
                        <div class="media">
                            <div class="media-left"> <img src="<?php echo $this->common_model->get_video_thumb_url($most_rated_video->videos_id,$most_rated_video->title_en); ?>" alt="<?php echo $most_rated_video->title;?>" width="40"> </div>
                            <div class="media-body">
                                <h1><a href="<?php echo base_url('tv-series/watch/'.$most_rated_video->slug).'.html';?>"><?php echo $most_rated_video->title;?></a></h1>
                                <p> <span><i class="fa fa-star"></i> <?php echo $most_rated_video->total_rating;?></span> <span><i class="fa fa-eye"></i> <?php echo $most_rated_video->total_view;?></span> </p>
                            </div>
                        </div>
                        <?php else: ?>
                        	<div class="media">
                            <div class="media-left"> <img src="<?php echo $this->common_model->get_video_thumb_url($most_rated_video->videos_id,$most_rated_video->title_en); ?>" alt="<?php echo $most_rated_video->title;?>" width="40"> </div>
                            <div class="media-body">
                                <h1><a href="<?php echo base_url('watch/'.$most_rated_video->slug).'.html';?>"><?php echo $most_rated_video->title;?></a></h1>
                                <p> <span><i class="fa fa-star"></i> <?php echo $most_rated_video->total_rating;?></span> <span><i class="fa fa-eye"></i> <?php echo $most_rated_video->total_view;?></span> </p>
                            </div>
                        </div>
                        <?php endif; ?>
                            
                        <?php endforeach ?>
                    </div>
                    <div class="sidebar-movie most-viewed">
                        <h1 class="sidebar-title">Nejlépe hodnocené</h1>
                        <?php   $this->db->order_by('total_view','ASC');
                                $most_rated_videos =   $this->db->get_where('videos', array('publication'=> '1'), 5)->result();         
                                    foreach ($most_rated_videos as $most_rated_video):
                        ?>

                        <div class="media">
                            <div class="media-left"> <img src="<?php echo $this->common_model->get_video_thumb_url($most_rated_video->videos_id,$most_rated_video->title_en); ?>" alt="<?php echo $most_rated_video->title;?>" width="40"> </div>
                            <div class="media-body">
                                <h1><a href="<?php echo base_url('watch/'.$most_rated_video->slug).'.html';?>"><?php echo $most_rated_video->title;?></a></h1>
                                <p> <span><i class="fa fa-star"></i> <?php echo $most_rated_video->total_rating;?></span> <span><i class="fa fa-eye"></i> <?php echo $most_rated_video->total_view;?></span> </p>
                            </div>
                        </div>
                            
                        <?php endforeach ?>
                    </div>
                    <?php if ($watch_videos->tags !='' && $watch_videos->tags !=NULL): ?>
                    <div class="tags">
                        <h1 class="sidebar-title">Tags</h1>
                        <ul class="list-inline list-unstyled">
                        <?php $tags=explode(',', $watch_videos->tags);
                        foreach ($tags as $tag):
                        ?>
                            <li><h2><a href="<?php echo base_url().'tags/'.$tag.'.html'; ?>"><?php echo $tag; ?></a></h2></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </div>
</div>
<!--sweet alert2 JS -->
<script src="<?php echo base_url(); ?>assets/plugins/swal2/sweetalert2.min.js"></script>
<!-- ajax add to wish-list -->
<script type="text/javascript">
    function wish_list_add(list_type='',videos_id=''){
        if(list_type =='fav'){
            list_name ='Oblíbené';
        }else if (list_type == 'wl'){
            list_name ='Slédnout později';
        } else {
            list_name ='Nahlásit';
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>user/add_to_wish_list',
            data: "list_type="+list_type+"&videos_id="+videos_id,
            dataType: 'json',
            beforeSend: function() {
            },
            success: function(response) {
                var status = response.status;
                if (status == "success") {
                    if (list_name != 'Nahlásit'){
                        swal('Přidáno','Přidáno do vašeho seznamu '+list_name+'.','success'); 
                    } else {
                         swal('Nahlášeno','Film byl úspěšně nahlášen!<br/>Děkujeme!','success');
                    }
                }else if (status == "login_fail" && list_name != 'Nahlásit'){
                    swal('OPPS!','Pro přidání do seznamu '+list_name+' se prosím přihlašte.','error');
                }else {
                    if (list_name != 'Nahlásit'){
                       swal('OPPS!','Již existuje ve vašem seznamu '+list_name+'.','error'); 
                   } else {
                       swal('OPPS!','Film byl již nahlášen.<br/>Děkujeme!','error');
                   }
                }
            }
        });
    }
</script>
<!-- End ajax add to wish-list -->

<!-- Ajax Rating -->
<script>
    $('.rate_now').click(function() {
        rate = $(this).val();
        video_id = "<?php echo $watch_videos->videos_id;?>";
        current_rating = "<?php echo $watch_videos->total_rating;?>";
        total_rating = Number(current_rating) + Number(1);
        //alert(rate+video_id);
        if (parseInt(rate) && parseInt(video_id)) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url().'admin/rating';?>",
                data: "rate=" + rate + "&video_id=" + video_id,
                dataType: 'json',
                success: function(response) {
                    var post_status = response.post_status;
                    var rate = response.rate;
                    var video_id = response.video_id;

                    if (post_status == "success") {
                        $('#rated').html('Rating(' + total_rating + ')');
                        //alert("Successed");
                    } else {

                        //alert('Not Successed'); 
                    }
                }
            });
        }


    });
</script>
<!-- End ajax Rating -->



