<div class="book-container tp-border">
    <div class="head-title">
        <h2 class="inline">تصنيف: <?php echo $category->name; ?></h2>
        <?php if ($childes) { ?>
            <small class="inline">يمكنك ايضاً التصفح عبر هذه التصنيفات الفرعية.</small>
        <?php } ?>
    </div>
    <?php if ($childes) { ?>
        <div class="booksBlock cats">
            <ul class="list-inline" style="margin: 0;">
                <span style="color: #fff;"> الأقسام الفرعية:</span>
                <?php foreach ($childes AS $child) { ?>
                    <li>
                        <a class="btn btn-warning"
                           href="<?php echo url('/category/'.seo($child->name).'/'.$child->id); ?>">
                            <h5><?php echo $child->name; ?></h5>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <div class="row category">
        <?php foreach ($category->books AS $book) { ?>
            <div class="col-lg-3 col-md-4 col-xs-6 text-center">
                <div class="cover-book animated flipInX" style="margin-bottom: 15px;">
                    <div class="item">
                        <a href="<?php echo url('/book/'.seo($book->title).'/'.$book->id); ?>" title="">
                            <img src="<?php echo assets('/images/'.($book->image === '' ? 'site/default-book.jpg' : $book->image)); ?>"
                                 alt="<?php echo $book->title; ?>" height="200" width="150">
                            <div style="padding: 7px;"><?php echo cut($book->title, 50); ?></div>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
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
