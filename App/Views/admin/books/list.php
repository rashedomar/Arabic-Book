<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-book"></span> الكتب </h4>
            </div>
            <?php if (! empty($books)) { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th width="3%">ID</th>
                                    <th width="20%">عنوان الكتاب</th>
                                    <th width="5%">التصنيف</th>
                                    <th width="10%">المؤلف</th>
                                    <th width="7%">المُرسل</th>
                                    <th width="1%"> التحميلات</th>
                                    <th width="1%"> المشاهدات</th>
                                    <th width="5%"> الحالة</th>
                                    <th width="5%"> وقت الإضافة</th>
                                    <th width="10%"> العمليات</th>
                                </tr>
                                <?php foreach ($books as $book) {
                                    ; ?>
                                    <tr id="del<?php echo $book->id; ?>">
                                        <td><?php echo $book->id; ?></td>
                                        <td><?php echo $book->title; ?></td>
                                        <td><?php echo $book->cat_name; ?></td>
                                        <td><?php echo $book->author_name; ?></td>
                                        <td><code><?php echo $book->first_name.' '.$book->last_name; ?></code>
                                        </td>
                                        <td><?php echo $book->downloads; ?></td>
                                        <td><?php echo $book->views; ?></td>
                                        <td>
                                            <span class="label label-<?php echo $book->status == 'enabled' ? 'success' : 'danger'; ?>"><?php echo $book->status == 'enabled' ? 'مُفعل' : 'مُعطل'; ?></span>
                                        </td>
                                        <td><?php echo date('d/m/y', $book->created); ?></td>
                                        <td>
                                            <button type="button"
                                                    data-target="<?php echo url('/admin/books/edit/'.$book->id); ?>"
                                                    data-model-target="#edit-book-<?php echo $book->id; ?>"
                                                    class="btn btn-warning open-popup">تعديل
                                                <span class="fa fa-edit"></span>
                                            </button>
                                            <button type="button" data-id="<?php echo $book->id; ?>"
                                                    data-token="<?php echo $token; ?>"
                                                    data-name="<?php echo $book->title; ?>"
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
                لا يوجد كتب
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
                <button data-target="<?php echo url('/admin/books/delete/'); ?>" type="button" class="btn btn-danger"
                        id="confirm-yes">حذف
                </button>
            </div>
        </div>
    </div>
</div>
