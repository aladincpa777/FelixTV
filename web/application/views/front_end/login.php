
<!-- Main Section -->
<div id="section-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h2 class="block-title text-center">Přihlášení<br>
                    <small>Přihlaš se pro přístup do profilu.</small>
                </h2>
                <div class="sendus">
                    <!-- <div class="movie-heading m-b-20"> <span>Connect With Social Profile</span>
                        <div class="disable-bottom-line"></div>
                    </div><br> -->
                    <?php if($this->session->flashdata('login_success') !=''):?>
                        <div class="alert alert-success">
                           <?php echo $this->session->flashdata('login_success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('login_error') !=''):?>
                        <div class="alert alert-danger">
                          <!-- <?php echo $this->session->flashdata('login_error'); ?> -->
                          Špatné uživatelské jméno nebo Heslo.
                        </div>
                    <?php endif; ?>
                    <?php if($this->db->get_where('config' , array('title' =>'google_login_enable'))->row()->value =='1'): ?>
                    <a class="btn btn-gplus btn-sm" href="<?php echo $login_url; ?>"> <span class="btn-label"><i class="fa fa-google-plus"></i></span>Connect with Google</a>
                    <?php endif; ?>
                    <?php if($this->db->get_where('config' , array('title' =>'facebook_login_enable'))->row()->value =='1'): ?>
                    <a class="btn btn-fb btn-sm" href="<?php echo $facebook_login_url; ?>"> <span class="btn-label"><i class="fa fa-facebook"></i></span>Connect with Facebook</a>
                    <?php endif; ?>
                    <br><br><br>
                    <div class="movie-heading m-b-20"> <span>ZADEJTE SVÉ ÚDAJE</span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <div id="contact-form">                        
                        <form class="custom-form" id="login-form" method="post" action="<?php echo base_url().'user/do_login'; ?>">
                            <input type="text" name="username" id="username" class="form-control half-wdth-field" placeholder="Přihlašovací jméno/Email" required>
                            <div id="name_error"></div>
                            <input type="password" name="password" id="password" class="form-control half-wdth-field pull-right" placeholder="Heslo" required>
                            <div id="email_error"></div>
                            <input type="hidden" name="action" value="submitform">
                            <p>Zapomenuté heslo? <a href="<?php echo base_url().'user/forget_password'; ?>">Potřebuji pomoc</a></p>
                            <div>
                                <button type="submit" value="submit" id="submit-btn" class="btn btn-success pull-right "> <span class="btn-label"><i class="fi ion-ios-unlocked-outline"></i></span>Přihlásit se </button>
                            </div>
                        </form>
                    </div>
                </div>          
                
            </div>
            <div class="col-md-6 col-xs-12">
                <h2 class="block-title text-center">Zaregistrujte se<br>
                    <small>Zaregistruj se pro přístup do profilu.</small>
                </h2>

                <div class="sendus">
                    <div class="movie-heading m-b-20"> <span>Zadejte své nové údaje</span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <?php if($this->session->flashdata('success') !=''):?>
                        <div class="alert alert-success">
                           <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('error') !=''):?>
                        <div class="alert alert-danger">
                          <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <div id="contact-form">
                        <div class="expMessage"></div>
                        <form class="custom-form" id="signup-form" method="post" action="<?php echo base_url().'user/signup/do_signup'; ?>">
                            <input type="text" name="name" id="name" class="form-control half-wdth-field" placeholder="Celé jméno" required>
                            <input type="text" name="username" id="username" class="form-control half-wdth-field" placeholder="Přihlašovací jméno" required>
                            <input type="email" name="email" id="email" class="form-control half-wdth-field" placeholder="Email" required>
                            <div id="name_error"></div>
                            <input type="password" name="password" id="password" class="form-control half-wdth-field pull-right" placeholder="Heslo" required>
                            <input type="password" name="password2" id="password2" class="form-control half-wdth-field pull-right" placeholder="Potvrď heslo" required>
                            <div id="email_error"></div>
                            <input type="hidden" name="action" value="submitform">
                            <div>
                                <button type="submit" value="submit" id="submit-btn" class="btn btn-success pull-right"> <span class="btn-label"><i class="fi ion-ios-unlocked-outline"></i></span>Zaregistrovat </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Section -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#login-form').parsley();
        $('#signup-form').parsley();
    });
</script>
<style>
    .parsley-required{
        color:red;
        list-style:none;
        margin-left:-30px;
    }
</style> 




