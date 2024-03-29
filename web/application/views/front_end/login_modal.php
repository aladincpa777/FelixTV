<!-- Modal login -->
<div class="modal fade modal-cuz" id="pop-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                        class="fa fa-close"></i> </button>
                <h4 class="modal-title" id="myModalLabel">ČLENSKÉ PŘIHLÁŠENÍ</h4>
            </div>
            <div class="modal-body">
                <div id="error_login" style="display: none;"></div>
                <form id="login_form" class="form-horizontal m-t-20" role="form">

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" id="username" class="form-control" placeholder="Uživatelské jméno" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="Password" id="password" class="form-control" placeholder="Heslo">
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-t-30 m-b-0">
                        <div class="col-sm-12">
                            <a href="<?php echo base_url().'login/forget_password'; ?>" class="text-dark"><i class="fa fa-lock m-r-5"></i> <?php echo tr_wd('forgot_your_password?') ?></a>
                        </div>
                    </div>



                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button id="btn-login" class="btn btn-success btn-block text-uppercase waves-effect waves-light" type="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; Přihlásit se</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer text-center"> Nemáš účet? <a id="open-register" data-dismiss="modal" data-target="#pop-signup" data-toggle="modal" title="">Připoj se!</a> </div>
        </div>
    </div>
</div>
<!-- End Modal login -->
<!-- Modal signup -->
<div class="modal fade modal-cuz" id="pop-signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                        class="fa fa-close"></i> </button>
                <h4 class="modal-title" id="myModalLabel">PŘIPOJ SE</h4>
            </div>
            <div class="modal-body">
                <!-- <p>Když se stát členy stránky, můžete použít celou řadu funkcí a nyní nejvíce vzrušující filmy.</p> -->
                <form id="signup_form" method="post" action="<?php echo base_url().'login/signup/do_signup' ?>" class="form-horizontal m-t-20" role="form">

    <div class="form-group ">
        <div class="col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" id="email" name="email" value="<?php if(isset($email)){ echo $email;} ?>" class="form-control" placeholder="email" required>
            </div>
        </div>
    </div>

    <div class="form-group ">
        <div class="col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" id="username" name="username" value="<?php if(isset($username)){ echo $username;} ?>" class="form-control" placeholder="Uživatelské jméno" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="Password" id="password" name="password" class="form-control" placeholder="Heslo">
            </div>
        </div>
    </div>



    <div class="form-group text-center m-t-40">
        <div class="col-xs-12">
            <button id="btn-login" class="btn btn-success btn-block text-uppercase waves-effect waves-light" type="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; <?php echo tr_wd('signup') ?></button>
        </div>
    </div>
</form>
            </div>
            <div class="modal-footer text-center">Již máš účet? <a id="open-register" data-dismiss="modal" data-target="#pop-login" data-toggle="modal" title="">Přihlaš se</a> </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(function() {
        /* validation */
        $("#login_form").validate({
            rules: {
                password: {
                    required: true,
                },
                username: {
                    required: true
                },
            },
            messages: {
                password: {
                    required: "prosím zadejte heslo"
                },
                username: "prosím zadejte emailovou adresu",
            },
            submitHandler: submitForm
        });
        /* validation */

        /* login submit */
        function submitForm() {
            username = $("#username").val();
            password = $("#password").val();
            user_role = $("input[name='user_role']:checked").val();

            $.ajax({

                type: 'POST',
                url: 'login/ajax_login',
                data: "username=" + username + "&password=" + password + "&user_role=" + user_role,
                dataType: 'json',
                beforeSend: function() {
                    $("#error_login").fadeOut();
                    $("#btn-login").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp; Pracuji!! &nbsp;Počkej...');
                },
                success: function(response)

                {
                    var login = response.login_status;
                    var redirect = response.redirect_url;
                    if (login == "success") {
                        setTimeout(' window.location.href = "' + redirect + '"; ', 1000);
                    } else {

                        $("#error_login").fadeIn(1000, function() {
                            $("#error_login").html('<div class="alert alert-danger"><strong>Opps!</strong> Jméno nebo Heslo nebylo nalezeno. Zkus to znova.</div>');

                            $("#btn-login").html('<i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; Přihlásit se');
                        });
                    }
                }
            });
            return false;
        }
        /* login submit */
    });
</script>
<!-- End Modal signup -->