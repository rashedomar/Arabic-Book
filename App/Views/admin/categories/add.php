<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-plus-circle"></span> إضافة تصنيف جديد</h4>
            </div>
            <div class="col-lg-12">
                <form action="<?php echo url('/admin/categories/submit'); ?>" method="post" id="add-form">
                    <div id="message"></div>
                    <div class="form-group">
                        <label>اسم التصنيف</label>
                        <input class="form-control" name="name" placeholder="اسم التصنيف" type="text">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>التصنيف الأب</label> <code>عند اختيارك " لا يوجد " هذا يعني بأنه تصنيف رئيسي.</code>
                        <select class="form-control select-lookup" name="pid">
                            <option value="parent" selected>لا يوجد</option>
                            <?php
                            show_tree($categories);
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="status">الحالة</label>
                        <select class="form-control" id="#status" name="status">
                            <option value="enabled" selected>تفعيل</option>
                            <option value="disabled">تعطيل</option>
                        </select>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <button type="submit" class="btn btn-primary btn-lg center-block" id="submit-btn-add">إضافة</button>
                    <!-- /.box-body -->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->