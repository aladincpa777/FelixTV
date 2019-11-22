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
                                <li class="active">
                                    <a href="<?php echo base_url('my-account/change-password'); ?>">
                                        <i class="fi ion-key m-r-10"></i> Změna hesla
                                    </a>
                                </li>
                                <!-- <li class="">
                                    <a href="<?php echo base_url('my-account/add-movie'); ?>">
                                        <i class="fi ion-archive m-r-10"></i> Přidat film
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="pp-main">
                        <div class="ppm-head">
                            <div class="ppmh-title"><i class="fa fa-key mr5"></i> Změna hesla</div>
                        </div>
                        <div class="ppm-content update-content">
                            <div class="uc-form">
                                <form id="profile-form" action="<?php echo base_url().'user/change_password/update'; ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                <?php 
                                    if($success_msg !=''){
                                    echo '<div class="alert alert-success">'.$success_msg.'.</div>';
                                    }
                                    if($error_msg !=''){
                                    echo '<div class="alert alert-danger">'.$error_msg.'.</div>';
                                    }
                                ?>
                                    
                                    <div class="form-group">
                                        <label for="password" class="col-sm-4 control-label">Aktuální heslo</label>

                                        <div class="col-sm-8">
                                            <input name="password" type="password" class="form-control" id="full_name" value="" placeholder="Zadej staré heslo" required>

                                            <span id="error-full_name" class="help-block error-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password" class="col-sm-4 control-label">Nové heslo</label>

                                        <div class="col-sm-8">
                                            <input name="new_password" type="password" class="form-control" id="full_name" value="" placeholder="Zadej nové heslo" required>

                                            <span id="error-full_name" class="help-block error-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="retype_new_password" class="col-sm-4 control-label">Nové heslo (znovu)</label>

                                        <div class="col-sm-8">
                                            <input name="retype_new_password" type="password" class="form-control" id="full_name" value="" placeholder="Zadej nové heslo" required>

                                            <span id="error-full_name" class="help-block error-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username" class="col-sm-4 control-label"></label>

                                        <div class="col-sm-2">
                                         <button type="submit" value="submit" class="btn btn-success btn-sm m-t-20"> <span class="btn-label"><i class="fa fa-floppy-o"></i></span>Uložit </button>
                                        </div>
                                    </div>
                                </form>
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