<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-envelope"></span> خيارات SMTP </h4>
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
                        <label>حالة SMTP </label>
                        <select class="form-control" name="smtp_status">
                            <option value="enabled">تفعيل</option>
                            <option value="disabled" <?php echo $settings->smtp_status == 'disabled' ? 'selected' : false; ?> >
                                تعطيل
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>مزود الخدمة</label>
                        <input type="text" name="smtp_host" class="form-control"
                               value="<?php echo ! empty($settings->smtp_host) ? $settings->smtp_host : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label> اسم المستخدم</label>
                        <input type="text" name="smtp_username" class="form-control"
                               value="<?php echo ! empty($settings->smtp_username) ? $settings->smtp_username : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label> كلمة المرور</label>
                        <input type="password" name="smtp_password" class="form-control"
                               value="<?php echo ! empty($settings->smtp_password) ? $settings->smtp_password : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>المنفذ</label>
                        <input type="text" name="smtp_port" class="form-control"
                               value="<?php echo ! empty($settings->smtp_port) ? $settings->smtp_port : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>التشفير</label>
                        <input type="text" name="smtp_secure" class="form-control"
                               value="<?php echo ! empty($settings->smtp_secure) ? $settings->smtp_secure : ''; ?>">
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