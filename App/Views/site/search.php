<div class="book-container tp-border">
    <div class="register-body col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <?php if (! $results) { ?>
                    <div class="alert alert-info">عذراً لا توجد نتائج!</div>
                <?php } else { ?>
                    <div class="alert alert-success text-center">نتائج البحث</div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php foreach ($results AS $book) { ?>
                            <div class="col-lg-3 col-md-4 col-xs-6 text-center">
                                <div class="cover-book animated flipInX" style="margin-bottom: 15px;">
                                    <div class="item">
                                        <a href="<?php echo url('/book/'.seo($book->title).'/'.$book->id); ?>"
                                           title="">
                                            <img src="<?php echo assets('/images/'.($book->image === '' ? 'site/default-book.jpg' : $book->image)); ?>"
                                                 alt="<?php echo $book->title; ?>" height="200" width="150">
                                            <div style="padding: 7px;"
                                            "><?php echo cut($book->title, 50); ?></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                        <?php if ($pagination->lastPage() != 1) { ?>
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
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>