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
                    <div class="form-group">
                        <label for="name">اسم التصنيف</label>
                        <input type="text" name="name" class="form-control" id="#name" value="<?php echo $name; ?>"
                               placeholder="اسم التصنيف">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="pages">صلاحيات لوحة التحكم</label>
                        <select class="form-control" id="pages" name="pages[]" multiple="multiple">
                            <?php
                            foreach ($pages as $page) { ?>
                                <option value="<?php echo $page['prettyURL']; ?>" <?php echo in_array($page['prettyURL'], $users_groups_pages) ? 'selected' : false; ?>><?php echo $page['desc']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <button id="submit-btn" class="btn btn-primary">حفظ</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>