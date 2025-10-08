<div class="row article" ng:app="article" ng:controller="detailsCtrl" ng:init="loadComments()">
    <div class="col-sm-12 nav bbt">
        <button type="button" class="btn btn-light" ng:click="goBackToHome()"><i class="fa fa-arrow-left"></i> Back</button>
    </div>
    <div class="col-sm-8 br">
        <div class="article-title">
            <?php echo $article_content['ART_TITLE'];?>
        </div>

        <section class="article-hero">
            <img src="<?php echo SPATH_ARTICLES.$article_content['ART_ARTICLE_PHOTO']; ?>" alt="Article Image">
        </section>

        <section class="article-content">
            <p><?php echo $article_content['ART_ARTICLETEXT'];?></p>
        </section>
    </div>
    <div class="col-sm-4">
        <div class="col-sm-12 comments-title">
            <span>COMMENTS</span>
        </div>

        <div class="col-sm-12 comments-content">
            <div class="msg nodata" ng:show="nodata"> Be the first to comments on the article</div>
            <div class="msg" ng:repeat="message in comments">
                <div class="row message" ng:if="message.ATCOM_PATIENTCODE === doctor_id'">
                    <div class="col-sm-3">
                        <img src="<?php echo SPATH_PROFILES;?>{{message.ATCOM_PATIENTPHOTO}}" alt="Image">
                    </div>
                    <div class="col-sm-9 msg">
                        {{message.ATCOM_COMMENT}}
                        <p>
                            <small>{{message.ATCOM_DATEADDED}}</small>
                        </p>
                    </div>
                </div>

                <div class="row message-me" ng:if="message.ATCOM_PATIENTCODE === doctor_id">
                    <div class="col-sm-9 msg">
                        {{message.ATCOM_COMMENT}}
                        <p>
                            <small>{{message.ATCOM_DATEADDED}}</small>
                        </p>
                    </div>
                    <div class="col-sm-3">
                        <img src="<?php echo SHOST_DOCTOR_IMG_URL;?>{{message.ATCOM_PATIENTPHOTO}}" alt="Image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 comments-chat">
            <div class="row">
                <div class="col-sm-10">
                    <textarea class="form-control" ng:model="chatmsg" name="chatmsg" id="chatmsg" rows="1" placeholder="write comment..."></textarea>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-dark" ng:click="saveComments(chatmsg,'<?php echo $article_content['ART_ID'];?>')"><i class="fa fa-send"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>