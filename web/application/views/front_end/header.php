<?php    
    $facebook_url               =   $this->db->get_where('config' , array('title'=>'facebook_url'))->row()->value;
    $twitter_url                =   $this->db->get_where('config' , array('title'=>'twitter_url'))->row()->value;
    $vimeo_url                  =   $this->db->get_where('config' , array('title'=>'vimeo_url'))->row()->value;
    $linkedin_url               =   $this->db->get_where('config' , array('title'=>'linkedin_url'))->row()->value;
    $youtube_url                =   $this->db->get_where('config' , array('title'=>'youtube_url'))->row()->value;
?>
<!-- Main Bar-->
<div id="primary-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-12 col-xs-12 border-right">
                <div class="logo">
                    <a href="<?php echo base_url(); ?>"> <img class="img-responsive" src="<?php echo base_url(); ?>uploads/system_logo/logo.png?<?php  echo time();?>" alt="Logo" > </a>
                    
                </div>
            </div>
        <div class="col-md-4">
        </div>
            <div class="col-md-2 col-sm-4">
            	<div class="social-icon">
            		<ul class="list-inline list-unstyled">
            			<li data-toggle="tooltip" data-placement="top" title="Autor: Saros"><a href="https://www.xbmc-kodi.cz/prispevek-felixtv-plugin" target="_blank"><i class="fa fa-tv"></i></a></li>
                        <!--<li><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_s-xclick" />
                            <input type="hidden" name="hosted_button_id" value="A695XMB6ZKEEG" />
                            <input type="image" data-placement="top" src="https://projectchimps.org/wp-content/uploads/2018/11/Paypal-Donate-Button-Image.png" border="0" height="40%" width="40%" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                        </form></li>-->
            		</ul>
            	</div>
                 <div class="social-icon">
                    <ul class="list-inline list-unstyled">

                    <!--<?php
                    if($facebook_url !=''):
                        echo '<li><a href="'.$facebook_url.'"><i class="fa fa-facebook"></i></a></li>';
                    endif;
                    if($twitter_url !=''):
                        echo '<li><a href="'.$twitter_url.'"><i class="fa fa-twitter"></i></a></li>';
                    endif;
                    if($vimeo_url !=''):
                        echo '<li><a href="'.$vimeo_url.'"><i class="fa fa-vimeo"></i></a></li>';
                    endif;
                    if($linkedin_url !=''):
                        echo '<li><a href="'.$linkedin_url.'"><i class="fa fa-linkedin"></i></a></li>';
                    endif;
                    if($youtube_url !=''):
                        echo '<li><a href="'.$youtube_url.'"><i class="fa fa-youtube"></i></a></li>';
                    endif;

                    ?>
                    </ul> -->
                </div>
            </div>
            <div class="col-md-2 col-sm-4 border-left">
                <?php if($this->session->userdata('login_status') == 1){
                    echo'<ul class="nav navbar-nav">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="img img-circle" src="'.$this->common_model->get_img('user', $this->session->userdata('user_id')).'?'.time().'" width="40">
                        '.$this->session->userdata('name').'</a> <ul class="dropdown-menu" role="menu">';
                         if($this->session->userdata('admin_is_login') == 1){
                            echo '<li><a href="'.base_url().'admin"><i class="fi ion-ios-speedometer-outline m-r-10"></i>Admin</a></li>';
                          } ?>
                <li><a href="<?php echo base_url('my-account/profile'); ?>"><i class="fi ion-ios-person-outline m-r-10"></i>Profil</a></li>
                <li><a href="<?php echo base_url('my-account/favorite'); ?>"><i class="fi ion-ios-heart-outline m-r-10"></i>Oblíbené</a></li>
                <li><a href="<?php echo base_url('my-account/watch-later'); ?>"><i class="fi ion-ios-clock-outline m-r-10"></i>Sledovat později</a></li>
                <li><a href="<?php echo base_url('my-account/update'); ?>"><i class="fi ion-edit m-r-10"></i>Aktualizovat profil</a></li>
                <li><a href="<?php echo base_url('my-account/change-password'); ?>"><i class="fi ion-key m-r-10"></i>Změna hesla</a></li>
                <li><a href="<?php echo base_url('login/logout'); ?>"><i class="fi ion-log-out m-r-10"></i>Odhlásit se</a></li>
                </ul>
                </li>
                </ul>
                <?php }else{ ?>


                <div class="login">
                <a class="btn btn-success btn-sm" href="<?php echo base_url('user/login'); ?>"> <span class="btn-label"><i class="fi ion-log-in"></i></span>Přihlásit</a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Main Bar -->