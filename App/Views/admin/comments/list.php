<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-comment"></span> التعليقات </h4>
            </div>
            <?php if (! empty($comments)) { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">كاتب التعليق</th>
                                    <th width="30%">التعليق</th>
                                    <th width="30%">الكتاب</th>
                                    <th width="40%">العمليات</th>
                                </tr>
                                <?php foreach ($comments as $comment) {
                                    ; ?>
                                    <tr id="del<?php echo $comment->id; ?>">
                                        <td><?php echo $comment->id; ?></td>
                                        <td>
                                            <code><?php echo $comment->first_name.' '.$comment->last_name; ?></code>
                                        </td>
                                        <td><?php echo $string = (mb_strlen($comment->comment, 'UTF-8') > 13) ? mb_substr($comment->comment, 0, 60, 'UTF-8').'...' : $comment->comment; ?></td>
                                        <td><?php echo $string = (mb_strlen($comment->book_title, 'UTF-8') > 13) ? mb_substr($comment->book_title, 0, 40, 'UTF-8').'...' : $comment->book_title;; ?></td>
                                        <td>
                                            <button type="button"
                                                    data-target="<?php echo url('/admin/comments/edit/'.$comment->id); ?>"
                                                    data-model-target="#edit-comment-<?php echo $comment->id; ?>"
                                                    class="btn btn-warning open-popup">تعديل
                                                <span class="fa fa-edit"></span>
                                            </button>
                                            <button type="button" data-id="<?php echo $comment->id; ?>"
                                                    data-name="<?php echo $comment->id; ?>"
                                                    data-token="<?php echo $token; ?>"
                                                    class="btn btn-danger confirm-delete">حذف
                                                <span class="fa fa-trash"></span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <?php if ($pagination->lastPage() > 1) { ?>
                            <div aria-label="Page navigation" class="col-md-offset-5">
                                <ul class="pagination">
                                    <li>
                                        <a href="<?php echo $url. 1; ?>" aria-label="First">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php if ($pagination->prePage() != 1) { ?>
                                        <li><a href="<?php echo $url.$pagination->prePage(); ?>">السابق</a></li>
                                    <?php } ?>
                                    <?php for ($page = 1; $page <= $pagination->lastPage(); $page++) { ?>
                                        <li<?php echo $page == $pagination->page() ? ' class="active" ' : false; ?>><a
                                                    href="<?php echo $url.$page; ?>"><?php echo $page; ?></a></li>
                                    <?php } ?>
                                    <?php if ($pagination->nextPage() != $pagination->lastPage()) { ?>
                                        <li><a href="<?php echo $url.$pagination->nextPage(); ?>">التالي</a></li>
                                    <?php } ?>
                                    <li>
                                        <a href="<?php echo $url.$pagination->lastPage(); ?>" aria-label="End">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                لا توجد تعليقات
            <?php } ?>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->
<!-- Modal Dialog -->
<div class="modal fade" id="confirm-delete-modal" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">حذف نهائي .. هل أنت متأكد ؟</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                <button data-target="<?php echo url('/admin/comments/delete/'); ?>" type="button" class="btn btn-danger"
                        id="confirm-yes">حذف
                </button>
            </div>
        </div>
    </div>
</div>
