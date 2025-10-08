// ----------------------------------- List Page Actions -------------------------------------- //
var app = angular.module("goSocial",[]);
app.controller('articlesCtrl', function($scope, $http){
    $scope.articles; $scope.no_more_articles = false; $scope.article_count = 0;
    $scope.is_loading = false; $scope.top_story; $scope.articlesBk; $scope.load_more = false;

    // Get First 10 Articles from Database
    $http.get('public/Doctors/gosocial/services/fetcharticles.php').then((res)=>{
        console.log(res);
        $scope.articles = res.data;
        $scope.articlesBk = res.data;
    });

    // Get top story from Database
    $http.get('public/Doctors/gosocial/services/fetchtopstory.php').then((res)=>{
        console.log(res);
        $scope.top_story = res.data;
    });

    // Truncate text
    $scope.truncateText = function(str, num){
        console.log('string: ',str);
        if(str){
            str = str.replace(/(<([^>]+)>)/gi, "");
            if(str.length <= num){
                return str;
            }
            var resp = str.slice(0,num) + '...';
            var div = document.createElement("div"); 
            div.innerHTML = resp; 
            var text = div.textContent || div.innerText || ""; 
            return text;
        }
        return false;
    }

    $scope.searchArticles = function(terms){
        console.log(terms);
        if(terms){
            var payload = {search_param: terms};
            $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
            $http.post('public/Doctors/gosocial/services/searcharticle.php', payload).then((res)=>{
                console.log('search data: ', res);
                $scope.articles = res.data;
            });
        }else{
            $scope.articles = $scope.articlesBk;
        }
    }

    $scope.gotoDetails = function(news){
        document.getElementById("keys").value = btoa(JSON.stringify(news));
        document.getElementById("view").value = 'details';
        document.getElementById("viewpage").value = 'details';
        document.myform.submit();
    }

    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
            $scope.load_more = true;
            setTimeout(() => {
                $scope.loadMoreArticles(); 
                $scope.load_more = false;
            }, 2000);
        }
    });

    // Load more articles
    $scope.loadMoreArticles = function(){
        $scope.is_loading = true;
        var arrData;
        try{
            arrData = $scope.articles;
            $scope.article_count = Number(arrData.length);
        } catch(e){
            console.log(e);
        }
        
        var payload = {offset: $scope.article_count};
        console.log(payload);
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $http.post('public/Doctors/gosocial/services/fetcharticles.php', payload).then((res)=>{
            console.log(res);
            const new_articles = res.data;
            try {
                if(new_articles){
                    for(const item of new_articles){
                        $scope.articles.push(item);
                        $scope.articlesBk = $scope.articles;
                        $scope.is_loading = false;
                    }
                }else{
                    $scope.no_more_articles = true;
                    $scope.is_loading = false;
                }
                if(new_articles.length < $scope.article_count){
                    $scope.no_more_articles = true;
                    $scope.is_loading = false;
                }
            } catch (error) {
                console.log('Fetch Error: ', error);
            }
        });
    }
});
// ------------------------------------ End of List Page ----------------------------------------- //

// ----------------------------------- Details Page Actions -------------------------------------- //
var article = angular.module("article",[]);
article.controller('detailsCtrl', function($scope, $http){
    var keys = document.getElementById("keys").value;
    var obj = JSON.parse(atob(keys));
    $scope.article_id = obj.ART_ID; $scope.nodata = false;
    $scope.comments; $scope.doctor_id = document.getElementById("docid").value;
    console.log('Docotors ID: ', $scope.doctor_id)

    $scope.goBackToHome = function(){
        document.getElementById("keys").value = '';
        document.getElementById("view").value = '';
        document.getElementById("viewpage").value = '';
        document.myform.submit();
    }

    $scope.loadComments = function(){
        var payload = {article_id: $scope.article_id};
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $http.post('public/Doctors/gosocial/services/fetchcomments.php', payload).then((res)=>{
            console.log('comment data: ', res);
            var repo = res.data;
            if(repo.length > 0){
                $scope.comments = res.data;
                console.log('Comments: ', $scope.comments);
                $scope.nodata = false;
            }else{
                $scope.nodata = true;
            }
        });
    }

    $scope.saveComments = function(text){
        var payload = {
            article_id: $scope.article_id,
            commenttext: text
        };
        console.log('Send Data: ', payload);
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $http.post('public/Doctors/gosocial/services/savecomments.php', payload).then((res)=>{
            console.log('search data: ', res);
            $scope.comments = res.data;
            document.getElementById("chatmsg").value = '';
            $scope.loadComments();
        });
    }

});

// ------------------------------------ End of Details Page ----------------------------------------- //