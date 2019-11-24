<!-- Modal -->
<div class="modal fade" id="<?php echo $target; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $heading.' <code>'.$name.'</code>'; ?> </h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo $action; ?>" id="modal-form">
                    <div id="form-results"></div>
                    <div class="form-group col-sm-6">
                        <label>الأسم الأول</label>
                        <input class="form-control" name="first-name" value="<?php echo $user->first_name; ?>"
                               placeholder="الاسم الأول" type="text">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>الأسم الأخير</label>
                        <input class="form-control" name="last-name" value="<?php echo $user->last_name; ?>"
                               placeholder="الاسم الأخير" type="text">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>البريد الإلكتروني </label>
                        <input class="form-control" name="email" value="<?php echo $user->email; ?>"
                               placeholder="البريد الإلكتروني " type="email">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>مجموعة المستخدم</label>
                        <select name="users-group-id" class="form-control">
                            <?php
                            foreach ($users_groups as $ug) { ?>
                                <option value="<?php echo $ug->id; ?>" <?php echo $ug->id == $user->user_group_id ? 'selected' : false; ?>><?php echo $ug->name; ?></option>
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
                            <option value="disabled" <?php echo $user->status == 'disabled' ? 'selected' : false; ?>>
                                تعطيل
                            </option>
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
                    <?php if (! empty($user->image)) { ?>
                        <div class="form-group col-sm-6">
                            <img class="img-circle" height="100" width="100"
                                 src="<?php echo assets('/images/'.$user->image); ?>"/>
                        </div>
                    <?php } else { ?>
                        <div class="form-group col-sm-6">
                            <img class="img-circle" height="100" width="100"
                                 src="<?php echo assets('/images/site/default-avatar.png'); ?>"/>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <div class="clearfix"></div>
                    <button id="submit-btn" class="btn btn-primary">حفظ</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>