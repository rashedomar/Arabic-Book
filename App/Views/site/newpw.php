<div class="book-container tp-border">
    <div class="register-body col-sm-12">
        <div class="row">
            <div class="col-sm-12 registerPage">
                <div class="h4 text-center">كلمة المرور الجديدة</div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-color panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">إنشاء كلمة مرور جديدة</h3>
                            </div>
                            <div class="panel-body">
                                <form action="<?php echo url('/newpw/submit'); ?>" method="post" id="SiteForm">
                                    <div id="form-results"></div>
                                    <div class="form-group col-sm-6">
                                        <label> كلمة المرور </label>
                                        <input class="form-control" name="password" placeholder="كلمة المرور "
                                               type="password">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label> تأكيد كلمة المرور </label>
                                        <input class="form-control" name="confirm-password" placeholder=" كلمة المرور "
                                               type="password">
                                    </div>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                    <input type="hidden" name="code" value="<?php echo $code; ?>">
                                    <div class="clearfix"></div>
                                    <button type="button" class="btn btn-primary btn-lg center-block submit-btn">حفظ
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