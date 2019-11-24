<div class="book-container tp-border">
    <div class="register-body col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="h4 text-center">تم تفعيل حسابك</div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php if (empty($user)) { ?>
                            <div class="alert alert-success">تم تفعيل حسابك بنجاح ، يمكنك الآن تسجيل الدخول وتصفح الموقع
                                الآن.
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-success">تم تفعيل حسابك بنجاح ، يمكنك الآن تصفح الموقع
                                يا <?php echo $user->first_name.' '.$user->last_name; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>