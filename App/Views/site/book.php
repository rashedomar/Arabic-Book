<div class="book-container tp-border">
    <div class="book-body col-sm-12">
        <div class="bookDetails">
            <div class="pull-right">
                <img height="280" width="200"
                     src="<?php echo assets('/images/'.($book->image === '' ? 'site/default-book.jpg' : $book->image)); ?>"
                     alt="<?php echo trim($book->title); ?>">
            </div>
            <div class="book-body col-xs-12 col-sm-8 col-md-9">
                <h1><?php echo $book->title; ?></h1>
                <p class="text-justify">
                    <?php echo $book->description ?>
                </p>
                <ul class="list-unstyled bookAttributes">
                    <li>
                        <i class="fa fa-calendar-check-o"></i> <span class="att">تاريخ الإضافة:</span><span
                                class="val"><?php echo date('d/m/y', $book->created) ?></span>
                    </li>
                    <li>
                        <i class="fa fa-pencil"></i>
                        <span class="att">المؤلف:</span><span class="val"> <a
                                    href="<?php echo url('/author/'.seo($book->author).'/'.$book->author_id); ?>"><?php echo $book->author; ?></a></span>
                    </li>
                    <li>
                        <i class="fa fa-thumb-tack"></i>
                        <span class="att">القسم:</span><span class="val"><a
                                    href="<?php echo url('/category/'.seo($book->category).'/'.$book->category_id); ?>"><?php echo $book->category; ?></a></span>
                    </li>
                    <li>
                        <i class="fa fa-eye-slash"></i> <span class="att">القراءات:</span><span
                                class="val"><?php echo $book->views ?></span>
                    </li>
                    <li>
                        <i class="fa fa-download"></i> <span class="att">التحميلات:</span><span
                                class="val"><?php echo $book->downloads ?></span>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 text-center">
                <div class="mainButtons">
                    <a href="<?php echo url('/book/'.seo($book->title).'/'.$book->id.'/read'); ?>"
                       class="btn btn-embossed btn-warning btn-wide"><i class="fa fa-eye"></i> قراءة</a>
                    <a href="<?php echo url('/book/'.seo($book->title).'/'.$book->id.'/download'); ?>"
                       class="btn btn-embossed btn-primary btn-wide"><i class="fa fa-cloud-download"></i> تحميل</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr/>
            <?php if ($authorBooks) { ?>
                <div class="col-xs-6 col-sm-8 <?php echo empty($categoryBooks) === true ? 'col-md-12' : 'col-md-6'; ?>">
                    <h6> كتب أخرى من المؤلف <span><a
                                    href="<?php echo url('/author/'.seo($book->author).'/'.$book->author_id); ?>"><span
                                        class="text-danger"><?php echo $book->author; ?></span></a></span></h6>
                    <?php foreach ($authorBooks AS $autBook) { ?>
                        <div class="rest col-sm-3">
                            <a href="<?php echo url('/book/'.seo($autBook->title).'/'.$autBook->id); ?>"><img
                                        height="120" width="100"
                                        src="<?php echo assets('/images/'.($autBook->image === '' ? 'site/default-book.jpg' : $autBook->image)); ?>"
                                        alt="<?php echo trim($autBook->title); ?>"></a>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($categoryBooks) { ?>
                <div class="col-xs-6 col-sm-8 <?php echo empty($authorBooks) === true ? 'col-md-12' : 'col-md-6'; ?>">
                    <h6> كتب أخرى من التصنيف <span><a
                                    href="<?php echo url('/category/'.seo($book->category).'/'.$book->category_id); ?>"><span
                                        class="text-danger"><?php echo $book->category; ?></span></a></span></h6>
                    <?php foreach ($categoryBooks AS $catBook) { ?>
                        <div class="rest col-sm-3">
                            <a href="<?php echo url('/book/'.seo($catBook->title).'/'.$catBook->id); ?>"><img
                                        height="120" width="100"
                                        src="<?php echo assets('/images/'.($catBook->image === '' ? 'site/default-book.jpg' : $catBook->image)); ?>"
                                        alt="<?php echo trim($catBook->title); ?>"></a>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="clearfix"></div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <div class="book-comment">
                        <h3 id="CommentHead"> التعليقات (<span
                                    class="text-danger"><?php echo count($book->comments); ?></span>)</h3>
                        <form action="<?php echo url('/book/'.seo($book->title).'/'.$book->id.'/add-comment'); ?>"
                              method="post" id="add-comment">
                            <div id="form-results"></div>
                            <fieldset>
                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                                        <textarea class="form-control" id="comment" name="comment"
                                                  placeholder="أضف تعليق..." required=""></textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <?php echo $recaptcha; ?>
                                    </div>
                                </div>
                            </fieldset>
                            <input type="hidden" name="token" value="<?php echo $token; ?>">
                            <button type="submit" class="btn btn-primary add-comment">إضافة</button>
                        </form>
                        <hr/>
                        <ul id="comments" class="comments">
                            <?php foreach ($book->comments AS $comment) { ?>
                                <li class="clearfix">
                                    <img src="<?php echo assets('/images/'.($comment->user_image === '' ? 'site/default-avatar.png' : $comment->user_image)); ?>"
                                         class="avatar" alt="">
                                    <div class="book-comments">
                                        <p class="meta"><?php echo $comment->first_name.' '.$comment->last_name; ?>
                                            قال : <i
                                                    class="pull-left"><?php echo date('d/m/y', $comment->created); ?></i>
                                        </p>
                                        <p><?php echo $comment->comment; ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>