<!-- Modal -->
<div class="modal fade" id="<?php echo $target; ?>" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"
                    id="myModalLabel"><?php echo $heading.' <code>'.$category->name.'</code>'; ?> </h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo $action; ?>" id="modal-form">
                    <div id="form-results"></div>
                    <div class="form-group col-sm-12">
                        <label for="name">اسم التصنيف</label>
                        <input type="text" name="name" class="form-control" id="#name"
                               value="<?php echo $category->name; ?>"
                               placeholder="اسم التصنيف">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>التصنيف الأب</label> <code>عند اختيارك " لا يوجد " هذا يعني بأنه تصنيف رئيسي.</code>
                        <select class="form-control select-lookup" style="width: 100%" name="pid">
                            <option value="parent">لا يوجد</option>
                            <?php

                            show_tree($categories, 0, $category->parent_id, $category->id);
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="status">الحالة</label>
                        <select class="form-control" id="#status" name="status">
                            <option value="enabled">تفعيل</option>
                            <option value="disabled" <?php echo $category->status == 'disabled' ? 'selected' : false; ?>>
                                تعطيل
                            </option>
                        </select>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <button id="submit-btn" class="btn btn-primary">حفظ</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>
            </div>
        </div>
    </div>
</div>