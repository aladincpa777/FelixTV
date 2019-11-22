<?php
$path = $_GET['video'];
?>

<html>
<head></head>
<body>


                                  <video id="play" class="video-js sleev vjs-16-9" >

                                   
                                           <!-- <track src="<?php echo $file_url; ?>/captions_cz.vtt" kind="captions" srclang="cz" label="Čeština" />
                                            <track src="<?php echo $file_url; ?>/captions_en.vtt" kind="captions" srclang="en" label="Angličtina" />-->

                                   </video>
                                    <script>
                                        var Player = videojs("play", { 
                                        "controls": true, 
                                        "autoplay": false, 
                                        "preload": "auto" ,
                                        "playbackRates": [0.5, 1, 1.5, 2],
                                        "width": 640,
                                        "height": 265,
                                        sources: [{
                                                        src: '<?php echo $path; ?>',
                                                        type: 'video/mp4',
                                                        label: '480p',
                                                        preload: true,
                                                        default: true,
                                                        res: '480'
                                                    } //,
                                                    // {
                                                    //    src: '<?php echo $file_url; ?>/moviehd.mp4',
                                                    //    type: 'video/mp4',
                                                    //    preload: true,
                                                    //    label: '720p',
                                                    //   res: '720'
                                                    //}
                                                ]

                                        });videojs('play').videoJsResolutionSwitcher();
                                    </script>                     
</body>
</html>