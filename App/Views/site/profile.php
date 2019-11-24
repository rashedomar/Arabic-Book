<div class="book-container tp-border">
    <div class="profile-body col-sm-12">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <div class="pv-lg"><img class="center-block img-responsive img-circle img-thumbnail thumb96"
                                                src="<?php echo assets('/images/'.($user->image === '' ? 'site/default-avatar.png' : $user->image)); ?>"
                                                alt="Contact"></div>
                        <h3 class="m0 text-bold"><?php echo $user->first_name.' '.$user->last_name; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="h4 text-center">معلومات المستخدم</div>
                        <div class="row pv-lg">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8">
                                <form action="<?php echo url('/profile/save') ?>" id="SiteForm" method="post">
                                    <div id="form-results"></div>
                                    <div class="form-group col-sm-12">
                                        <label>الأسم الأول</label>
                                        <input class="form-control" name="first-name"
                                               value="<?php echo $user->first_name; ?>" placeholder="الاسم الأول"
                                               type="text">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>الأسم الأخير</label>
                                        <input class="form-control" name="last-name"
                                               value="<?php echo $user->last_name; ?>" placeholder="الاسم الأخير"
                                               type="text">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>البريد الإلكتروني </label>
                                        <input class="form-control" name="email" value="<?php echo $user->email; ?>"
                                               placeholder="البريد الإلكتروني " type="email">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label> كلمة المرور </label>
                                        <input class="form-control" name="password" placeholder="كلمة المرور "
                                               type="password">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label> تأكيد كلمة المرور </label>
                                        <input class="form-control" name="confirm-password" placeholder=" كلمة المرور "
                                               type="password">
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
                                    <?php if ($user->image) { ?>
                                        <div class="form-group col-sm-6">
                                            <img class="img-circle" height="100" width="100"
                                                 src="<?php echo assets('/images/'.($user->image === '' ? 'site/default-user.jpg' : $user->image)); ?>"/>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                    <div class="clearfix"></div>
                                    <div class="col-sm-12 text-center">
                                        <button type="button" class="btn btn-primary submit-btn">حفظ</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>