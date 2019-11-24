<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-plus-circle"></span> إضافة مؤلف جديد</h4>
            </div>
            <div class="col-lg-12">
                <form action="<?php echo url('/admin/authors/submit'); ?>" method="post" id="add-form">
                    <div id="message"></div>
                    <div class="form-group col-sm-12">
                        <label>اسم المؤلف</label>
                        <input class="form-control" name="name" placeholder="اسم المؤلف" type="text">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>الوصف</label>
                        <textarea class="form-control" name="desc" placeholder="الوصف"></textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>صورة المؤلف</label>
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