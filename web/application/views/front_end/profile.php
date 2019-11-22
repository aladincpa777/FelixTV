<!-- Breadcrumb -->
<div id="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase">
                        Informace
                    </h1>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i>Domů</a>
                    </li>
                    <li class="active">Profil</li>
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
                                <li class="active">
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
                            <div class="ppmh-title"><i class="fa fa-user mr5"></i> Profil</div>
                        </div>
                        <div class="ppm-content user-content">
                            <div class="uct-avatar">
                                <img src="<?php echo $this->common_model->get_img('user', $profile_info->user_id).'?'.time(); ?>" title="<?php echo $profile_info->name; ?>" alt="<?php echo $profile_info->name; ?>">
                            </div>
                            <div class="uct-info">
                                <div class="block">
                                    <label>Celé jméno:</label> <?php echo $profile_info->name; ?></div>
                                <div class="block">
                                    <label>Uživatelské jméno:</label> <?php echo $profile_info->username; ?> </div>
                                <div class="block">
                                    <label>ID účtu:</label> <?php echo $profile_info->user_id; ?> </div>
                                <div class="block">
                                    <label>Email:</label> <?php echo $profile_info->email; ?> </div>
                                <div class="block">
                                    <label>Pohlaví:</label> <?php if($profile_info->gender=='1'){echo 'Muž';}elseif($profile_info->gender=='2'){echo 'Žena';}else{ echo 'N/a';} ?> </div>
                                <div class="block">
                                    <label>Datum registrace:</label> <?php echo date('d M Y',strtotime($profile_info->join_date)); ?></div>
                                <div class="block">
                                    <label>Poslední přihlášení:</label> <?php echo date('Y-m-d H:i:s',strtotime($profile_info->last_login)); ?> </div>
                                <div class="mt20">
                                    <a href="<?php echo base_url('my-account/update'); ?>" class="btn btn-success" title="">Upravit informace o účtu</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Section -->
