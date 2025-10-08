<div class="row social" ng:app="goSocial" ng:controller="articlesCtrl">
    <div class="col-sm-12 row">
        <div class="col-sm-4 brand">
            <span>Go <b>Social</b></span>
        </div>
        <div class="col-sm-8">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" ng-model="fsearch" id="fsearch" name="fsearch" class="form-control input-lg" placeholder="Search..." />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button" ng:click="searchArticles(fsearch)">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-12">
        <section class="hero" ng:show="top_story" ng:click="gotoDetails(top_story)">
            <img src="<?php echo SPATH_ARTICLES; ?>{{top_story.ART_ARTICLE_PHOTO}}" alt="">
            <div class="hero-title">
                <h3>{{top_story.ART_TITLE}}</h3>
                <p>{{top_story.ART_ARTICLETEXT}}</p>
            </div>
        </section>

        <section class="content">
            <div class="row" ng:show="articles">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3" ng:repeat="news in articles">
                    <div class="card text-left" ng:click="gotoDetails(news)">
                      <img class="card-img-top" src="<?php echo SPATH_ARTICLES;?>{{news.ART_ARTICLE_PHOTO}}" alt="Article Image">
                      <div class="card-body">
                        <h5 class="card-title">{{news.ART_TITLE}}</h5>
                        <p class="card-text">{{news.ART_ARTICLETEXT}}</p>
                      </div>
                    </div>
                </div>

                <div class="col-sm-12 text-center">
                    <button type="button" name="loadmore" id="loadmore" class="btn btn-default btn-lg btn-full"><i class="fa fa-spinner fa-spin"></i> Loading More...</button>
                </div>
            </div>
        </section>
    </div>
</div>