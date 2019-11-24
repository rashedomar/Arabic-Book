<div class="book-container tp-border">
    <div class="book-body col-sm-12">
        <div class="bookDetails">
            <div class="book-body col-xs-12 col-sm-8 col-md-9 col-centered text-center">
                <h1><span class="text-success">قراءة</span> <?php echo $book->title; ?> </h1>
                <hr/>
                <iframe src="http://drive.google.com/viewerng/viewer?url=<?php echo isLink($book->link) ? $book->link.'?var='.rand() : assets('/files/'.$book->link).'?var='.rand(); ?>&amp;embedded=true"
                        style="border: none;" height="900" width="100%"></iframe>
            </div>
            <div class="clearfix"></div>
            <?php if ($book->description) { ?>
                <h4 class="text-danger">حول الكتاب</h4>
                <p class="text-justify">
                    <?php echo $book->description ?>
                </p>
            <?php } ?>
            <div class="text-center">
                <a href="<?php echo url('/book/'.seo($book->title).'/'.$book->id.'/download'); ?>"
                   class="btn btn-embossed btn-primary btn-wide"><i class="fa fa-cloud-download"></i> تحميل</a>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <div class="blog-comment">
                        <h3 id="CommentHead"> التعليقات (<span
                                    class="text-danger"><?php echo count($book->comments); ?></span>)</h3>
                        <form action="<?php echo url('/book/'.seo($book->title).'/'.$book->id.'/add-comment'); ?>"
                              method="post" id="add-comment">
                            <div id="form-results"></div>
                            <fieldset>
                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                                        <textarea class="form-control" name="comment" placeholder="أضف تعليق..."
                                                  required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php echo $recaptcha; ?>
                                </div>
                            </fieldset>
                            <input type="hidden" name="token" value="<?php echo $token; ?>">
                            <button type="submit" class="btn btn-primary add-comment">إضافة</button>
                        </form>
                        <hr/>
                        <ul id="comments" class="comments">
                            <?php foreach ($book->comments AS $comment) { ?>
                                <li class="clearfix">
                                    <img src="<?php echo assets('/images/'.$comment->user_image); ?>" class="avatar"
                                         alt="">
                                    <div class="post-comments">
                                        <p class="meta"><a
                                                    href="#"><?php echo $comment->first_name.' '.$comment->last_name; ?></a>
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