<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20">
                    <small class="pull-left"><span class="fa fa-key"></span> <a target="_blank"
                                                                                href="https://www.google.com/recaptcha/admin">جلب
                            المفاتيح</a></small>
                    <span class="fa fa-user-secret"></span> إعدادات جوجل Recaptcha
                </h4>
            </div>
            <div class="col-lg-12">
                <form action="<?php echo $action; ?>" method="post">
                    <?php if (! empty($errors) AND $errs = explode('<br>', $errors)) { ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errs AS $err) { ?>
                                <i class="fa fa-exclamation-circle"></i> <?php echo $err; ?>
                                <br>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if ($success) { ?>
                        <div class="alert alert-icon alert-success">
                            <i class="fa fa-check"></i><?php echo $success; ?>
                        </div>
                    <?php } ?>
                    <div class="form-group col-sm-12">
                        <label>Site Key</label>
                        <input type="text" name="recaptcha_key" class="form-control"
                               value="<?php echo ! empty($settings->recaptcha_key) ? $settings->recaptcha_key : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Secret Key</label>
                        <input type="text" name="recaptcha_secret" class="form-control"
                               value="<?php echo ! empty($settings->recaptcha_secret) ? $settings->recaptcha_secret : ''; ?>">
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </form>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- End #page-right-content -->