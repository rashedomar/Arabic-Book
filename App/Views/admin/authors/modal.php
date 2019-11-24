<!-- Modal -->
<div class="modal fade" id="<?php echo $target; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"
                    id="myModalLabel"><?php echo $heading.' <code>'.$author->name.'</code>'; ?> </h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo $action; ?>" id="modal-form">
                    <div id="form-results"></div>
                    <div class="form-group col-sm-12">
                        <label for="name">اسم المؤلف</label>
                        <input type="text" name="name" class="form-control" id="#name"
                               value="<?php echo $author->name; ?>"
                               placeholder="اسم المؤلف">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>الوصف</label>
                        <textarea class="form-control" name="desc"
                                  placeholder="الوصف"><?php echo $author->description; ?></textarea>
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
                    <div class="form-group col-sm-6">
                        <img class="img-circle" height="100" width="100"
                             src="<?php echo assets('/images/'.(empty($author->image) ? 'site/default-avatar.png' : $author->image)); ?>"/>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <div class="clearfix"></div>
                    <button id="submit-btn" class="btn btn-primary">حفظ</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>
            </div>
        </div>
    </div>
</div>