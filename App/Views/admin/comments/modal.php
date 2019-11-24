<!-- Modal -->
<div class="modal fade" id="<?php echo $target; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $heading; ?> </h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo $action; ?>" id="modal-form">
                    <div id="form-results"></div>
                    <div class="form-group col-sm-12">
                        <label>التعليق</label>
                        <textarea class="form-control" name="comment"
                                  placeholder="التعليق..."><?php echo $comment; ?></textarea>
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