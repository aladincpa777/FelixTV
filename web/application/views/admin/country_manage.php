<div class="card">
    <div class="row">
        <div class="col-sm-12">
                <button data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/country_add';?>" id="menu" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo tr_wd('add_country'); ?></button>
                <br>
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo tr_wd('name'); ?></th>
                            <th><?php echo tr_wd('slug'); ?></th>
                            <th><?php echo tr_wd('description'); ?></th>
                            <th><?php echo tr_wd('status'); ?></th>
                            <th><?php echo tr_wd('option'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; foreach ($countries as $country):?>
                        <tr id='row_<?php echo $country['country_id'];?>'>
                            <td><?php echo $sl++;?></td>
                            <td><strong><?php echo $country['name'];?></strong></td>
                            <td><?php echo $country['slug'];?></td>
                            <td><?php echo $country['description'];?></td>
                            <td>
                                <?php
                                    if($country['publication']=='1'){
                                        echo '<span class="label label-primary label-xs">Published</span>';
                                    }
                                    else{
                                        echo '<span class="label label-warning label-mini">Unublished</span>';
                                    }
                                ?>
                            </td>                                    
                            <td>
                                <div class="btn-group m-b-20"> <a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/country_edit/'. $country['country_id'];?>" id="menu" title="<?php echo tr_wd('edit'); ?>" class="btn btn-icon"><i class="fa fa-pencil"></i></a> <a title="<?php echo tr_wd('delete'); ?>" class="btn btn-icon" onclick="delete_row(<?php echo " 'country' ".','.$country['country_id'];?>)" class="delete"><i class="fa fa-remove"></i></a> </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
        </div>
        <!-- end col-12 -->
    </div>
</div>

    
<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();
    });
</script>