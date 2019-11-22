<div class="row">
  <div class="col-md-3">
    <div class="widget-small primary"><i class="icon fa fa-video-camera fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('movies') ?></h4>
            <p><b class="counter"><?php echo $this->db->get_where('videos', array('publication' => '1','is_tvseries'=>'0'))->num_rows();?></b></p>
        </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small info"><i class="icon fa fa-video-camera fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('TV-Series') ?></h4>
            <!-- <p><b class="counter"><?php echo $this->db->get_where('videos', array('publication' => '1','is_tvseries'=>'1'))->num_rows();?></b></p> -->
            <p><b><?php echo $this->db->get_where('videos', array('publication' => '1','is_tvseries'=>'1'))->num_rows();?></b></p>
        </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small warning"><i class="icon fa fa-archive fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('genre') ?></h4>
            <p><b><?php echo $this->db->get_where('genre', array('publication' => '1'))->num_rows(); ?></b></p>
        </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small danger"><i class="icon fa fa-star fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('stars') ?></h4>
            <p><b><?php echo $this->db->get('star')->num_rows(); ?></b></p>
        </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="widget-small primary coloured-icon"><i class="icon fa fa-flag fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('countries') ?></h4>
            <p><b><?php echo count($this->db->get('country')->result_array());?></b></p>
        </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small info coloured-icon"><i class="icon fa fa-file-text-o fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('pages') ?></h4>
            <p><b><?php echo $this->db->get_where('page', array('publication' => '1'))->num_rows();?></b></p>
        </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small warning coloured-icon"><i class="icon fa fa-pencil-square-o fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('posts') ?></h4>
            <p><b><?php echo $this->db->get_where('posts', array('publication' => '1'))->num_rows(); ?></b></p>
        </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small danger coloured-icon"><i class="icon fa fa-users fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('register_user') ?></h4>
            <p><b><?php echo $this->db->get('user')->num_rows(); ?></b></p>
        </div>
    </div>
  </div>
  <!-- ANALYTICS -->
  <!-- TODAY -->
    <div class="col-md-3">
    <div class="widget-small danger coloured-icon"><i class="icon fa fa-chart-pie fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('analytics_dnes') ?></h4>
            <p><b><?php 
             foreach ($seo_today as $today){
              if ($today['create_at'] == date('Y-m-d')){
               echo $today['counter'];
              } //else { echo "RIP: ".$today['create_at'];}
             } 
             ?></b></p>
        </div>
    </div>
  </div>
  <!-- YESTERDAY -->
      <div class="col-md-3">
    <div class="widget-small danger coloured-icon"><i class="icon fa fa-chart-pie fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('analytics_včera') ?></h4>
            <p><b><?php 
             foreach ($seo_today as $today){
              if ($today['create_at'] == date('Y-m-d', strtotime("-1 days"))){
               echo $today['counter'];
              } //else { echo "RIP: ".$today['create_at'];}
             } 
             ?></b></p>
        </div>
    </div>
  </div>
    <!-- FULL ANALYTICS -->
      <div class="col-md-3">
    <div class="widget-small danger coloured-icon"><i class="icon fa fa-chart-pie fa-3x"></i>
        <div class="info">
            <h4><?php echo tr_wd('analytics_celkem') ?></h4>
            <p><b><?php 
            $sum = 0;
             foreach ($seo_today as $today){
               $sum += $today['counter'];
             } 
             echo $sum;
             ?></b></p>
        </div>
    </div>
  </div>
</div>

    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo tr_wd('recent_comments') ?></h3>
          </div>
          <div class="panel-body">
            <table id="datatable-fixed-header" class="table table-striped table-bordered success">
              <thead>
                <tr>
                  <th>Název</th>
                  <th>Video</th>
                  <th>Komentáře</th>
                  <th>Komentáře Na</th>
                </tr>
              </thead>
              <tbody>
                <?php
                                    
                
                $this->db->LIMIT('5' );
                $this->db->order_by('comment_at', 'desc' );                                    
                $comments = $this->db->get('comments')->result_array();                                  
                foreach ($comments as $comment): ?>
                <tr>
                <td><?php echo $this->common_model->get_name_by_id($comment['user_id']); ?></td>
                <td><?php echo $this->common_model->get_video_title_by_id($comment['video_id']); ?></td>
                  <td><?php echo $comment['comment']; ?></td>
                  <td><?php echo $comment['comment_at']; ?></td>                 
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

        <div class="row">
        <div class="col-sm-6">
        <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo tr_wd('Nejsledovanější filmy') ?></h3>
          </div>
          <div class="panel-body">
            <table id="datatable-fixed-header" class="table table-striped table-bordered success">
              <thead>
                <tr>
                  <th>Název</th>
                  <th>Vydání</th>
                  <th>Celkové shlédnutí</th>
                </tr>
              </thead>
              <tbody>
                <?php
                                    
                
                $this->db->LIMIT('5' );
                $this->db->order_by('total_view', 'desc' );                                    
                $videos = $this->db->get_where('videos', array('publication' => '1','is_tvseries'=>'0'))->result_array();                                  
                foreach ($videos as $video): ?>
                <tr>
                  <td><a href="<?php echo base_url().'watch/'.$video['slug'].'.html'; ?>" target="_blank"><?php echo $video['title']; ?></a></td>
                  <td><a href="<?php echo base_url().'watch/'.$video['slug'].'.html'; ?>" target="_blank"><?php echo $video['release']; ?></a></td>
                  <td><a href="<?php echo base_url().'watch/'.$video['slug'].'.html'; ?>" target="_blank"><?php echo $video['total_view']; ?></a></td>                 
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo tr_wd('Nejsledovanější seriály') ?></h3>
          </div>
          <div class="panel-body">
            <table id="datatable-fixed-header" class="table table-striped table-bordered success">
              <thead>
                <tr>
                  <th>Název</th>
                  <th>Vydání</th>
                  <th>Celkové hodnocení</th>
                </tr>
              </thead>
              <tbody>
                <?php
                                    
                
                $this->db->LIMIT('5' );
                $this->db->order_by('total_view', 'desc' );                                     
                $videos = $this->db->get_where('videos', array('publication' => '1','is_tvseries'=>'1'))->result_array();                                  
                foreach ($videos as $video): ?>
                <tr>
                  <td><a href="<?php echo base_url().'watch/'.$video['slug'].'.html'; ?>" target="_blank"><?php echo $video['title']; ?></a></td>
                  <td><a href="<?php echo base_url().'watch/'.$video['slug'].'.html'; ?>" target="_blank"><?php echo $video['release']; ?></a></td>
                  <td><a href="<?php echo base_url().'watch/'.$video['slug'].'.html'; ?>" target="_blank"><?php echo $video['total_view']; ?></a></td>                 
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>

    <div class="row">
    <div class="col-sm-6">
        <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo tr_wd('Poslední článek') ?></h3>
          </div>
          <div class="panel-body">
            <table id="datatable-fixed-header" class="table table-striped table-bordered success">
              <thead>
                <tr>
                  <th>Název</th>
                  <th>Post Na</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $this->db->LIMIT('5' );
                $this->db->order_by('posts_id', 'desc' );                                    
                $posts = $this->db->get('posts')->result_array();                                  
                foreach ($posts as $post): ?>
                <tr>
                  <td><?php echo substr($post['post_title'],0,45).'..'; ?></td>
                  <td><?php echo $post['post_at']; ?></td>                 
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo tr_wd('Poslední subscriber') ?></h3>
          </div>
          <div class="panel-body">
            <table id="datatable-fixed-header" class="table table-striped table-bordered success">
              <thead>
                <tr>
                  <th>Jméno</th>
                  <th>Email</th>
                  <th>Odběratel od</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $this->db->LIMIT('5' );
                $this->db->order_by('user_id', 'desc' );                                    
                $subscribers = $this->db->get('user')->result_array();                                  
                foreach ($subscribers as $subscriber): ?>
                <tr>
                  <td><?php echo $subscriber['name']; ?></td>
                  <td><?php echo $subscriber['email']; ?></td>
                  <td><?php echo date("d.m.Y h:m:s", strtotime($subscriber['join_date'])); ?></td>                 
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>

<script src="<?php echo base_url();?>assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
<!--<script src="<?php echo base_url();?>assets/plugins/counterup/jquery.counterup.min.js"></script>
 <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.counter').counterUp({
            delay: 500,
            time: 2000
        });

    });

</script> -->