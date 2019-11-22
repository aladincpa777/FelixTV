<?php 
$success_msg    =   $this->session->flashdata('success');
$error_msg      =   $this->session->flashdata('error');  
?>
<!-- Breadcrumb -->
<div id="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase">
                        Změna hesla
                    </h1>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i>Domů</a>
                    </li>
                    <li class="active">Změna hesla</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->


<!-- Profile Section -->
<div id="section-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="profiles-wrap">
                    <div class="sidebar">
                        <div class="sidebar-menu">
                            <div class="sb-title"><i class="fa fa-navicon mr5"></i> Menu</div>
                            <ul>
                                <li class="">
                                    <a href="<?php echo base_url('my-account/profile'); ?>">
                                        <i class="fi ion-ios-person-outline m-r-10"></i> Profil
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo base_url('my-account/favorite'); ?>">
                                        <i class="fi ion-ios-heart-outline m-r-10"></i>Oblíbené
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo base_url('my-account/watch-later'); ?>">
                                        <i class="fi ion-ios-clock-outline m-r-10"></i> Sledovat později
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo base_url('my-account/update'); ?>">
                                        <i class="fi ion-edit m-r-10"></i> Aktualizovat profil
                                    </a>
                                </li>
                                <li class="">
                                    <a href="<?php echo base_url('my-account/change-password'); ?>">
                                        <i class="fi ion-key m-r-10"></i> Změna hesla
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="<?php echo base_url('my-account/add-movie'); ?>">
                                        <i class="fi ion-archive m-r-10"></i> Přidat film
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="pp-main">
                        <div class="ppm-head">
                            <div class="ppmh-title"><i class="fa fa-key mr5"></i> Přidat film</div>
                        </div>
                        <div class="ppm-content update-content">
                                    <div class="col-sm-12">
            <?php 
            $message=$this->session->flashdata('message');
            if(isset($message) && $message !=''){
            echo $message;
            }
            ?>
        </div>

        <div class="col-lg-6 col-md-offset-3">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Movie Scrapper</h3>
                </div>

                <?php echo form_open(base_url() . 'admin/movie_scrapper/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>

                <div class="panel-body">
                    <div class="form-group m-b-0">
                        <div class="form-group">
                            <div class="animated-checkbox checkbox-inline">
                                <label>
                                    <input type="checkbox" name='publication' value="1"><span class="label-text">Publish</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="animated-checkbox checkbox-inline">
                                <label>
                                    <input type="checkbox" name='fetch_trailer' value="1"><span class="label-text">Fetch Trailer</span>
                                </label>
                            </div>
                        </div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="" name="movie_list" placeholder="Enter movie title.use ',' comma to separate " required="">
                            <span class="input-group-btn">
                                <button type="submit" id="import_btn" class="btn btn-primary w-sm waves-effect waves-light"> Start Scraping</button>
                            </span>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <div id="result"></div>
                </div>
            </div>
        </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Section -->