<div class="clearfix"></div>
</div>
<!-- end .page-contentbar -->
</div>
<!-- End #page-wrapper -->
<div class="footer">
    <div class="text-left hidden-xs">
        <div class="copyright">
            <p class="powered pull-left">تصميم وتطوير Rashed M Omar || الإصدار : <?php echo VERSION; ?></p>
        </div>
    </div>
</div> <!-- end footer -->
<div class="modal fade" id="user-profile" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">الملف الشخصي</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo url('/admin/profile/save'); ?>" class="form-modal" id="modal-form">
                    <div id="form-results"></div>
                    <div class="form-group col-sm-6">
                        <label>الأسم الأول</label>
                        <input class="form-control" name="first-name" value="<?php echo $user->first_name; ?>"
                               placeholder="الاسم الأول" type="text">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>الأسم الأخير</label>
                        <input class="form-control" name="last-name" value="<?php echo $user->last_name; ?>"
                               placeholder="الاسم الأخير" type="text">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>البريد الإلكتروني </label>
                        <input class="form-control" name="email" value="<?php echo $user->email; ?>"
                               placeholder="البريد الإلكتروني " type="email">
                    </div>
                    <div class="form-group col-sm-6">
                        <label> كلمة المرور </label>
                        <input class="form-control" name="password" placeholder="كلمة المرور " type="password">
                    </div>
                    <div class="form-group col-sm-6">
                        <label> تأكيد كلمة المرور </label>
                        <input class="form-control" name="confirm-password" placeholder=" كلمة المرور " type="password">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>صورة المستخدم</label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                    <span class="btn btn-warning">اختر...
                                         <input type="file" name="image" style="display: none;">
                                    </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <?php if ($user->image) { ?>
                        <div class="form-group col-sm-6">
                            <img class="img-circle" height="100" width="100"
                                 src="<?php echo assets('/images/'.$user->image); ?>"/>
                        </div>
                    <?php } ?>
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
<script src="<?php echo assets('/js/jquery.min.js'); ?>"></script>
<script src="<?php echo assets('/js/bootstrap/bootstrap.min.js'); ?>"></script>
<script src="<?php echo assets('/js/tagsinput/bootstrap-tagsinput.min.js'); ?>"></script>
<script src="<?php echo assets('/js/select2/select2.min.js'); ?>"></script>
<script>
    window.onload = function () {
        var currentURL = window.location.href;
        var menu = currentURL.split('admin/')[1];
        menu = menu.split('/')[0];
        $('#' + menu).removeClass().addClass('sub-menu collapse in');
    };
    //    var elem = document.querySelector('.js-switch');
    //    var init = new Switchery(elem);

    $('.select-lookup').select2({

        dir: 'rtl'
    });

    $('.button-menu-mobile').on('click', function (e) {
        e.preventDefault();
        $('body').toggleClass('nav-collapse');
    });
    $(function () {
        $('.nav-side-menu .collapse').on('hide.bs.collapse', function () {
            $(this).prev().find('.fa').eq(1).removeClass('fa-angle-right').addClass('fa-angle-down');
        });
        $('.nav-side-menu .collapse').on('show.bs.collapse', function () {
            $(this).prev().find('.fa').eq(1).removeClass('fa-angle-down').addClass('fa-angle-right');
            $(this).find('li').addClass('sidebarLinks show');
        });
    });

    $('.open-popup').on('click', function (e) {
        e.preventDefault();
        btn = $(this);
        requesUrl = btn.data('target');
        modelTarget = btn.data('model-target');
        $.ajax({
            url: requesUrl,
            type: 'POST',
            success: function (html) {
                $('body').append(html);
                $(modelTarget).modal('show');
                $('.select-lookup').select2({

                    dir: 'rtl'
                });
            }
        });
    });

    $('#submit-btn-add').on('click', function (e) {
        e.preventDefault();
        var flag = false;

        if (flag === true) {
            return false;
        }
        btn = $(this);
        requestform = btn.parents('#add-form');
        requesturl = requestform.attr('action');
        requestdata = new FormData(requestform[0]);
        formResults = requestform.find('#message');

        $.ajax({
            url: requesturl,
            type: 'POST',
            data: requestdata,
            dataType: 'json',

            beforeSend: function () {
                flag = true;
                formResults.html('');
                btn.data('loading-text', '<i class="fa fa-spinner fa-spin"></i>').button('loading');
            },
            success: function (results) {
                if (results.errors) {
                    formResults.html('');
                    btn.button('reset');
                    results.errors.split('<br>').forEach(function (err) {
                        formResults.removeClass().addClass('alert alert-danger').append('<i class="fa fa-exclamation-circle"></i> ' + err + '.' + '<br>');
                    });
                } else {
                    if (results.success) {
                        formResults.html('');
                        btn.removeClass().addClass('btn btn-success btn-lg center-block');
                        btn.data('loading-text', '<i class="fa fa-check"></i>').button('loading');
                        setTimeout(function () {
                            if (results.redirect) {
                                window.location.href = results.redirect;
                            }
                        }, 1000);
                    }
                }

            },
            catch: false,
            processData: false,
            contentType: false
        });
    });

    $('.delete').on('click', function () {
        ConfirmDialog('هل أنت متأكد ؟');
    });

    $(document).on('click', '#submit-btn', function (e) {
        e.preventDefault();
        btn = $(this);
        requestform = btn.parents('#modal-form');
        requesturl = requestform.attr('action');
        requestdata = new FormData(requestform[0]);
        formResults = requestform.find('#form-results');
        $.ajax({
            url: requesturl,
            type: 'POST',
            data: requestdata,
            dataType: 'json',

            beforeSend: function () {
                formResults.html('');
                formResults.removeClass().addClass('alert alert-info').html('loading...');
            },
            success: function (results) {
                if (results.errors) {
                    formResults.html('');
                    results.errors.split('<br>').forEach(function (err) {
                        formResults.removeClass().addClass('alert alert-danger').append('<i class="fa fa-exclamation-circle"></i> ' + err + '<br>');
                    });
                } else {
                    if (results.success) {
                        formResults.html('');
                        formResults.removeClass().addClass('alert alert-success').html(results.success);

                    }
                }

            },
            catch: false,
            processData: false,
            contentType: false
        });
        return false;
    });

    $('#menu-toggle').click(function (e) {
        e.preventDefault();
        $('#wrapper').toggleClass('toggled');
    });

    $('.confirm-delete').on('click', function () {
        var confirmModal = $('#confirm-delete-modal');
        var id = $(this).data('id');
        var name = $(this).data('name');
        var token = $(this).data('token');
        confirmModal.data('id', id);
        confirmModal.data('name', name);
        confirmModal.data('token', token);
        confirmModal.modal('show');
    });

    $('#confirm-delete-modal').on('shown.bs.modal', function (e) {
        e.preventDefault();
        var modal = $(this);
        var id = modal.data('id');
        var name = modal.data('name');
        var token = modal.data('token');
        modal.find('#confirm-yes').data('id', id);
        modal.find('#confirm-yes').data('token', token);
        modal.find('.modal-body').append('<p> هذا العمل سيقوم بحذف جميع بيانات: <code class="code">' + name + '</code></p>');
    });

    $('#confirm-delete-modal').on('hidden.bs.modal', function (e) {
        e.preventDefault();
        $('.modal-body').empty();
        $('#confirm-yes').button('reset');
        $('#confirm-yes').removeClass().addClass('btn btn-danger');
    });

    $('#confirm-yes').on('click', function (e) {
        e.preventDefault();
        var btn = $(this);
        var id = btn.data('id');
        var token = btn.data('token');
        var target = btn.data('target') + id;
        $.ajax({
            url: target,
            type: 'POST',
            data: {'token': token},
            dataType: 'json',

            beforeSend: function () {
                btn.data('loading-text', '<i class="fa fa-spinner fa-spin"></i>').button('loading');
            },
            success: function (results) {
                if (results.success) {
                    btn.removeClass().addClass('btn btn-success');
                    btn.data('loading-text', '<i class="fa fa-check"></i>').button('loading');
                    var tr = $('#del' + id);
                    $('#confirm-delete-modal').modal('hide');
                    tr.fadeOut(function () {
                        tr.remove();
                    });
                }
            }

        });
    });

    $(document).on('change', ':file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).on('fileselect', ':file', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        }

    });

    $('.pdfOutLink').on('click', function (e) {
        e.preventDefault();

        var $btn = $(this);
        $btn.toggleClass('pdfOutLink');
        if ($btn.hasClass('pdfOutLink')) {

            $btn.parents('form').attr('action', $btn.parents('form').attr('action').replace('/url', ''));
            $btn.toggleClass('pdfInLink');
            $btn.text('الإضافة كرابط خارجي');
            $('#addPdf').replaceWith(
                '<div id="addPdf" class="form-group col-sm-6 animated shake"><label>ملف الكتاب</label><div class="input-group"><label class="input-group-btn"><span class="btn btn-warning">اختر...<input type="file" name="link" style="display: none;"></span></label><input type="text" class="form-control" readonly></div></div>');

        } else {
            $btn.addClass('pdfInLink');
            $btn.parents('form').attr('action', $btn.parents('form').attr('action') + '/url');
            $btn.text('الإضافة كملف');
            $('#addPdf').replaceWith(
                '<div id="addPdf" class="form-group col-sm-6 animated shake"><label>رابط الكتاب</label><div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span><input name="link" class="form-control" type="text"></div></div>');
        }
    });
</script>
</body>
</html>

