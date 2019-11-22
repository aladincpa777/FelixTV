<?php 

$global_index = 1;

$GET_SUB = $_GET['sub'];
if (!empty($GET_SUB)){
  die("Yeah, it works!");
}
// %DATABASE%
//$servername = "md21.wedos.net";
//$username = "a194060_felix";
//$password = "WF=AT@QA_4Pmt5r";
//$dbname = "d194060_felix";
//$conn = new mysqli($servername, $username, $password, $dbname);
    $seasons_id     = '00000';
    $episodes_id    = '00000';
    if(isset($param1) && $param1 !=''){
        $seasons_id= $param1; // ŘADA
    }
    ///////////////////////////////////////////////////////////////// DONT WORK ///////////////////////////////////////////////////////////////////
    //$episode_prepare = mysqli_query($conn,"SELECT * FROM episodes WHERE videos_id = '{$videos_id}' AND seasons_id = '{$param1}'"); // Get list of all                                                                              == PRŮMĚRŇÁKOVI                   = 2 ŘADA
    //if (mysqli_num_rows($episode_prepare) > 0) {
    //  while($row = mysqli_fetch_assoc($episode_prepare)) {
    //    if ($row['episode_id'] == $episode_id){
    //        $global_index++;
          //die($row['episodes_name']); // FIRST ROW OF SEASON 
    //    }
    //  }

    //}
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(isset($param2) && $param2 !=''){
        $episodes_id= $param2; // = EPIZODA (video_id)
    }
 ?>

<?php
session_start();
// It is really important to regenerate id on every click...
session_regenerate_id();

// We will tell the next file that we have a token set using session
$_SSEION['setToken'] = true;

// The filename... You can get that from a $_GET variable and store it here
$token = $file_url;

// We will be encrypting the video name using session id as key ans AES128 as the algorithm
$token_encrypted = openssl_encrypt($token, "aes128", session_id());
?>

                        <?php 
                        $total_episodes =0;
                        if(isset($episodes_id) && $episodes_id !='00000'){
                            $total_episodes = $this->db->get_where('episodes', array('episodes_id'=>$episodes_id,))->num_rows();
                        }
                        else{
                            $total_episodes = $this->db->get_where('episodes', array('videos_id'=>$videos_id))->num_rows();

                        }


                        if($total_episodes >0):
                        
                        if(isset($episodes_id) && $episodes_id !='00000'){
                                $this->db->order_by('episodes_id', "DESC");
                                $video_file     = $this->db->get_where('episodes', array('episodes_id'=>$episodes_id,),1)->row();
                                $source_type    = $video_file->source_type;
                                $file_source    = $video_file->file_source;
                                $eng_sub        = $video_file->eng_sub;
                                $eng_lang        = $video_file->eng_lang;
                                $cze_sub        = $video_file->cze_sub;
                                $cze_lang        = $video_file->cze_lang;
                                $hd        = $video_file->HD;
                                $sosac     = $video_file->SOSAC;
                                $real_episode_id = $video_file->real_episode_id;
                                $real_episode_name = $video_file->episode_name;
                            }else{
                                $this->db->order_by('source_type', "DESC");
                                $video_file     = $this->db->get_where('episodes', array('videos_id'=>$videos_id),1)->row();
                                $source_type    = $video_file->source_type;
                                $file_source    = $video_file->file_source;
                                $seasons_id     = $video_file->seasons_id;
                                $episodes_id    = $video_file->episodes_id;
                                $eng_sub        = $video_file->eng_sub;
                                $eng_lang        = $video_file->eng_lang;
                                $cze_sub        = $video_file->cze_sub;
                                $cze_lang        = $video_file->cze_lang;
                                $hd        = $video_file->HD;
                                $sosac     = $video_file->SOSAC;
                                $real_episode_id = $video_file->real_episode_id;
                                $real_episode_name = $video_file->episode_name;
                            }                                
                            ?>

                            <!-- ------------------------------------------------------------------------------------ -->
							<?php
							$tt     = str_replace( '/[^1-30]./', '', $file_url );
							$number = preg_replace('/\D/', '', $file_url );

							?>

							<!-- ------------------------------------------------------------------------------------ -->


              <?php 
              // ================ CONVERT SEASON NUMBER=====================
                        $seasions = $this->db->get_where('seasons', array('videos_id'=>$watch_videos->videos_id))->result_array();
                        foreach ($seasions  as $seasion):
                     ?>
              <?php if($seasion['seasons_id']==$seasons_id){ 
                $soc_name = $seasion['seasons_name'];
                $video_episode_data = str_replace("Řada ", "", $soc_name);
              } ?>
                    <?php endforeach; ?>

<?php
// ================ GET STREAM =====================
//die("http://tv.sosac.tv/cs/player/".$watch_videos->slug."-s".$video_episode_data."-e".$video_file->real_episode_id);
//if (strpbrk($watch_videos->slug, '1234567890') !== FALSE && $watch_videos->slug !== '2-socky') {
  $slug_check = Substr($watch_videos->slug, strrpos($watch_videos->slug, "-")+1);
  if ($watch_videos->slug === "the-100"){
      $slug_par = $watch_videos->slug;
  } else {
    $slug_par = preg_replace('/-[0-9]+/', '', $watch_videos->slug);
  }
//  $slug_pre = explode('-', $watch_videos->slug);
//  $repla_number= end($slug_pre); // << NUMBER
//  $slug_final = str_replace('-'.end($slug_pre), '', $watch_videos->slug);
//  $html = file_get_contents("http://tv.sosac.tv/cs/player/".$slug_final."-s".$video_episode_data."-e".$video_file->real_episode_id);//$episodes_id);
//} else {
  $html = file_get_contents("http://tv.sosac.tv/cs/player/".$slug_par."-s".$video_episode_data."-e".$video_file->real_episode_id);//$episodes_id);
//}
               $dom = new DOMDocument();
               $dom->loadHTML($html);
               $xpath = new DOMXpath($dom);
               $video_url_p = "";
               foreach ($xpath->query("//div[@class='bottom-player']") as $node){
                    $video_p =  $node->getElementsByTagName('iframe')[0]->getAttribute("src");
                }
              $video_url_p = str_replace("?remote=1&affid=0&width=960&height=525", "", $video_p); // !!! FINAL LINK !!!

// ================ STREAM ================
$stream_payload = file_get_contents('http://s.felixtv.cz/STREAM_CONTROLLER.php?q='.$video_url_p."&LANG=CZ"); // CZECH LANGUAGE
$stream_en_payload = file_get_contents('http://s.felixtv.cz/STREAM_CONTROLLER.php?q='.$video_url_p.'&LANG=EN'); // ENGLISH LANGUAGE

if ($stream_payload == 'Server side error (Code: 99)' || empty($stream_payload)){
        $CZECH = "0";
} else {
        $CZECH = "1";
        $video_stream = "http://s.felixtv.cz/web_stream.php?q=".$stream_payload; // Proxify stream
}

if ($stream_en_payload == 'Server side error (Code: 99)' || empty($stream_en_payload)){
  $ENG_DAB = "0";
} else {
  $ENG_DAB = "1";
  $video_stream_en = "http://s.felixtv.cz/web_stream.php?q=".$stream_en_payload; // Proxify stream
}
// ================ SUBTITLES ================
$path = $_SERVER["DOCUMENT_ROOT"].'/CAPTIONS_DB/Serialy/'.$watch_videos->title.$video_episode_data.'x'.$video_file->real_episode_id.'.vtt';
if (file_exists($path)) {
    $SUBTITLES_CHECKER = "TRUE";
        } else {
              $SUBTITLES_CHECKER = "FALSE";
              $stream_subtitles_payload = file_get_contents('http://s.felixtv.cz/STREAM_CONTROLLER.php?q='.$video_url_p.'&s=true');
              if ($stream_subtitles_payload != NULL || $stream_subtitles_payload != ''){
                    $SUBTITLES_CHECKER = "TRUE";
                      file_put_contents($watch_videos->title.$video_episode_data.'x'.$video_file->real_episode_id.'.srt', $stream_subtitles_payload);
                      require('SrtParser/srtFile.php');
                      try{
                          $srt = new \SrtParser\srtFile($watch_videos->title.$video_episode_data.'x'.$video_file->real_episode_id.'.srt');
                          $srt->setWebVTT(true);
                          $srt->build(true);
                          $srt->save('CAPTIONS_DB/Serialy/'.$watch_videos->title.$video_episode_data.'x'.$video_file->real_episode_id.'.vtt', true);
                          unlink($watch_videos->title.$video_episode_data.'x'.$video_file->real_episode_id.'.srt');
                      }
                      catch(Exception $e){
                          //echo 'Error: '.$e->getMessage()."\n";
                          unlink($watch_videos->title.$video_episode_data.'x'.$video_file->real_episode_id.'.srt');
                        }
              }
          }

// ================ GET DESCRIPT ================
if ($watch_videos->imdbid != NULL || $watch_videos->imdbid != ""){
    $description_preloader_json = file_get_contents("http://api.themoviedb.org/3/tv/".$watch_videos->imdbid."?api_key=1f0150a5f78d4adc2407911989fdb66c&language=cs-Cs");
    $arJson = json_decode( $description_preloader_json, true );
    $description_json = $arJson["overview"];
} else {
   $description_preloader_json = file_get_contents("https://api.themoviedb.org/3/search/tv?api_key=1f0150a5f78d4adc2407911989fdb66c&query=".urlencode($watch_videos->title)."&language=cs-CZ"); 
    $arJson = json_decode( $description_preloader_json, true );
    $description_json = $arJson["results"][0]["overview"];
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
                     <h5 class="text-lowpercase">
                        <?php echo "<b>".$video_episode_data."x".$video_file->real_episode_id." - ".$video_file->episodes_name."</b>";?>
                    </h5>
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
                     <!-- DE -->
                     <?php if($watch_videos->de_lang != NULL): ?>
                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                        <img src="<?php echo base_url();?>assets/front_end/images/de.png">   
                     <?php endif; ?>

                </div>
            </div>

            <div align="right">
<?php $num_f=0; 
	  $sesa_f_dim_db_episode=0;
	  $sesa_f=0;
    $sesa=0;
	 ?>
					<?php foreach ($seasions  as $seasion):?>
                      <?php
                        $episodes = $this->db->get_where('episodes', array('videos_id'=>$watch_videos->videos_id, 'seasons_id'=>$seasion['seasons_id']))->result_array();
                        foreach($episodes as $episode): ?>

                            <?php $num_f++ ?>
                      <?php endforeach; ?>
                <?php endforeach; ?>

                <?php 
                        $seasions = $this->db->get_where('seasons', array('videos_id'=>$watch_videos->videos_id))->result_array();
                        foreach ($seasions  as $seasion):
                     ?>
                    <?php $sesa_f++; ?>
                    <?php endforeach; ?> 

                    <?php //$num_f=$num_f/2 ?>

                 <?php echo "<font color='orange' size='5' font-weight: bold>".$sesa_f."</font><font size='3'> Řady </font>"."/"."<font color='dark-orange' size='5' font-weight: bold> ".$num_f."</font> <font size='3'>Epizod</font>";?>

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
<script>
    function is_valid_url($url) {
    if (@fclose(@fopen( $url,  "r "))) {
     return true;
    } else {
     return false;
    }
}
</script>
                                <!-- play from mp4 url file -->
                                <?php if($source_type =='link' && $file_source=='mp4'): ?>
                                   <video id="play" class="video-js sleev vjs-16-9" > 
                                        <?php if ($CZECH == "1") { ?>
                                            <source src="<?php echo $video_stream; ?>" type="video/mp4" srclang="cz" quality="HD" title="Čeština" label="Čeština"> 
                                        <?php } ?>

                            <?php if ($ENG_DAB == "1") { ?>
                              <source src="<?php echo $video_stream_en; ?>" srclang="en" type="video/mp4" quality="HD" title="Angličtina" label="Angličtina">
                           <?php } ?>

                           <?php if ($SUBTITLES_CHECKER == "TRUE") { ?>
                            <track src="<?php echo base_url().'CAPTIONS_DB/Serialy/'.$watch_videos->title.$video_episode_data.'x'.$video_file->real_episode_id.'.vtt';?>" kind="captions" srclang="en" label="Čeština tit.">
                            <?php } ?>


                                   </video>

                                    <script>
                                        var Player = videojs("play", { 
                                        "controls": true, 
                                        "autoplay": true, 
                                        "preload": "auto" ,
                                        "playbackRates": [0.5, 1, 1.5, 2],
                                        "width": 640,
                                        "height": 265

                                        });videojs('play').videoJsResolutionSwitcher();
                                    </script>
                                                                   
                                <?php endif; ?>
                                

                                <?php if($source_type =='link' && $file_source=='embed'): ?>
                                   <iframe class="responsive-embed-item" src="<?php echo $file_url; ?>" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                                <?php endif; ?>
                            <!-- end play from first video file -->  
                        <?php else: ?>
                            <iframe class="responsive-embed-item" src="https://www.youtube.com/embed?listType=search&list=<?php echo $watch_videos->title; ?>" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                            <!-- end play no videos/mp4 file -->
                        <?php endif; ?>

                    </div>
                </div>
                <div class="m-t-10">
                    <?php
                        $this->db->order_by('video_file_id', "ASC");
                        $sources = $this->db->get_where('video_file',array('videos_id'=>$watch_videos->videos_id))->result_array();
                        $i=0;
                        if(isset($_GET['source_id'])){
                            $current_file_id = $_GET['source_id'];
                        }else{
                            $current_file_id = '000000';
                        }
                        foreach($sources as $source):
                            $i++;
                     ?>
                    <a href="<?php echo base_url().'watch/'.$watch_videos->slug.'.html?source_id='.$source['video_file_id']; ?>" class="btn <?php if($source['video_file_id']==$current_file_id){ echo 'btn-success';}else{ echo 'btn-default';} ?> m-r-10"><?php echo 'Video-'.$i; ?></a>
                <?php endforeach; ?>
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
                      <?php 
                        $prev=$file_url;
                        $prev=$prev-1;
                        $next=$watch_videos->videos_id+1;
                        ?>
                        <!-- <?php if($episodes_id != "1"): ?>
                        <a class='btn btn-xs btn-primary' href="<?php echo $episodes_id-1; ?>"><span class="btn-label"><i class="fa fa-play"></i></span>Předchozí epizoda</a>
                        <?php endif; ?>  -->

            <div class="col-md-9 col-sm-8">
                <ul class="nav nav-tabs">

                    <?php 
                        $seasions = $this->db->get_where('seasons', array('videos_id'=>$watch_videos->videos_id))->result_array();
                        foreach ($seasions  as $seasion):
                     ?>
                    <li class="<?php if($seasion['seasons_id']==$seasons_id){ echo 'active';} ?>"><a data-toggle="tab" href="<?php echo '#s-'.$seasion['seasons_id']; ?>"><?php echo $seasion['seasons_name']; ?></a></li>
                    <?php endforeach; ?>                   
                </ul>
                <div class="tab-content">
                    <?php 
                        foreach ($seasions  as $seasion):
                     ?>

                    <div id="<?php echo 's-'.$seasion['seasons_id']; ?>" class="tab-pane fade in <?php if($seasion['seasons_id']==$seasons_id){ echo 'active';} ?> m-l-10">
                        <ul class="list-unstyled"><br>
                      <?php
                        $num=1;
                        $episodes = $this->db->order_by('real_episode_id', 'ASC')->get_where('episodes', array('videos_id'=>$watch_videos->videos_id, 'seasons_id'=>$seasion['seasons_id']))->result_array();
                        foreach($episodes as $episode): ?>

                             <?php if($seasion['seasons_id'] != $sesa): ?>
                                <?php 
                                    $sesa++; 
                                    
                                ?>
                             <?php endif; ?>   

                            <li><a class='btn btn-xs <?php if($episodes_id == $episode['episodes_id']){ echo 'btn-success';}else{ echo "btn-primary";} ?>' href="<?php echo base_url().'tv-series/watch/'.$watch_videos->slug.'/'.$seasion['seasons_id'].'/'.$episode['episodes_id']; ?>"><span class="btn-label"><i class="fa fa-play"></i></span><?php echo $num++ .". ".$episode['episodes_name'] ?></a>
                            	 <?php if($episode['HD'] != NULL): ?>
                                <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                <?php endif; ?>
                                
                                <?php if($episode['cze_lang'] != NULL): ?>
                                <img src="<?php echo base_url();?>assets/front_end/images/cs.png">
                                <?php endif; ?>

                                <?php if($episode['cze_sub'] != NULL): ?>
                                <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                <img src="<?php echo base_url();?>assets/front_end/images/en.png">   
                                <?php endif; ?> 
                            </li><br>
                      <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
                    
                </div>

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#info">Informace</a></li>
                    <li><a data-toggle="tab" href="#actor_tab">Herci</a></li>
                    <li><a data-toggle="tab" href="#director_tab">Režisér</a></li>
                    <li><a data-toggle="tab" href="#writer_tab">Spisovatel</a></li>
                    <?php if($total_download_links >0 && $watch_videos->enable_download =='1'): ?>
                    <li><a data-toggle="tab" href="#download">Stáhnout</a></li>
                    <?php endif; ?>
                    <?php if($watch_videos->trailer =='1'): ?>
                    <li><a data-toggle="tab" href="#trailler">Trailler</a></li>
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
                                        <button class="btn btn-xs btn-success" onclick="wish_list_add('fav','<?php echo $watch_videos->videos_id;?>')"><span class="btn-label"><i class="fa fa-heart-o"></i></span>Oblíbené</button>
                                        <button class="btn btn-xs btn-success" onclick="wish_list_add('wl','<?php echo $watch_videos->videos_id;?>')"><span class="btn-label"><i class="fa fa-clock-o"></i></span>Později</button>
                                        <?php  if($this->db->get_where('config' , array('title' =>'social_share_enable'))->row()->value =='1'):?>
                                        
                                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                        <div class="addthis_inline_share_toolbox_yl99 m-t-30 m-b-10" data-url="<?php echo base_url().'watch/'.$watch_videos->slug.'.html';?>" data-title="Watch & Download <?php echo $watch_videos->title;?>"></div>
                                        <!-- Addthis Social tool -->
                                    <?php endif; ?>
                                        <p>
                                            <!-- <?php echo $watch_videos->description;?> -->
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
                                                if($i>0){ echo ',';} $i++;                                           ?>
                                            <a href="<?php echo $this->common_model->get_genre_url_by_id($genre_id);?>"><?php echo $this->common_model->get_genre_name_by_id($genre_id);?></a>
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
                                                if($i>0){ echo ',';} $i++;                                           ?>
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
                                        <p><strong><img src="<?php echo base_url();?>assets/front_end/images/imdb-logo.png"></strong>
                                            <?php echo $watch_videos->imdb_rating;?>
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
                                        </div>
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
                            <li><a class='btn btn-xs btn-success' href="<?php echo $dw_link['download_url'] ?>"><span class="btn-label"><i class="fa fa-download"></i></span><?php echo $dw_link['link_title'] ?></a></li></ul><br>
                      <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                    <div id="actor_tab" class="tab-pane fade">
                        <?php if($watch_videos->stars !='' && $watch_videos->stars !=NULL):
                                $stars =explode(',', $watch_videos->stars);                                                
                                foreach ($stars as $star_id):
                                                                           ?>
                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>">
                                <img class="img-thumbnail img-responsive col-sm-2 m-r-20" max-width="50" src="<?php echo $this->common_model->get_image_url('star',$star_id) ?>" alt="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>" title="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>">
                            </a>
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
                    <?php if($watch_videos->trailer =='1'): ?>
                    <div id="trailler" class="tab-pane fade">
                      <h3>Trailler</h3>
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
                                    <div class="disable-bottom-line  zoomIn" data-wow-duration="0.8s"> </div>
                                </div>
                                <div class="row">
                                    <div class="movie-container">
                                        <?php 
                                            $i=0;
                                            $this->db->where('videos_id !=',$watch_videos->videos_id);
                                            $this->db->where('is_tvseries','1');
                                            $this->db->like('genre',$watch_videos->genre);
                                            $this->db->limit(4);   
                                            $related_videos = $this->db->get('videos')->result();         
                                            foreach ($related_videos as $v):
                                            $i++;
                                        ?>
                                        <div class="col-md-3 col-sm-3 col-xs-2">
                                            <div class="latest-movie-img-container">
                                                <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($v->videos_id,$v->title_en); ?>" alt="<?php echo $v->title;?>"> <a href="<?php echo base_url('tv-series/watch/'.$v->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                                    <div class="overlay-div"></div>
                                                </div>
                                                <div class="movie-title">
                                                    <h1><a href="<?php echo base_url('tv-series/watch/'.$v->slug).'.html';?>"><?php echo $v->title;?></a></h1>
                                                    <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $v->runtime;?></span><span>&nbsp;&#47;</span> <span><?php echo $v->total_view;?> views</span> </p>
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
                    <?php if ($watch_videos->tags !='' && $watch_videos->tags !=NULL): ?>
                    <div class="tags">
                        <h1 class="sidebar-title">Tagy</h1>
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
            list_name ='Favorite';
        }else{
            list_name ='Wish';
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
                   swal('Good job!','Added to your '+list_name+' List.','success'); 
                }else if (status == "login_fail"){
                    swal('OPPS!','Please login to add your '+list_name+' list.','error');
                }else {
                    swal('OPPS!','Already exist on your '+list_name+' list.','error');
                }
            }
        });
    }
</script>
<!-- End ajax add to wish-list -->

<!-- Ajax Rating -->
<script src="<?php echo base_url(); ?>assets/front_end/js/jquery-1.12.3.min.js"></script>
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

<script>
var removeMedia = function () {
  _.each([$video, $audio], function ($media) {
    if (!$media.length) return;
    $media[0].pause();
    $media[0].src = '';
    $media.children('source').prop('src', '');
    $media.remove().length = 0;
  });
};
</script>
<script>
    function remoteFileExists($url) {
    $curl = curl_init($url);

    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);

    //do request
    $result = curl_exec($curl);

    $ret = false;

    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

        if ($statusCode == 200) {
            $ret = true;   
        }
    }

    curl_close($curl);

    return $ret;
}
</script>
<!-- End ajax Rating -->



