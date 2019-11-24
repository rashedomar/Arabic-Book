<div class="book-container tp-border">
    <div class="row">
        <div class="col-sm-12">
            <div class="media">
                <div class="thumbnail pull-right">
                    <img src="<?php echo assets('/images/'.($author->image === '' ? 'site/default-book.jpg' : $author->image)); ?>"
                         alt="<?php echo $author->name; ?>" height="200" width="150">
                </div>
                <div class="media-body">
                    <h2 class="media-heading">المؤلف: <?php echo $author->name; ?></h2>
                    <p class="text-justify">
                        <?php echo $author->description; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="head-title">
        <h4 class="inline">أعماله:</h4>
    </div>
    <div class="row category">
        <?php foreach ($author->books AS $book) { ?>
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
