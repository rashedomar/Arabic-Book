<!-- Modal -->
<div class="modal fade" id="<?php echo $target; ?>" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $heading.' <code>'.$book->title.'</code>'; ?> </h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo $action.(isLink($book->link) === true ? '/url' : ''); ?>" id="modal-form">
                    <div id="form-results"></div>
                    <div class="form-group col-sm-12">
                        <label>العنوان</label>
                        <input class="form-control" name="title" value="<?php echo $book->title; ?>"
                               placeholder="العنوان"
                               type="text">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>الوصف</label>
                        <textarea class="form-control" name="desc"
                                  placeholder="نبذة عن الكتاب"><?php echo $book->description; ?></textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label> تصنيف الكتاب</label>
                        <select class="form-control select-lookup" name="category" style="width: 100%">
                            <?php
                            show_tree($categories, 0, $book->category_id);
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>المؤلف</label>
                        <select name="author" class="form-control select-lookup" style="width: 100%">
                            <?php
                            foreach ($authors as $author) { ?>
                                <option value="<?php echo $author->id; ?>" <?php echo $book->author_id === $author->id ? 'selected' : false; ?>><?php echo $author->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>الحالة </label>
                        <select class="form-control" name="status">
                            <option value="enabled" selected>تفعيل</option>
                            <option value="disabled" <?php echo $book->status == 'disabled' ? 'selected' : false; ?>>
                                تعطيل
                            </option>
                        </select>
                    </div>
                    <?php if (! isLink($book->link)) { ?>
                        <div class="form-group col-sm-12">
                            <label>ملف الكتاب</label>
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-warning">اختر...
                                         <input type="file" name="link" style="display: none;">
                                    </span>
                                </label>
                                <input type="text" class="form-control" value="<?php echo $book->link; ?>" readonly>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group col-sm-12">
                            <label>رابط الكتاب</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                <input type="text" name="link" class="form-control" value="<?php echo $book->link; ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group col-sm-6">
                        <label>صورة الكتاب</label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                    <span class="btn btn-warning">اختر...
                                         <input type="file" name="image" style="display: none;">
                                    </span>
                            </label>
                            <input type="text" class="form-control" value="<?php echo $book->image; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <img class="img-thumbnail" height="100" width="100"
                             src="<?php echo assets('/images/'.(empty($book->image) ? 'site/default-book.jpg' : $book->image)); ?>"/>
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