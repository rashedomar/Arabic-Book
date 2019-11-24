<div class="homeBlock">
    <div class="homeBlock-d">
        <p class="text-center">مرحباً بك! ، هنا يمكنك قراءة وتحميل الكتب .. فأهلاً وسهلاً.</p>
    </div>
</div>
<?php if ($categories) { ?>
    <div class="head-title">
        <h2 class="inline">التصنيفات</h2>
        <small class="inline">تصفح الكتب عبر هذه التصنيفات الاكثر شهرة ، أو اكتشف تصنيفات أخرى من القائمة بأعلى
            الصفحة.
        </small>
    </div>
    <div class="booksBlock cats">
        <div id="carouselCats">
            <?php foreach ($categories as $cat) { ?>
                <div class="col-xs-3 col-md-2 item"><a
                            href="<?php echo url('/category/'.seo($cat->name).'/'.$cat->id); ?>"><?php echo $cat->name; ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<?php if (empty($LatestBooks) AND empty($MostPopularWeek) AND (empty($MostDownWeek))) { ?>
    <div class="text-center" style="padding: 20px">
        لا توجد كتب.
    </div>
<?php } ?>
<?php if ($LatestBooks) { ?>
    <div class="head-title">
        <h2 class="inline">الكتب الحديثة</h2>
        <small class="inline">أحدث ما تم إضافته من الكتب.</small>
    </div>
    <div class="booksBlock">
        <div id="carousel" class="carousel animated jello">
            <?php foreach ($LatestBooks as $book) { ?>
                <div class="item">
                    <a href="<?php echo url('/book/'.seo($book->title).'/'.$book->id); ?>" title="">
                        <img src="<?php echo assets('/images/'.($book->image === '' ? 'site/default-book.jpg' : $book->image)); ?>"
                             alt="<?php echo $book->title; ?>" height="200" width="150">
                        <div class="book-info"><?php echo cut($book->title, 50); ?></div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>


<?php if ($MostPopularWeek) { ?>
    <div class="head-title">
        <h2 class="inline">كتب هذا الشهر الأكثر شعبية</h2>
        <small class="inline">أكثر الكتب شعبية لدى المستخدمين لآخر شهر.</small>
    </div>
    <div class="center-block booksBlock">
        <div id="carousel" class="carousel animated jello">
            <?php foreach ($MostPopularWeek as $book) { ?>
                <div class="item">
                    <a href="<?php echo url('/book/'.seo($book->title).'/'.$book->id); ?>" title="">
                        <img src="<?php echo assets('/images/'.($book->image === '' ? 'site/default-book.jpg' : $book->image)); ?>"
                             alt="<?php echo $book->title; ?>" height="200" width="150">
                        <div class="book-info"><?php echo cut($book->title, 50); ?></div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php if ($MostDownWeek) { ?>
    <div class="head-title">
        <h2 class="inline">كتب هذا الشهر الأكثر تحميلاً</h2>
        <small class="inline">أكثر الكتب تحميلاً من قبل المستخدمين لآخر شهر.</small>
    </div>
    <div class="center-block booksBlock">
        <div id="carousel" class="carousel text-center animated jello">
            <?php foreach ($MostDownWeek as $book) { ?>
                <div class="item">
                    <a href="<?php echo url('/book/'.seo($book->title).'/'.$book->id); ?>" title="">
                        <img src="<?php echo assets('/images/'.($book->image === '' ? 'site/default-book.jpg' : $book->image)); ?>"
                             alt="<?php echo $book->title; ?>" height="200" width="150">
                        <div class="book-info"><?php echo cut($book->title, 50); ?></div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

