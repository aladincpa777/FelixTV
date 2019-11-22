<?php $active_menu=$this->session->userdata('active_menu');
?>
 <!-- Side-Nav-->
<aside class="main-sidebar hidden-print">
    <section class="sidebar">
        <!-- Sidebar Menu-->
        <ul class="sidebar-menu">
            <li calss="<?php if($active_menu==1) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/dashboard';?>" class="waves-effect waves-light <?php if($active_menu==1) {echo "active"; } ?>" id="65"><i class="lnr lnr-home"></i><span> DASHBOARD </span> </a> </li>
            <li class="<?php if($active_menu==2) {echo "active"; } ?>"> <a href="<?php echo base_url();?>admin/country" class="waves-effect waves-light <?php if($active_menu==2) {echo "active"; } ?>" id="53"><i class="fa fa-globe"></i><span>ZEMĚ</span></a> </li>
            <li class="<?php if($active_menu==3) {echo "active"; } ?>"> <a href="<?php echo base_url();?>admin/genre" class="waves-effect waves-light <?php if($active_menu==3) {echo "active"; } ?>" id="53"><i class="fa fa-archive"></i><span>ŽÁNRY</span></a> </li>
            <li class="treeview <?php if($active_menu==4 || $active_menu==5 ) {echo "active"; } ?>"> <a href="#" class="waves-effect waves-light" ><i class="fa fa-stack-overflow"></i><span>SLIDER</span><i class="fa fa-angle-right"></i> </a>
              <ul class="treeview-menu">
                <li class="<?php if($active_menu==4) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/slider/'?>" class="waves-effect waves-light <?php if($active_menu==4) {echo "active"; } ?>"><i class="fa fa-stack-overflow"></i>SLIDER OBRÁZKY</span> </a></li>
                <li class="<?php if($active_menu==5) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/slider_setting/'?>" class="waves-effect waves-light <?php if($active_menu==5) {echo "active"; } ?>"><i class="fa fa-gears" aria-hidden="true"></i>SLIDER NASTAVENÍ</span> </a></li>
              </ul>
            </li>
            <li class="treeview <?php if($active_menu==31 || $active_menu==32 || $active_menu==33) {echo "active"; } ?>"> <a href="#" class="waves-effect waves-light" ><i class="fa fa-comment"></i><span>KOMENTÁŘE</span>&nbsp;<span class="label label-primary"><?php echo (count($this->db->get_where('comments', array('publication'=>'0'))->result_array())+count($this->db->get_where('post_comments', array('publication'=>'0'))->result_array())); ?></span><i class="fa fa-angle-right"></i> </a>
              <ul class="treeview-menu">
                <li class="<?php if($active_menu==31) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/comments/'?>" class="waves-effect waves-light <?php if($active_menu==31) {echo "active"; } ?>"><i class="fa fa-comments"></i>FILMY/TV KOMENTÁŘE</span> </a></li>
                <li class="<?php if($active_menu==33) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/comments/post_comments'?>" class="waves-effect waves-light <?php if($active_menu==33) {echo "active"; } ?>"><i class="fa fa-comments"></i>PSÁNÍ KOMENTÁŘŮ</span> </a></li>
                <li class="<?php if($active_menu==32) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/comments_setting/'?>" class="waves-effect waves-light <?php if($active_menu==32) {echo "active"; } ?>"><i class="fa fa-gears" aria-hidden="true"></i>NASTAVENÍ KOMENTÁŘŮ</span> </a></li>
              </ul>
            </li>
            <li class="treeview <?php if($active_menu==6 || $active_menu==8 || $active_menu==9) {echo "active"; } ?>"> <a href="#" class="waves-effect waves-light" ><i class="fa fa-video-camera" aria-hidden="true"></i><span>FILMY :: VIDEA</span><i class="fa fa-angle-right"></i> </a>
              <ul class="treeview-menu">
                <li class="<?php if($active_menu==6) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/videos_add/'?>" class="waves-effect waves-light <?php if($active_menu==6) {echo "active"; } ?>"><i class="fa fa-plus" aria-hidden="true"></i>NOVÝ FILM / VIDEO</span> </a></li>
                <li class="<?php if($active_menu==8) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/videos/'?>" class="waves-effect waves-light <?php if($active_menu==8) {echo "active"; } ?>"><i class="fa fa-list" aria-hidden="true"></i> VŠECHNY FILMY / VIDEOS</span> </a></li>
                <li class="<?php if($active_menu==9) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/video_type/'?>" class="waves-effect waves-light <?php if($active_menu==9) {echo "active"; } ?>"><i class="fa fa-tags" aria-hidden="true"></i> FILMY / VIDEO TYPE </span> </a></li>
              </ul>
            </li>
              <li class="<?php if($active_menu==7) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/movie_scrapper_manage/'?>" class="waves-effect waves-light <?php if($active_menu==7) {echo "active"; } ?>"><i class="fa fa-clone" aria-hidden="true"></i>MOVIE SCRAPPER</span> </a></li>
              <li class="treeview <?php if($active_menu==28 || $active_menu==29 || $active_menu==30) {echo "active"; } ?>"> <a href="#" class="waves-effect waves-light" ><i class="fa fa-film" aria-hidden="true"></i><span>TV SERIÁLY</span><i class="fa fa-angle-right"></i> </a>
              <ul class="treeview-menu">
                <li class="<?php if($active_menu==29) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/tvseries_add/'?>" class="waves-effect waves-light <?php if($active_menu==29) {echo "active"; } ?>"><i class="fa fa-plus" aria-hidden="true"></i>NOVÝ TV SERIÁL</span> </a></li>
                <li class="<?php if($active_menu==30) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/tvseries/'?>" class="waves-effect waves-light <?php if($active_menu==30) {echo "active"; } ?>"><i class="fa fa-list" aria-hidden="true"></i> VŠECHNY TV SERIÁLY</span> </a></li>
                <li class="<?php if($active_menu==28) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/tv_series_setting/'?>" class="waves-effect waves-light <?php if($active_menu==28) {echo "active"; } ?>"><i class="fa fa-gear" aria-hidden="true"></i>NASTAVENÍ</span> </a></li>
              </ul>
            </li>            
            <li class="treeview <?php if($active_menu==10 || $active_menu==11) {echo "active"; } ?>"> <a href="#" class="waves-effect waves-light" ><i class="fa fa-file" aria-hidden="true"></i><span>STRÁNKY</span><i class="fa fa-angle-right"></i> </a>
              <ul class="treeview-menu">
                <li class="<?php if($active_menu==10) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/pages_add/'?>" class="waves-effect waves-light <?php if($active_menu==10) {echo "active"; } ?>"><i class="fa fa-plus" aria-hidden="true"></i>NOVÁ STRÁNKA</span> </a></li>
                <li class="<?php if($active_menu==11) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/pages/'?>" class="waves-effect waves-light <?php if($active_menu==11) {echo "active"; } ?>"><i class="fa fa-list" aria-hidden="true"></i> VŠECHNY STRÁNKY </span> </a></li>
              </ul>
            </li>
            <li class="treeview <?php if($active_menu==12 || $active_menu==13 || $active_menu==14) {echo "active"; } ?>"> <a href="#" class="waves-effect waves-light" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span>POST</span> <i class="fa fa-angle-right"></i></a>
              <ul class="treeview-menu">
                <li class="<?php if($active_menu==12) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/posts_add/'?>" class="waves-effect waves-light <?php if($active_menu==12) {echo "active"; } ?>"><i class="fa fa-plus" aria-hidden="true"></i>NOVÝ POST</span> </a></li>
                <li class="<?php if($active_menu==13) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/posts/'?>" class="waves-effect waves-light <?php if($active_menu==13) {echo "active"; } ?>"><i class="fa fa-list" aria-hidden="true"></i> VŠECHNY POSTY </span> </a></li>
                <li class="<?php if($active_menu==14) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/post_category/'?>" class="waves-effect waves-light <?php if($active_menu==14) {echo "active"; } ?>"><i class="fa fa-tags" aria-hidden="true"></i> KATEGORIE </span> </a></li>
              </ul>
            </li>
            <li class="<?php if($active_menu==25) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/manage_star'?>" class="waves-effect waves-light <?php if($active_menu==25) {echo "active"; } ?>" id="53"><i class="fa fa-users"></i><span>HEREC / SPISOVATEL..</span></a></li>
            <li class="<?php if($active_menu==15) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/manage_user'?>" class="waves-effect waves-light <?php if($active_menu==13) {echo "active"; } ?>" id="53"><i class="fa fa-user"></i><span>UŽIVATELÉ</span></a></li>

            <li class="treeview <?php if($active_menu==16 || $active_menu==17 || $active_menu==18 || $active_menu==19 || $active_menu==20 || $active_menu==21 || $active_menu==22 || $active_menu==24) {echo "active"; } ?>"> <a href="#" class="waves-effect waves-light" ><i class="fa fa-gears" aria-hidden="true"></i><span>NASTAVENÍ</span> <i class="fa fa-angle-right"></i></a>
              <ul class="treeview-menu">
                <li class="<?php if($active_menu==16) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/general_setting/'?>" class="waves-effect waves-light <?php if($active_menu==16) {echo "active"; } ?>"><i class="fa fa-gear" aria-hidden="true"></i>OBECNÉ NASTAVENÍ</span> </a></li>
                <li class="<?php if($active_menu==17) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/email_setting/'?>" class="waves-effect waves-light <?php if($active_menu==17) {echo "active"; } ?>"><i class="fa fa-envelope" aria-hidden="true"></i>EMAIL NASTAVENÍ</span> </a></li>
                <li class="<?php if($active_menu==18) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/logo_setting/'?>" class="waves-effect waves-light <?php if($active_menu==18) {echo "active"; } ?>"><i class="fa fa-picture-o" aria-hidden="true"></i> LOGO &amp; FAVICON</span> </a></li>
                <li class="<?php if($active_menu==19) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/footer_setting/'?>" class="waves-effect waves-light <?php if($active_menu==19) {echo "active"; } ?>"><i class="fa fa-list-alt" aria-hidden="true"></i> FOOTER OBSAH </span> </a></li>
                <li class="<?php if($active_menu==20) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/seo_setting/'?>" class="waves-effect waves-light <?php if($active_menu==20) {echo "active"; } ?>"><i class="fa fa-facebook" aria-hidden="true"></i> SEO &amp; SOCIALS </span> </a></li>
                <li class="<?php if($active_menu==21) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/ad_setting/'?>" class="waves-effect waves-light <?php if($active_menu==21) {echo "active"; } ?>"><i class="fa fa-dollar" aria-hidden="true"></i> REKLAMY &amp; BANNERY </span> </a></li>
                <li class="<?php if($active_menu==22) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/social_login_setting/'?>" class="waves-effect waves-light <?php if($active_menu==22) {echo "active"; } ?>"><i class="fa fa-dollar" aria-hidden="true"></i> SOCIAL LOGIN</span> </a></li>
                <li class="<?php if($active_menu==24) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/video_quality/'?>" class="waves-effect waves-light <?php if($active_menu==24) {echo "active"; } ?>"><i class="fa fa-signal" aria-hidden="true"></i> FILMY / VIDEO KVALITY </span> </a></li>

              </ul>
            </li>
            <li class="<?php if($active_menu==23) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/backup_restore'?>" class="waves-effect waves-light <?php if($active_menu==23) {echo "active"; } ?>" id="53"><i class="fa fa-database"></i><span>ZÁLOHA</span></a></li>
            <li class="<?php if($active_menu==100) {echo "active"; } ?>"> <a href="<?php echo base_url().'admin/manage_reports'?>" class="waves-effect waves-light <?php if($active_menu==100) {echo "active"; } ?>" id="100"><i class="fa fa-flag"></i><span>REPORTS</span></a></li>
        </ul>
    </section>
</aside>
        