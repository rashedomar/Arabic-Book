<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-pencil"></span> المؤلفين </h4>
            </div>
            <?php if (! empty($authors)) { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="40%">المؤلف</th>
                                    <th width="40%">العمليات</th>
                                </tr>
                                <?php foreach ($authors as $author) {
                                    ; ?>
                                    <tr id="del<?php echo $author->id; ?>">
                                        <td><?php echo $author->id; ?></td>
                                        <td>
                                            <img class="img-circle" style="width: 64px; height: 64px;"
                                                 src="<?php echo assets('/images/'.(empty($author->image) ? 'site/default-avatar.png' : $author->image)); ?>"/>
                                            <?php echo $author->name; ?>
                                        </td>
                                        <td>
                                            <button type="button"
                                                    data-target="<?php echo url('/admin/authors/edit/'.$author->id); ?>"
                                                    data-model-target="#edit-author-<?php echo $author->id; ?>"
                                                    class="btn btn-warning open-popup">تعديل
                                                <span class="fa fa-edit"></span>
                                            </button>
                                            <button type="button" data-id="<?php echo $author->id; ?>"
                                                    data-name="<?php echo $author->name; ?>"
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
                لا يوجد مؤلفين
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
                <button data-target="<?php echo url('/admin/authors/delete/'); ?>" type="button" class="btn btn-danger"
                        id="confirm-yes">حذف
                </button>
            </div>
        </div>
    </div>
</div>
