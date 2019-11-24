<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-user-plus"></span> خيارات التسجيل </h4>
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
                        <label>إمكانية التسجيل</label>
                        <select class="form-control" name="can_register">
                            <option value="enabled">تفعيل</option>
                            <option value="disabled" <?php echo $settings->can_register == 'disabled' ? 'selected' : false; ?> >
                                تعطيل
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label> مجموعة المستخدمين الإفتراضية عند التسجيل</label>
                        <select class="form-control" name="default_users_group">
                            <?php foreach ($usersGroups AS $ug) { ?>
                                <option value="<?php echo $ug->id ?>" <?php echo $ug->id === $settings->default_users_group ? 'selected' : false; ?>><?php echo $ug->name; ?></option>
                            <?php } ?>
                        </select>
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