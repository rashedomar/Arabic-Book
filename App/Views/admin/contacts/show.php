<!-- START PAGE CONTENT -->
<div id="page-right-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20"><span class="fa fa-eye"></span> قراءة الرسالة </h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-color panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $message->title; ?> <span
                                        class="pull-left"><?php echo date('d-m-y:h:i:s A', $message->created); ?></span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <h6 class="header-title m-t-0 m-b-20">اسم المٌرسل: <?php echo $message->name; ?> | بريد
                                المٌرسل: <?php echo $message->email; ?></h6>
                            <p><?php echo $message->message; ?></p>
                        </div>
                    </div>
                    <?php if ($message->status == 0) { ?>
                        <div class="p-20 m-b-20">
                            <h4 class="m-b-30 m-t-0 header-title">الرد <span class="fa fa-reply"></span></h4>
                            <div class="col-lg-12">
                                <form action="<?php echo url('/admin/contacts/reply/'.$message->id.'/submit'); ?>"
                                      method="post" id="modal-form">
                                    <div id="form-results"></div>
                                    <div class="form-group col-sm-12">
                                        <textarea name="reply" class="form-control" rows="5"></textarea>
                                    </div>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                    <div class="clearfix"></div>
                                    <button id="submit-btn" class="btn btn-primary center-block">إرسال</button>
                                </form>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="panel panel-color panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-mail-reply"></span> تم الرد من
                                    قبل: <?php echo $message->first_name.' '.$message->last_name; ?> <span
                                            class="pull-left"><?php echo date('d-m-y:h:i:s A', $message->replied_at); ?></span>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <p><?php echo $message->reply; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /#page-content-wrapper -->
