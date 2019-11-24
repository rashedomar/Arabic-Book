<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-info"></span> معلومات الموقع </h4>
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
                        <label>عنوان الموقع</label>
                        <input type="text" name="name" class="form-control"
                               value="<?php echo ! empty($settings->name) ? $settings->name : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>وصف الموقع</label>
                        <input type="text" name="desc" class="form-control"
                               value="<?php echo ! empty($settings->desc) ? $settings->desc : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>الكلمات المفتاحية</label> <code>افصل بين كل كلمة بفاصلة ,</code>
                        <input type="text" name="tags" data-role="tagsinput" class="form-control"
                               value="<?php echo ! empty($settings->tags) ? $settings->tags : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>البريد الإلكتروني للإدارة</label>
                        <input type="email" name="email" class="form-control"
                               value="<?php echo ! empty($settings->email) ? $settings->email : ''; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>عرض الـ Animations</label>
                        <select class="form-control" name="animate">
                            <option value="enabled">تفعيل</option>
                            <option value="disabled" <?php echo $settings->animate == 'disabled' ? 'selected' : false; ?> >
                                تعطيل
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>حالة الموقع</label>
                        <select class="form-control" name="status">
                            <option value="enabled">تفعيل</option>
                            <option value="disabled" <?php echo $settings->status == 'disabled' ? 'selected' : false; ?> >
                                تعطيل
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>رسالة غلق الموقع في حال تعطيله</label>
                        <textarea class="form-control" name="close_msg"
                                  placeholder="الرسالة.."><?php echo $settings->close_msg; ?></textarea>
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