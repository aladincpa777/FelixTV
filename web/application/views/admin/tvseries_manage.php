<div class="card">
    <div class="row">
      <div class="col-sm-12">
          <a href="<?php echo base_url() . 'admin/tvseries_add';?>" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo tr_wd('add_tv_series'); ?></a> <br>
          <br>
          <?php if(count($this->db->get('videos')->result_array())>0): ?>
          <table class="table table-striped" id="datatablessd">
            <thead>
              <tr>
                <th>#</th>
                <th>###</th>
                <th><?php echo tr_wd('thumbnail'); ?></th>
                <th><?php echo tr_wd('name'); ?></th>
                <th><?php echo tr_wd('description'); ?></th>
                <th><?php echo tr_wd('total_seasion'); ?></th>
                <th><?php echo tr_wd('status'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php $sl = 1;
              if($last_row_num)
                $sl = $last_row_num + 1;
              foreach ($videos as $videos):                     

                                ?>
              <tr id='row_<?php echo $videos['videos_id'];?>'>
                <td><?php echo $sl++;?></td>                
                <td><div class="btn-group">
                    <button type="button" class="btn btn-white btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a target="_blank" href="<?php echo base_url() . 'tv-series/watch/'. $videos['slug'];?>"><?php echo tr_wd('preview'); ?></a></li>
                      <li><a  href="<?php echo base_url() . 'admin/seasons_manage/'. $videos['videos_id'];?>">Seasions &amp; Episods</a></li>
                      <li><a  href="<?php echo base_url() . 'admin/tvseries_edit/'. $videos['videos_id'];?>"><?php echo tr_wd('edit_video'); ?></a></li>
                      <li><a title="<?php echo tr_wd('delete'); ?>" href="#" onclick="delete_row(<?php echo " 'videos' ".','.$videos['videos_id'];?>)" class="delete"><?php echo tr_wd('delete'); ?></a> </li>
                    </ul>
                  </div>
                </td>
                <td><img src="<?php echo $this->common_model->get_video_thumb_url($videos['videos_id']);?>" class="img-responsive" weight="45"></td>
                <td><a target="_blank" href="<?php echo base_url() . 'tv-series/watch/'. $videos['slug'];?>"><strong><?php echo $videos['title'];?></strong></a></td>
                <td><?php echo $videos['description'];?></td>
                <td><?php
                        echo count($this->db->get_where('seasons', array('videos_id'=>$videos['videos_id']))->result_array());
                    ?> Seasons                                             
                </td>
                <td><?php
                      if($videos['publication']=='1'){
                          echo '<span class="label label-primary label-xs">Published</span>';
                      }
                      else{
                          echo '<span class="label label-warning label-mini">Unublished</span>';
                      }
                    ?>
                </td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="text-center"><h2>No video found..</h2></div>
        <?php endif; ?>
          <?php echo $links; ?>

      </div>
      <!-- end col-12 --> 
    </div>
    <!-- end row --> 

