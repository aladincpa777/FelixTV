<?php
const DBHOST='127.0.0.1';
const DBUSER='FELIX';
const DBPASS='%DELETED%';
const DBNAME='FELIX';
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<div class="alert"> -->
  <!-- <strong>Vážení uživatelé</strong> 21.11.2018 bude náš celý datový disk suspendován a služby nebudou funkční, prosíme o trpělivost, než se najde alternativní řešení. -->
 <!-- <strong>Vážení uživatelé</strong> všechny služby nejsou ještě plně funkční, takže prosíme strpení. Začínáme..<br/>Update 04/25/19: Opravena chyba ve scriptu (Titulky)
</div> -->

<!-- <div class="alert">
  <strong>Vážení uživatelé,</strong> včera (2.6.19) kolem 18té hodiny 'umřel' hlavní server. Mám zálohy, které jsem již obnovil a web do jisté míry funguje, ale plně funkční web chvilku zabere, takže trpělivost! :)
</div> -->
<!-- Secondary Section -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<?php
//$useragent=$_SERVER['HTTP_USER_AGENT'];

//if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){ ?>

<div id="section-opt">
    <div class="container">
        <div class="row">
            <!-- Upcomming Movies -->
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt"><br/>
                    <div class="movie-heading overflow-hidden"> <span>Nové filmy</span>
                        <div class="disable-bottom-line"></div>
						<a href="<?php echo base_url();?>movies.html" class="btn btn-success btn-sm pull-right">Více<i class="fa fa-angle-double-right m-l-10" aria-hidden="true"></i></a>
                    </div>
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($new_videos as $new_video) :?>
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($new_video->videos_id, $new_video->title_en); ?>" alt="<?php echo $new_video->title;?>"> <a href="<?php echo base_url('watch/'.$new_video->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
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
                                        <h1><a href="<?php echo base_url('watch/'.$new_video->slug).'.html';?>"><?php echo "<b>".$new_video->title."</b>";?> <!-- (<?php echo $new_video->release; ?>)--></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php $time = str_replace("M","m",$new_video->runtime); echo $time; ?></span><!--<span>&nbsp;&#47;</span>  <span><?php echo $new_video->total_view;?>x shlédnuto</span>--> </p>
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
                    <div class="movie-heading overflow-hidden"> <span>Populární</span>
                        <div class="disable-bottom-line"></div>
						<a href="<?php echo base_url();?>movies.html" class="btn btn-success btn-sm pull-right">Více<i class="fa fa-angle-double-right m-l-10" aria-hidden="true"></i></a>
                    </div>
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <!--
                            <?php foreach ($latest_videos as $latest_video) :?>
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
                                        <h1><a href="<?php echo base_url('watch/'.$latest_video->slug).'.html';?>"><?php echo "<b>".$latest_video->title."</b>";?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php $time = str_replace("M","m",$latest_video->runtime); echo $time; ?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $latest_video->total_view;?>x shlédnuto</span>--> <!--</p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>-->
                            <?php
                            $NO_REPEAT = [];
                            $API_COUNTER_PAGE = 1;
                            $SHOW_ME_JUST_20 = 1;
                            $preJSON = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=1f0150a5f78d4adc2407911989fdb66c&language=cs-Cs&year=2019&sort_by=popularity.desc&page=".$API_COUNTER_PAGE);
                            $JSON = json_decode( $preJSON, true );
                            $max = 30;
                            $counter = 0;
                            for($i=0; $i<=$max; $i++){
                                global $db;
                                if ($counter == 19 || $counter == 39){
                                    $API_COUNTER_PAGE++;
                                    $preJSON = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=1f0150a5f78d4adc2407911989fdb66c&language=cs-Cs&year=2019&sort_by=popularity.desc&page=".$API_COUNTER_PAGE);
                                    $JSON = json_decode( $preJSON, true );
                                    $counter = 0;
                                }
                                if (CheckIfExist($JSON["results"][$counter]["original_title"]) == "Exist"){

                                    if(in_array($JSON["results"][$counter]["original_title"], $NO_REPEAT)){
                                        $max++;
                                    } else {
                                        array_push($NO_REPEAT, $JSON["results"][$counter]["original_title"]);
                                        $SHOW_ME_JUST_20++;
                                        $db=new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING, PDO::ATTR_PERSISTENT=>true]);
                                        $db->exec("set names utf8");
                                            $stmt=$db->query('SELECT * FROM videos WHERE title_en = "'.$JSON["results"][$counter]["original_title"].'" LIMIT 1;');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){                                 
                                                echo '<div class="col-md-2 col-sm-3 col-xs-4">
                                            <div class="latest-movie-img-container">
                                            <div class="movie-img"> <img class="img-responsive" src="'.$this->common_model->get_video_thumb_url($row['videos_id'],$row['title_en']).'" alt=" '.$row['title'].'"> <a href="';
                                            if ($row['is_tvseries'] == "1"){
                                                echo base_url('tv-series/watch/'.$row['slug']);
                                            } else {  echo base_url('watch/'.$row['slug']); }
                                            echo '.html" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="'.base_url().'assets/front_end/images/play-button.svg" alt="play"> </a>
                                            <div class="overlay-div"></div>
                                             <div class="video_quality"><span class="label label-primary">'.$row['release'].'</span></div>';

                                            if($row['video_quality'] == "HD"){
                                            echo '<img src="'.base_url().'assets/front_end/images/hd.png">';
                                             } else { echo '<img src="'.base_url().'assets/front_end/images/sd.png">'; }

                                            if($row['cze_lang'] != NULL){
                                                echo '<span><img src="'.base_url().'assets/front_end/images/cs.png"></span>';
                                            }

                                            if($row['de_lang'] != NULL){
                                               echo '<span><img src="'.base_url().'assets/front_end/images/de.png"></span>';
                                            }

                                            if($row['cze_sub'] != NULL){
                                                echo '<img src="'.base_url().'assets/front_end/images/cs-cc.png">';
                                                echo '<img src="'.base_url().'assets/front_end/images/en.png"> ';
                                            }
                                            $time = str_replace("M","m",$row['runtime']);
                                                    echo '</div>
                                                    <div class="movie-title">
                                                        <h1><a href="'.base_url('watch/'.$row['slug']).'.html"><b>'.$row['title'].'</b></a></h1>
                                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> '.$time.'</span></p>
                                                    </div>
                                                </div>
                                            </div>';

                                            }
                                            if ($SHOW_ME_JUST_20 == 20){
                                                $i == 27;
                                            }
                                        } 
                                    }
                                    $counter++;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Latest Movies -->

            <!-- New TV Series -->
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="movie-heading overflow-hidden"> <span>Nové seriály</span>
                        <div class="disable-bottom-line"></div>
						<a href="<?php echo base_url();?>tv-series.html" class="btn btn-success btn-sm pull-right">Více<i class="fa fa-angle-double-right m-l-10" aria-hidden="true"></i></a>
                    </div>
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($new_tv_series as $tv_series) :?>
                                <?php if($tv_series->is_tvseries == "1"): ?>
                                <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($tv_series->videos_id,$tv_series->title_en); ?>" alt="<?php echo $tv_series->title;?>"> <a href="<?php echo base_url('tv-series/watch/'.$tv_series->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                         <div class="video_quality"><span class="label label-primary"><?php echo $tv_series->release ?></span></div>
                                        <?php if($tv_series->video_quality == "HD"): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                        <?php else: ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                        <?php endif; ?>

                                         <?php if($tv_series->cze_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                        <?php endif; ?>

                                        <?php if($tv_series->cze_sub != NULL): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">    
                                        <?php endif; ?>
										
										<?php if($tv_series->de_lang != NULL): ?>
										<span><img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png"></span>
                                        <span><img src="<?php echo base_url();?>assets/front_end/images/de.png"></span>
										<?php endif; ?>

                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('tv-series/watch/'.$tv_series->slug).'.html';?>"><?php echo "<b>".$tv_series->title."</b>";?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php $time = str_replace("M","m",$tv_series->runtime); echo $time; ?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $tv_series->total_view;?>x shlédnuto</span>--> </p>
                                    </div>
                                </div>
                            </div>
                                <?php else: ?>
                                     <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($tv_series->videos_id,$tv_series->title_en); ?>" alt="<?php echo $tv_series->title;?>"> <a href="<?php echo base_url('watch/'.$tv_series->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                         <div class="video_quality"><span class="label label-primary"><?php echo $tv_series->release ?></span></div>
                                        <?php if($tv_series->video_quality = "HD"): ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                          <?php else: ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                        <?php endif; ?>

                                         <?php if($tv_series->cze_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                        <?php endif; ?>

                                        <?php if($tv_series->cze_sub != NULL): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">    
                                        <?php endif; ?> 

                                         <?php if($tv_series->cze_sub != NULL): ?>
                                        <span><img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png"></span>
                                        <span><img src="<?php echo base_url();?>assets/front_end/images/de.png"></span>
                                        <?php endif; ?> 
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('watch/'.$tv_series->slug).'.html';?>"><?php echo "<b>".$tv_series->title."</b>";?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php $time = str_replace("M","m",$tv_series->runtime); echo $time; ?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $tv_series->total_view;?>x shlédnuto</span>--> </p>
                                    </div>
                                </div>
                            </div>
                                <?php endif; ?>    
                           
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End New TV Series -->
            <!-- Latest TV Series -->
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="movie-heading overflow-hidden"> <span>Nejvíce sledované seriály</span>
                        <div class="disable-bottom-line"></div>
                        <a href="<?php echo base_url();?>tv-series.html" class="btn btn-success btn-sm pull-right">Více<i class="fa fa-angle-double-right m-l-10" aria-hidden="true"></i></a>
                    </div>
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($latest_tv_series as $tv_series) :?>
                            <?php if($tv_series->is_tvseries == "1"): ?>
                                <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($tv_series->videos_id,$tv_series->title_en); ?>" alt="<?php echo $tv_series->title;?>"> <a href="<?php echo base_url('tv-series/watch/'.$tv_series->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                         <div class="video_quality"><span class="label label-primary"><?php echo $tv_series->release ?></span></div>
                                        <?php if($tv_series->video_quality == "HD"): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                        <?php else: ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                        <?php endif; ?>

                                         <?php if($tv_series->cze_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                        <?php endif; ?>

                                        <?php if($tv_series->cze_sub != NULL): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">    
                                        <?php endif; ?> 
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('tv-series/watch/'.$tv_series->slug).'.html';?>"><?php echo "<b>".$tv_series->title."</b>";?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php $time = str_replace("M","m",$tv_series->runtime); echo $time; ?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $tv_series->total_view;?>x shlédnuto</span>--> </p>
                                    </div>
                                </div>
                            </div>
                                <?php else: ?>
                                <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="latest-movie-img-container">
                                    <div class="movie-img"> <img class="img-responsive" src="<?php echo $this->common_model->get_video_thumb_url($tv_series->videos_id,$tv_series->title_en); ?>" alt="<?php echo $tv_series->title;?>"> <a href="<?php echo base_url('watch/'.$tv_series->slug).'.html';?>" class="ico-play ico-play-sm"> <img class="img-responsive play-svg svg" src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg" alt="play" onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"> </a>
                                        <div class="overlay-div"></div>
                                         <div class="video_quality"><span class="label label-primary"><?php echo $tv_series->release ?></span></div>
                                        <?php if($tv_series->video_quality == "HD"): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/hd.png">
                                        <?php else: ?>
                                            <img src="<?php echo base_url();?>assets/front_end/images/sd.png">
                                        <?php endif; ?>

                                         <?php if($tv_series->cze_lang != NULL): ?>
                                            <span><img src="<?php echo base_url();?>assets/front_end/images/cs.png"></span>
                                        <?php endif; ?>

                                        <?php if($tv_series->cze_sub != NULL): ?>
                                        <img src="<?php echo base_url();?>assets/front_end/images/cs-cc.png">
                                        <img src="<?php echo base_url();?>assets/front_end/images/en.png">   
                                        <?php endif; ?> 
                                    </div>
                                    <div class="movie-title">
                                        <h1><a href="<?php echo base_url('watch/'.$tv_series->slug).'.html';?>"><?php echo "<b>".$tv_series->title."</b>";?></a></h1>
                                        <p class="movie-desc"> <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php $time = str_replace("M","m",$tv_series->runtime); echo $time; ?></span><!--<span>&nbsp;&#47;</span> <span><?php echo $tv_series->total_view;?>x shlédnuto</span>--> </p>
                                    </div>
                                </div>
                            </div>
                                <?php endif; ?> 

                            
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Latest TV Series -->



        </div>
    </div>
</div>

<!-- Secondary Section -->
<style>
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>

<script type="text/javascript">
    window.my_mute = false;

$('#my_mute_button').bind('click', function(){

    $('audio,video').each(function(){

        if (!my_mute ) {

            if( !$(this).paused ) {
                $(this).data('muted',true); //Store elements muted by the button.
                $(this).pause(); // or .muted=true to keep playing muted
            }

        } else {

            if( $(this).data('muted') ) {
                $(this).data('muted',false);
                $(this).play(); // or .muted=false
            }

        }
    });

    my_mute = !my_mute;

});
</script>

<?php
global $db;
function CheckIfExist2($title){

    $stmt = $db->prepare('SELECT * FROM videos WHERE title_en=?');
    $stmt->bindParam(1, $title, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if( ! $row)
    {
        return "Not exist";
    } else { return "Exist"; }
}

function CheckIfExist($title) {
        $db2=new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING, PDO::ATTR_PERSISTENT=>true]);
    $db2->exec("set names utf8");
    $stmt = $db2->query('SELECT COUNT(*) AS num FROM videos WHERE title_en = "'.$title.'" LIMIT 2;');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row['num'] > 0){
        return 'Exist';
    } else{
        return 'Not exist';
    }
}
?>