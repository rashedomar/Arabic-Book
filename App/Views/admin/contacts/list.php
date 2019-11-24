<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-envelope"></span> الرسائل </h4>
            </div>
            <?php if (! empty($messages)) { ?>
                <div class="col-sm-5">
                    <i class="label label-danger">لم يتم الرد</i>
                    <i class="label label-success">تم الرد</i>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">المُرسل</th>
                                    <th width="15%">البريد الإلكتروني</th>
                                    <th width="20%">عنوان الرسالة</th>
                                    <th width="20%">الرسالة</th>
                                    <th width="10%">وقت الإرسال</th>
                                    <th width="2%">المشاهدة</th>
                                    <th width="40%">العمليات</th>
                                </tr>
                                <?php foreach ($messages as $msg) { ?>
                                    <tr class="<?php echo $msg->status == 0 ? 'danger' : 'success'; ?>"
                                        id="del<?php echo $msg->id; ?>">
                                        <td><?php echo $msg->id; ?></td>
                                        <td>
                                            <code><?php echo (is_null($msg->first_name)) ? $msg->name : $msg->first_name.' '.$msg->last_name; ?></code>
                                        </td>
                                        <td><?php echo $msg->email; ?></td>
                                        <td><?php echo $string = mb_strlen($msg->title, 'UTF-8') > 28 ? mb_substr($msg->title, 0, 10, 'UTF-8').'...' : $msg->title; ?></td>
                                        <td><?php echo $string = (mb_strlen($msg->message, 'UTF-8') > 120) ? mb_substr($msg->message, 0, 120, 'UTF-8').'...' : $msg->message; ?></td>
                                        <td><?php echo date('d-m-y', $msg->created); ?></td>
                                        <td><?php echo $msg->opened == 0 ? ' <i style="width: 100%;text-align: center;" class="fa fa-eye"></i>' : '<i style="width: 100%;text-align: center;" class="fa fa-eye-slash"></i>'; ?></td>
                                        <td>
                                            <a href="<?php echo url('/admin/contacts/show/'.$msg->id); ?>"
                                               class="btn btn-warning">قراءة
                                                <span class="fa fa-eye"></span>
                                            </a>
                                            <button type="button" data-id="<?php echo $msg->id; ?>"
                                                    data-name="<?php echo $msg->title; ?>"
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
                لا توجد رسائل
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
                <button data-target="<?php echo url('/admin/contacts/delete/'); ?>" type="button" class="btn btn-danger"
                        id="confirm-yes">حذف
                </button>
            </div>
        </div>
    </div>
</div>
