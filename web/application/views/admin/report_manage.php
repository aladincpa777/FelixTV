<div class="card">
    <div class="row">
        <div class="col-sm-12">
                <br>
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo tr_wd('sl'); ?></th>
                            <!-- <th><?php echo tr_wd('title'); ?></th> -->
                            <th><?php echo tr_wd('video_id'); ?></th>
                            <th><?php echo tr_wd('option'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1;
                            foreach ($reports as $report):                     

                        ?>
                        <tr id='row_<?php echo $report['video_id'];?>'>
                            <td><?php echo $sl++;?></td>
                            <!-- <td><strong><?php echo $video['title'];?></strong></td> -->
                            <td><?php echo $report['videos_id'];?></td>
                            <td>
                                <div class="btn-group m-b-20"> <a title="<?php echo tr_wd('delete'); ?>" class="btn btn-icon" onclick="delete_row(<?php echo " 'wish_list' ".','.$report['wish_list_id'];?>)" class="delete"><i class="fa fa-remove"></i></a> </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>

    <!-- select2-->
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
    <!-- select2-->