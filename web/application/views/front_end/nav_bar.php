<?php   $about_us_enable            =   $this->db->get_where('config' , array('title'=>'about_us_enable'))->row()->value;
        $about_us_to_primary_menu   =   $this->db->get_where('config' , array('title'=>'about_us_to_primary_menu'))->row()->value;
?>
<!-- Nav Bar-->
<nav class="navbar navbar-default" role="navigation" style="padding: 0px; margin: 0px;">
    <div class="container">
        <div class="container-fluid">

            <!-- Brand and toggle get grouped for better mobile display -->

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Navigace</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand active" href="<?php echo base_url(); ?>"><i class="fi ion-ios-home-outline"></i> Domů</a> </div>

            <!-- Collect the nav links, forms, and other content for toggling -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Žánr <span class="caret"></span></a>
                        <div class="dropdown-menu row col-lg-12 three-column-navbar" role="menu">
                            <?php $all_published_genre= $this->common_model->all_published_genre();
                                            foreach ($all_published_genre as $genre):                                                
                                             ?>

                            <div class="col-md-3">
                                <ul class="menu-item list-unstyled">
                                    <li><a href="<?php echo base_url('genre/'.$genre->slug.'.html'); ?>"><?php echo $genre->name; ?></a></li>

                                </ul>
                            </div>
                            <?php endforeach; ?>


                        </div>
                    </li>
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Rok <span class="caret"></span></a>
                        <div class="dropdown-menu row col-lg-12 three-column-navbar" role="menu">
                            <?php $current_year = date("Y");
                            $end_year = $current_year - 27;
                            for($i=$current_year;$i>$end_year;$i--): ?>

                            <div class="col-md-3">
                                <ul class="menu-item list-unstyled">
                                    <li><a href="<?php echo base_url('year/'.$i.'.html'); ?>"><?php echo $i; ?></a></li>

                                </ul>
                            </div>
                            <?php endfor; ?>
                            <div class="col-md-3">
                                <ul class="menu-item list-unstyled">
                                    <li><a href="<?php echo base_url('year.html'); ?>">Více..</a></li>

                                </ul>
                            </div>


                        </div>
                    </li>
                    <li><a href="<?php echo base_url('movies.html')?>">Filmy</a></li>
                    <?php 
                    $tv_series_publish          = $this->db->get_where('config',array('title'=>'tv_series_publish'))->row()->value;
                    $tv_series_pin_primary_menu = $this->db->get_where('config',array('title'=>'tv_series_pin_primary_menu'))->row()->value;
                    if($tv_series_publish =='1' && $tv_series_pin_primary_menu =='1'):
                     ?>
                     <li><a href="<?php echo base_url('tv-series.html')?>">TV Seriály</a></li>
                <?php endif; ?>
               <!--  <?php $all_video_type_on_primary_menu= $this->common_model->all_video_type_on_primary_menu();
                                            foreach ($all_video_type_on_primary_menu as $video_type):                                                
                    ?>
                <li><a href="<?php echo base_url().'type/'.$video_type->slug?>"><?php echo $video_type->video_type;?></a></li>
                <?php endforeach; ?> -->

                 <?php 
                    $blog_enable          = $this->db->get_where('config',array('title'=>'blog_enable'))->row()->value;
                    if($blog_enable =='1'):
                     ?>
                    <li><a href="<?php echo base_url('blog.html')?>">Blog</a></li>
                    <?php endif; ?>                  
                    <?php $all_page_on_primary_menu= $this->common_model->all_page_on_primary_menu();
                                            foreach ($all_page_on_primary_menu as $pages):                                                
                    ?>
                <li><a href="<?php echo base_url().'page/'.$pages->slug?>"><?php echo $pages->page_title?></a></li>
                <?php endforeach; ?>
                <!-- <li><a href="<?php echo base_url('contact-us.html')?>">Kontakt</a></li> -->
                <!-- <li>
                     <div class="search">
                        <form action="<?php echo base_url()?>search" method="post">
                            <input name="search" type="search" class="search-box" />
                            <button type="submit">
                              <span class="search-button">
                                <span class="fa fa-search"></span>
                              </span>
                            </button>
                        </form>
                 </div>
                </li>
                 <li class="search_tools"><a href="#"><span class="fa fa-search"></span></a></li> -->



                 <form class="navbar-form navbar-left" method="post" action="<?php echo base_url()?>search">
            <div class="input-group">
              <input type="text" name="search" value="<?php if(isset($search_keyword)){ echo $search_keyword;} ?>" autocomplete="off" id="search-input" class="form-control" placeholder="Vyhledat..">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
              </span>
            </div><!-- /input-group -->
          </form>

              </ul>          
                   
            </div>
        </div>
    </div>
</nav>
<!-- typehead search  -->
 <script type="text/javascript">
    $(document).ready(function(){
        $("#search-input").autocomplete({
            source: "<?php echo base_url(); ?>/home/autocompleteajax",
                focus: function( event, ui ) {
                //$( "#search" ).val( ui.item.title ); // uncomment this line if you want to select value to search box  
                return false;
            },
            select: function( event, ui ) {
                window.location.href = ui.item.url;
            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            var inner_html = '<a href="' + item.url + '" ><div class="list_item_container"><div class="image"><img src="' + item.image + '" ></div><div class="th-title"><b>' + item.title + '</b></div><br><div class="th-title">' + item.type + '</div></div></a>';
            return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append(inner_html)
                    .appendTo( ul );
        };
    });
  </script>
<!-- bootstrap menu -->
<script>
    $(".dropdown").hover(function () {
        $(this).addClass("open");
    },function () {
        $(this).removeClass("open");
    });       

  $('.search_tools').click(function(){                    
    $(".search").toggleClass('open');
    if($(".search").hasClass("open")){
      $(this).html('<a href="#"><span class="fa fa-close"></span></a>');
    }else{
      $(this).html('<a href="#"><span class="fa fa-search"></span></a>');
    }
  });
</script>
<!-- bootstrap menu -->
<!-- Nav Bar-->