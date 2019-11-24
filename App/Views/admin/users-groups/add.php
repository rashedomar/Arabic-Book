<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-plus-circle"></span> إضافة مجموعة جديدة</h4>
            </div>
            <div class="col-lg-12">
                <form action="<?php echo url('/admin/users-groups/submit'); ?>" method="post" id="add-form">
                    <div id="message"></div>
                    <div class="form-group">
                        <label>اسم المجموعة</label>
                        <input class="form-control" name="name" placeholder="اسم المجموعة" type="text">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>صلاحيات لوحة التحكم</label> <code>كن حذراً عند اختيارك للصلاحيات المطلوبة.</code>
                        <select class="form-control" id="pages" name="pages[]" multiple="multiple">
                            <option value="" selected></option>
                            <?php
                            foreach ($pages as $page) { ?>
                                <option value="<?php echo $page['prettyURL']; ?>"><?php echo $page['desc']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <br>
                    <button type="submit" class="btn btn-primary btn-lg center-block" id="submit-btn-add">إضافة</button>
                    <!-- /.box-body -->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->