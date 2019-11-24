<div class="book-container tp-border">
    <div class="register-body col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="h4 text-center">كيف يمكننا المساعدة؟</div>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="<?php echo url('/contact/submit'); ?>" method="post" id="SiteForm">
                            <?php if ($success) { ?>
                                <div class="alert alert-success"><?php echo $success; ?></div>
                            <?php } ?>
                            <div id="form-results"></div>
                            <div class="form-group col-sm-12">
                                <label>الاسم</label>
                                <input class="form-control" name="name" placeholder="اسم المٌرسل" type="text">
                            </div>
                            <div class="form-group col-sm-12">
                                <label> البريد الإلكتروني </label>
                                <input class="form-control" name="email" placeholder="البريد الإلكتروني " type="email">
                            </div>
                            <div class="form-group col-sm-12">
                                <label>العنوان</label>
                                <input class="form-control" name="title" placeholder="عنوان الرسالة" type="text">
                            </div>
                            <div class="form-group col-sm-12">
                                <label>الرسالة</label>
                                <textarea class="form-control" name="message" placeholder="الرسالة..."></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <?php echo $recaptcha; ?>
                            </div>
                            <input type="hidden" name="token" value="<?php echo $token; ?>">
                            <div class="clearfix"></div>
                            <button type="button" class="btn btn-primary btn-lg center-block submit-btn">ارسال</button>
                            <!-- /.box-body -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>