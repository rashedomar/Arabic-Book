<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-plus-circle"></span> إضافة مستخدم جديد</h4>
            </div>
            <div class="col-lg-12">
                <form action="<?php echo url('/admin/users/submit'); ?>" method="post" id="add-form">
                    <div id="message"></div>
                    <div class="form-group col-sm-6">
                        <label>الأسم الأول</label>
                        <input class="form-control" name="first-name" placeholder="الاسم الأول" type="text">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>الأسم الأخير</label>
                        <input class="form-control" name="last-name" placeholder="الاسم الأخير" type="text">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>البريد الإلكتروني </label>
                        <input class="form-control" name="email" placeholder="البريد الإلكتروني " type="email">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>مجموعة المستخدم</label>
                        <select name="users-group-id" class="form-control">
                            <option></option>
                            <?php
                            foreach ($usersGroups as $ug) { ?>
                                <option value="<?php echo $ug->id; ?>"><?php echo $ug->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label> كلمة المرور </label>
                        <input class="form-control" name="password" placeholder="كلمة المرور " type="password">
                    </div>
                    <div class="form-group col-sm-6">
                        <label> تأكيد كلمة المرور </label>
                        <input class="form-control" name="confirm-password" placeholder=" كلمة المرور " type="password">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>الحالة </label>
                        <select class="form-control" name="status">
                            <option value="enabled" selected>تفعيل</option>
                            <option value="disabled">تعطيل</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>صورة المستخدم</label>
                        <div class="input-group">
                            <label class="input-group-btn">
                            <span class="btn btn-warning">اختر...
                                 <input type="file" name="image" style="display: none;">
                            </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <div class="clearfix"></div>
                    <button type="submit" class="btn btn-primary btn-lg center-block" id="submit-btn-add">إضافة</button>
                    <!-- /.box-body -->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->