<body class="horizontal-layout horizontal-menu 1-column  bg-full-screen-image menu-expanded blank-page blank-page"
      data-open="hover" data-menu="horizontal-menu" data-col="1-column">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><section class="flexbox-container">
    <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1 box-shadow-2 p-0">

            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                 <div class="card-header no-border pb-0">
                    <div class="card-title text-center">
                        <img src="<?php echo base_url('userfiles/company/') . $this->config->item('logo'); ?>" class="img-responsive" alt="branding logo" width="100%">
                    </div>

                </div>
                <div class="card-content">

                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span><?php echo $this->lang->line('employee_login_panel') ?></span></p>
                    <div class="card-body">
                        <?php
                                $attributes = array('class' => 'form-horizontal form-simple', 'id' => 'login_form');
                                echo form_open('user/checklogin', $attributes);
                                ?>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control" id="user-name" name="username"
                                           placeholder="<?php echo $this->lang->line('Your Email') ?>" required>
                                <div class="form-control-position">
                                    <i class="ft-user"></i>
                                </div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="password" class="form-control" id="user-password" name="password"
                                           placeholder="<?php echo $this->lang->line('Your Password') ?>" required>
                                <div class="form-control-position">
                                    <i class="fa fa-key"></i>
                                </div>
                            </fieldset>
                            <?php if ($response) {
                                    echo '<div id="notify" class="alert alert-danger" >
                            <a href="#" class="close" data-dismiss="alert">&times;</a> <div class="message">' . $response . '</div>
                        </div>';
                                } ?>

                                <?php if ($this->aauth->get_login_attempts() > 1 && $captcha_on) {
                                    echo '<script src="https://www.google.com/recaptcha/api.js"></script>
									<fieldset class="form-group position-relative has-icon-left">
                                      <div class="g-recaptcha" data-sitekey="' . $captcha . '"></div>
                                    </fieldset>';
                                } ?>
                            <div class="form-group row">
                                <div class="col-md-6 col-12 text-center text-sm-left">
                                    <fieldset>
                                        <input type="checkbox" id="remember-me" class="chk-remember" name="remember_me">
                                        <label for="remember-me"> <?php echo $this->lang->line('remember_me') ?></label>
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-12 float-sm-left text-center text-sm-right"><a href="<?php echo base_url('user/forgot'); ?>" class="card-link"><?php echo $this->lang->line('forgot_password') ?>?</a></div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-block"><i class="ft-unlock"></i> <?php echo $this->lang->line('login') ?></button>
                        </form>
                    </div>
                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>Are you a client ?</span></p>
                    <div class="card-body">
                        <a href="<?php echo base_url('crm'); ?>" class="btn btn-outline-danger btn-block"><i class="ft-user"></i> <?php echo $this->lang->line('customer_login') ?></a>
                    </div>
                </div>
            </div>

    </div>
</section>

        </div>
      </div>
    </div>