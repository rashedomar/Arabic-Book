<div class="book-container tp-border">
    <div class="register-body col-sm-12">
        <div class="row">
            <div class="col-sm-12 registerPage">
                <div class="h4 text-center">استعادة</div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-color panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">استعادة كلمة المرور<span
                                </h3>
                            </div>
                            <div class="panel-body">
                                <form action="<?php echo url('/lostpw/submit'); ?>" method="post" id="SiteForm">
                                    <div id="form-results"></div>
                                    <div class="form-group col-sm-12">
                                        <label>البريد الإلكتروني </label>
                                        <input class="form-control" name="email" placeholder="البريد الإلكتروني "
                                               type="email">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <?php echo $recaptcha; ?>
                                    </div>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                    <div class="clearfix"></div>
                                    <button type="button" class="btn btn-primary btn-lg center-block submit-btn">استعادة
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div></div></div>