<? if ( ! defined('BASEPATH') ) exit('No direct script access allowed'); ?>

<?
$data = array(
    "title"     => "",
    "bootstrap" => true,
    "jquery"    => true,
    "js"        => array( "js_tool", "js_cookie" ),
    "css"       => array( "css_movie", "css_login", "css_reserve", "css_movie_recommand", "css_jquery_seat" )
);

echo $this->library_tool->html_header( $data );
?>

    <script type="text/javascript" src="<?=base_url( "js/jquery.seat-charts.js" )?>"></script>
    <style>
        .div_like{
            margin-top: 2px;
            flex-grow: 1;
            white-space:nowrap;
            overflow-x:scroll;
        }

        #event-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #eventDetailShow{
            cursor:pointer;
        }

        #layer_popup .modal-header {
            background: rgba(152, 151, 151, 0.7);
            color: #ffffff;
        }

        #layer_popup .modal-body {
            background: white;
        }

        #layer_popup .modal-footer {
            background: rgba(152, 151, 151, 0.7);
            color: #000000;
        }

        #layer_popup .modal-footer label:hover {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>

    <script>
        function changeRank( genre ){
            var genreIndex = genreArr[genre];
            var selection = document.querySelectorAll( ".rank_img" );

            $( ".sm_btn" ).removeClass( "active" );
            $( "#btn_" + genre ).addClass( "active" );

            for ( var i = 0; i < selection.length; i++ ){
                var select = selection[i];
                $( select ).attr( "src", "<?=base_url()?>" + "movie/" + genre + "/rank" + (i+1) + ".jpg" );

                if ( genreIndex == 0 ) var num = (i+1).toString();
                else {
                    var tempGI = genreIndex.toString();
                    var num = tempGI + (i+1).toString();
                }

                var buttonDetail = select.parentNode.children[2];
                $( buttonDetail ).attr( "onclick", "showDetail( " + num + " );" );

                buttonDetail = select.parentNode.children[3];
                $( buttonDetail ).attr( "onclick", "reservation( " + num + " );" );
            }
        }

        function showDetail( id ){
            var form = document.getElementById( "form_detail" );

            form.movie_ID.value = id;

            form.submit();
        }

        function genre_change( type, obj ){
            if ( type == "all" ) {
                if ( obj == null ) var genre = "romance";
                else var genre = obj.value;

                var selection = document.querySelectorAll( ".img-genre-fluid" );
            }
            else {
                if ( obj == null ) var genre = $( "#select_user_genre" ).val();
                else var genre = obj.value;

                var selection = document.querySelectorAll( ".img-fluid" );
            }

            var genreIndex = genreArr[genre];
            var num = genreIndex * 10;

            for ( var i = 0; i < selection.length; i++ ){
                if ( i % 10 == 0 && i != 0 ) num = num - 10;

                var select = selection[i];
                $( select ).attr( "src", "<?=base_url()?>" + "movie/poster/" + (num+i+1) + ".jpg" );

                var buttonDetail = select.parentNode.children[2];
                $( buttonDetail ).attr( "onclick", "showDetail( " + (num+i+1) + " );" );

                buttonDetail = select.parentNode.children[3];
                $( buttonDetail ).attr( "onclick", "reservation( " + (num+i+1) + " );" );
            }
        }

        function eventDetail( obj, ID ){
            if ( $( "#detail_" + ID ).hasClass( "d-none" ) ){
                var selector = document.querySelectorAll( ".event_detail" );
                for ( var i = 0; i < selector.length; i++ ){
                    if ( !$( selector[i] ).hasClass( "d-none" ) ) $( selector[i] ).addClass( "d-none" );
                }

                selector = document.querySelectorAll( "#eventDetailShow" );
                for ( var i = 0; i < selector.length; i++ ){
                    $( selector[i] ).text("자세히보기");
                }

                $( "#detail_" + ID ).removeClass( "d-none" );
                $( obj ).text("자세히보기 닫기");
            }
            else {
                var selector = document.querySelectorAll( ".event_detail" );
                for ( var i = 0; i < selector.length; i++ ){
                    if ( !$( selector[i] ).hasClass( "d-none" ) ) $( selector[i] ).addClass( "d-none" );
                }
                selector = document.querySelectorAll( "#eventDetailShow" );
                for ( var i = 0; i < selector.length; i++ ){
                    $( selector[i] ).text("자세히보기");
                }
            }
        }

        function closePop(){
            if( $( "#expiresChk").prop("checked") ){
                $.cookie("popup", "none", { expires: 1, path: "/" });
                $("#layer_popup").fadeOut("fast");
            }
        }
    </script>
</head>

<body>
    <div class="wrapper mx-5">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top px-5 mx-5 py-3 bg-black">
            <a id="logo" href="<?=base_url('')?>" class="mr-3"><img src="<?=base_url( 'movie/logo.jpg' )?>" style="width:180px; height: 50px" alt="Logo Image"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse lotte_font" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active mr-3">
                        <a class="nav-link" href="<?=base_url('')?>">홈 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active mr-3">
                        <a class="nav-link" href="#genre">장르별</a>
                    </li>
                    <li class="nav-item active mr-3"<?if ( !isset( $user ) ) echo " onclick='loginModal();'"?>>
                        <a class="nav-link" href="#recommendation">추천영화</a>
                    </li>
                    <li class="nav-item active mr-3"<?if ( !isset( $user ) ) echo " onclick='loginModal();'"?>>
                        <a class="nav-link" href="#likes">찜</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#event">이벤트</a>
                    </li>
                </ul>

                <?
                if ( isset( $user ) ){
                ?>
                    <span class="btn-group">
                        <span class="main-nav hover glyphicons glyphicons-bell dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
                        <div class="dropdown-menu">
                            <?
                            $day_kor = array( "일", "월", "화", "수", "목", "금", "토" );

                            foreach ( $reserves->result_array() as $reserve ){
                                $dya_num = date( "w", strtotime( $reserve["date"] ) );
                                echo
                                "<div class='mx-2 px-2 mb-3 pt-2'>
                                    <div>
                                        <img class='mr-2' src='".base_url( "movie/age" )."/".$reserve["age"]."' style='width:18px;'>".$reserve["name"]."
                                    </div>
                                    <div class='mt-2'>
                                        <span class='ml-3'> ".$reserve["date"]." ( ".$day_kor[$dya_num]." )</span>
                                    </div>
                                    <div class='mt-2'>
                                        <span class='ml-3'>".$reserve["location"]." - ".$reserve["theater"]."점 ( ".$reserve["num"]." 명"." )</span>
                                    </div>
                                    <div class='mt-2'>";

                                    for ( $i = 0; $i < sizeof( $seats[$reserve["ID"]] ); $i++ ){
                                        echo "<span class='ml-3'>".$seats[$reserve["ID"]][$i]."</span>";
                                    }
                                echo
                                    "</div>
                                </div>";
                            }
                            ?>
                        </div>
                    </span>
                    <span class="main-nav hover"><?=$user["name"]?>님의 홈</span>
                    <span onclick="document.location.href = '<?=base_url( "mjumovie/logout" )?>';" class="main-nav hover">로그아웃</span>
                    <?
                }
                else {
                    ?>
                    <span onclick="document.location.href = '<?=base_url( "mjumovie/register" )?>';" class="main-nav hover"> 회원가입</span>
                    <span onclick="loginModal( false );" class="main-nav hover"> 로그인</span>
                <?
                }
                ?>
            </div>
        </nav>

        <!-- SLIDER -->
        <div class="container pt-5 mt-5">
            <form class="d-none" id="form_detail" method="post" action="<?=base_url( "mjumovie/movie_detail" )?>">
                <input type="hidden" name="mode" value="v1">
                <input type="hidden" name="movie_ID">
            </form>

            <div class="row">
                <div class="row justify-content-center d-block d-md-none py-2">
                    <div>
                        <button type="button" id="btn_romance" onclick="changeRank('romance');" class="btn btn-outline-light active rounded-pill sm_btn mr-2">로맨스</button>
                        <button type="button" id="btn_action" onclick="changeRank('action');" class="btn btn-outline-light rounded-pill sm_btn mr-2">액션</button>
                        <button type="button" id="btn_comedy" onclick="changeRank('comedy');" class="btn btn-outline-light rounded-pill sm_btn mr-2">코미디</button>
                        <button type="button" id="btn_animation" onclick="changeRank('animation');" class="btn btn-outline-light rounded-pill sm_btn mr-2">애니매이션</button>
                        <button type="button" id="btn_horror" onclick="changeRank('horror');" class="btn btn-outline-light rounded-pill sm_btn mr-2">호러</button>
                    </div>
                </div>
                <aside class="d-none d-md-block col-md-3" id="left">
                    <ul>
                        <li onclick="changeRank('romance');">로맨스</li>
                        <li onclick="changeRank('action');">액션</li>
                        <li onclick="changeRank('comedy');">코미디</li>
                        <li onclick="changeRank('animation');">애니메이션</li>
                        <li onclick="changeRank('horror');">호러</li>
                    </ul>
                </aside>
                <section class="col-sm-12 col-md-8" style="height:400px;">
                    <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?
                            for ( $i = 1; $i < 6; $i++ ){
                            ?>
                                <div class="carousel-item <?if( $i==1 ) echo "active"?>" data-interval="3000">
                                    <div id="product-card">
                                        <div id="product-front">
                                            <img src="<?=base_url( 'movie/romance/rank' ).$i.".jpg"?>" id="rank<?=$i?>" class="d-block w-40 h-100 m-auto rank_img" alt="rank<?=$i?>">
                                            <div class="image_overlay"></div>
                                            <div class="over_view view_detail" onclick="showDetail( <?=30 + $i?> );">상세정보</div>
                                            <div class="over_view view_reservation" onclick="reservation( <?=30 + $i?> );">예매하기</div>
                                        </div>
                                    </div>
                                </div>
                            <?
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </section>
            </div>
        </div>

        <?
        if ( isset( $user ) ){
        ?>
            <section id="recommendation">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="section-header">
                                <?=$user["name"]?>님을 위한 추천
                                <select class="form-control" id="select_user_genre" onchange="genre_change( 'recommand', this );">
                                    <?
                                    foreach ( $user["genre"]->result_array() as $user_genre ){
                                        echo "<option value='".$user_genre["genre"]."'>".$this->library_tool->return_genre_kor( $user_genre["genre"] )."</option>";
                                    }
                                    ?>
                                </select>
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 col-md-12">
                            <div id="recipeCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <?
                                    for ( $i = 1; $i < 11; $i++ ){
                                    ?>
                                        <div class="carousel-item <?if( $i==1 ) echo "active"?>">
                                            <div id="product-card" class="col-lg-3 col-md-6">
                                                <div id="product-front" class="movie-card m-1">
                                                    <div class="movie-img">
                                                        <img src="<?=base_url( 'movie/poster/' ).$i.".jpg"?>" class="img-fluid">
                                                        <div class="image_overlay-genre"></div>
                                                        <div class="over_view view_detail" onclick="showDetail( <?=$i?> );">상세정보</div>
                                                        <div class="over_view view_reservation" onclick="reservation( <?=$i?> );">예매하기</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?
                                    }
                                    ?>
                                </div>
                                <a class="carousel-control-prev bg-dark w-auto" href="#recipeCarousel" role="button"
                                   data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next bg-dark w-auto" href="#recipeCarousel" role="button"
                                   data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="likes">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="section-header">
                                찜
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 div_like">
                            <?
                                if ( $likes->num_rows() == 0 ) echo "찜한 영화가 존재하지 않습니다.";
                                else {
                                    foreach ( $likes->result_array() as $like ){
                            ?>
                                        <img class="mx-2 like_img" src="<?=base_url( 'movie/poster/' ).$like["movie_ID"].".jpg"?>" style="width:200px;">
                            <?
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?
        }
        ?>

        <section id="genre">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="section-header">
                            전체 장르
                            <select class="form-control" id="select_all_genre" onchange="genre_change( 'all', this );">
                                <?
                                foreach ( $this->library_tool->genre as $k => $v ){
                                    echo "<option value='".$k."'>".$v."</option>";
                                }
                                ?>
                            </select>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 col-md-12">
                        <div id="recipeCarousel" class="special_recipeCarousel carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <?
                                for ( $i = 1; $i < 11; $i++ ){
                                    ?>

                                    <div class="carousel-item <?if( $i==1 ) echo "active"?>">
                                        <div id="product-card" class="col-lg-3 col-md-6">
                                            <div id="product-front" class="movie-card m-1">
                                                <div class="movie-img">
                                                    <img src="<?=base_url( 'movie/poster/' ).$i.".jpg"?>" class="img-genre-fluid">
                                                    <div class="image_overlay-genre"></div>
                                                    <div class="over_view view_detail" onclick="showDetail( <?=$i?> );">상세정보</div>
                                                    <div class="over_view view_reservation" onclick="reservation( <?=$i?> );">예매하기</div>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                            <a class="carousel-control-prev bg-dark w-auto" href=".special_recipeCarousel" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next bg-dark w-auto" href=".special_recipeCarousel" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="event">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="section-header">
                            이벤트
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" style="font-weight: bold; font-size: 1.2em;">
                            <li class="nav-item">
                                <a href="#tab_all" class="nav-link navbar-default active" id="defaultOpen" data-toggle="tab">전체 이벤트</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab_movie" class="nav-link navbar-default" data-toggle="tab">영화 이벤트</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab_sale" class="nav-link navbar-default" data-toggle="tab">할인 이벤트</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab_corona" class="nav-link navbar-default" data-toggle="tab">코로나19 안내</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active tab-box py-2" id="tab_all">
                                <div class="card-wrapper" style="display: flex; flex-direction: row; justify-content: center;">
                                    <?
                                    foreach ( $events->result_array() as $event ){
                                    ?>
                                        <div class="card mr-2">
                                            <img class="card-img-top" src="<?=base_url( 'movie/event/event' ).$event["ID"].".jpg"?>" alt="Card image cap" style="width:200px;">
                                            <div class="card-body" style="background-color:#141414;">
                                                <h5 class="card-title"><?=$event["title"]?></h5>
                                                <p class="card-text">2020-10-01 - 2020.12.15</p>
                                                <a id="eventDetailShow" onclick="eventDetail( this, <?=$event["ID"]?> );" class="card-link hover">자세히보기</a>
                                            </div>
                                        </div>
                                    <?
                                    }
                                    ?>
                                </div>
                            </div>

                            <?
                            for ( $i = 0; $i < sizeof( $this->library_tool->event_type ); $i++ ){
                            ?>
                                <div class="tab-pane tab-box py-2" id="tab_<?=$this->library_tool->event_type[$i]?>">
                                    <div class="card-wrapper" style="display: flex; flex-direction: row; justify-content: center;">
                                        <?
                                        foreach ( $events->result_array() as $event ){
                                            if ( $event["type"] == $this->library_tool->event_type[$i] ){
                                        ?>
                                            <div class="card mr-2">
                                                <img class="card-img-top" src="<?=base_url( 'movie/event/event' ).$event["ID"].".jpg"?>" alt="Card image cap" style="width:200px;">
                                                <div class="card-body" style="background-color:#141414;">
                                                    <h5 class="card-title"><?=$event["title"]?></h5>
                                                    <p class="card-text">2020-10-01 - 2020.12.15</p>
                                                    <a id="eventDetailShow" onclick="eventDetail( this, <?=$event["ID"]?> );" class="card-link hover">자세히보기</a>
                                                </div>
                                            </div>
                                        <?
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?
                            }
                            ?>
                        </div>

                        <?
                        foreach ( $events->result_array() as $event ){
                        ?>
                            <div id="detail_<?=$event["ID"]?>" class="event_detail d-none mt-4" style="color: #DDD; margin-bottom: 20px;">
                                <div class="event-title" id="event-title">
                                    <h3><?=$event["title"]?></h3>
                                </div>
                                <div class="event-duration">
                                    <p>2020-10-01 - 2020.12.15</p>
                                </div>
                                <div class="event-content">
                                    <img src="<?=base_url( 'movie/event/event' ).$event["ID"]."_1.jpg"?>" alt="image poster full version">
                                </div>
                            </div>
                        <?
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- END OF LINKS -->

        <!-- FOOTER -->
        <footer>
            <p>웹프로그래밍2팀</p>
            <p>2020</p>
        </footer>
        <!-- END OF FOOTER -->

        <div class="modal fade" id="modal_login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content form-wrap">
                    <div class="float-right mr-3 px-3" style="width:100%">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="button-wrap">
                        <div id="myBtn"></div>
                        <button type="button" class="toggleLogin" id="btn_login" onclick="find( 'login' );">LOG IN</button>
                    </div>

                    <form id="form_login" class="login-input-group">
                        <input type="text" class="input-field" placeholder="아이디" name="userID" required>
                        <input type="password" class="input-field" name="password" placeholder="비밀번호" onkeypress="if ( event.keyCode == 13 ) login();" required>

                        <div class="my-3 text-center">
                            <span class="find-span hover" onclick="find( 'ID' );"> ID 찾기 </span>
                            <span class="find-span hover" onclick="find( 'PW' );"> PW 찾기</span>
                        </div>

                        <button type="button" class="submit" onclick="login();">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_reserve" style="color:black;"></div>

    <div id="layer_popup" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header pt-1 pb-1">
                    <h5 class="modal-title" style="font-family: 'Black Han Sans', sans-serif;
              font-family: 'Nunito', sans-serif;
              font-family: 'Overpass', sans-serif; font-size: 25px;">Today's Hot Event</h5>

                    <button type="button" class="close" data-dismiss="modal" onclick="closePop();" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <img src="<?=base_url( "movie/event/event1.jpg" )?>" alt="event poster1">
                </div>
                <div class="modal-footer pt-1 pb-1">
                    <form name="pop_form">
                        <label for="expiresChk">
                            <input type="checkbox" name="expiresChk" id="expiresChk" class="flat"> 오늘 하루동안 보지 않기</label>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setting(){
            var selection = document.querySelectorAll( "#product-card" );

            for ( var i = 0; i < selection.length; i++ ){
                $( selection[i] ).hover(function () {
                    $( this ).addClass('animate');
                }, function () {
                    $( this ).removeClass('animate');
                });
            }

            var imgselect = document.querySelectorAll( ".like_img" );

            for ( var i = 0; i < selection.length; i++ ){
                $( selection[i] ).hover(function () {
                    $( this ).addClass('animate');
                }, function () {
                    $( this ).removeClass('animate');
                });
            }
        }

        $('#recipeCarousel').carousel({
            interval: 5000
        })

        $('#recipeCarousel.carousel .carousel-item').each(function () {
            var minPerSlide = 4;
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));

            for (var i = 0; i < minPerSlide; i++) {
                next = next.next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }

                next.children(':first-child').clone().appendTo($(this));
            }
        });

        setting();
        genre_change( "recommand" );
        document.getElementById( "defaultOpen" ).click();

        modal_draggable();

        if ($.cookie("popup") != "none") {
            $("#layer_popup").modal( "show" );
        }
        var modal = document.getElementById( "layer_popup" );

        window.onclick = function(e){
            if ( e.target == modal ){
                closePop();
            }
        }
    </script>
</body>

</html>