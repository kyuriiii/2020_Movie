<? if ( ! defined('BASEPATH') ) exit('No direct script access allowed'); ?>

<?
    $data = array(
        "title"     => "",
        "bootstrap" => true,
        "jquery"    => true,
        "js"        => array( "js_tool", "js_detail" ),
        "css"       => array( "css_movie", "css_login", "css_reserve", "css_movie_recommand", "css_detail", "css_jquery_seat" )
    );

    echo $this->library_tool->html_header( $data );
?>

        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Nunito:wght@300&family=Overpass:wght@800&display=swap" rel="stylesheet">

        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script type="text/javascript" src="<?=base_url( "js/jquery.seat-charts.js" )?>"></script>

        <style>
            .swiper-container {
                width: 100%;
                height: 100%;
            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #1a1a1a;

                /* Center slide text vertically */
                display: -webkit-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                -webkit-justify-content: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                -webkit-align-items: center;
                align-items: center;
            }

            .movie-heading {
                font-size: 50px;
                font-family: 'Montserrat';
                font-weight: bold;
            }

            .swiper-container-v {
                background: #eee;
            }

            .swiper-pagination-bullet {
                width: 20px;
                height: 20px;
                text-align: center;
                line-height: 20px;
                font-size: 12px;
                color: #ffffff;
                opacity: 1;
                background: rgba(255, 255, 255, 0.2);
            }

            .swiper-pagination-bullet-active {
                color: #fff;
                background: #007aff;
            }

            .starR{
                background: url( "<?=base_url( "movie/icon_star.png" )?>" ) no-repeat right 0;
                background-size: auto 100%;
                width: 20px;
                height: 20px;
                display: inline-block;
                margin-right: 5px;
            }

            .starR.on{
                background-position: 0 0;
            }
            pre {
                padding: 10px;
                overflow: auto;
                white-space: pre-wrap; /* pre tag내에 word wrap */
            }
        </style>

        <script>
            function score_star( obj ){
                $( obj ).parent().children( "span" ).removeClass( "on" );
                $( obj ).addClass( "on" ).prevAll( "span" ).addClass( "on" );
            }

            function write(){
                var rating = 0;

                for ( var i = 0; i < $( "#span_stars" ).children().length; i++ ){
                    var star = $( "#span_stars" ).children()[i];
                    if ( $( star ).hasClass( "on" ) ){
                        rating++;
                    }
                }
            }

            function movie_like( obj ){
                <?
                    if ( !isset( $_SESSION["user_ID"] ) ){
                        echo "loginModal();";
                    }
                    else {
                ?>
                if ( $( obj ).hasClass( "glyphicons-heart" ) ){
                    var active = "off";
                    $( obj ).switchClass( "glyphicons-heart", "glyphicons-heart-empty" );
                }
                else {
                    var active = "on";
                    $( obj ).switchClass( "glyphicons-heart-empty", "glyphicons-heart" );
                }

                $.post(
                    "<?=base_url( 'mjumovie/movie_control' )?>",
                    { mode: "like", movie_ID: <?=$movie["ID"]?>, active: active },
                    function( data ){
                        var json = JSON.parse( data );

                        if ( json["<?=KEY_POST_RETURN?>"] == "<?=VAL_POST_RETURN_TRUE?>" ){

                        }
                        else alert( json["<?=KEY_POST_MSG?>"] );
                    }
                );
                <?
                    }
                ?>
            }
        </script>
    </head>

    <body>
        <form class="d-none" id="form_detail" method="post" action="<?=base_url( "mjumovie/movie_detail" )?>">
            <input type="hidden" name="mode" value="v1">
            <input type="hidden" name="movie_ID" value="<?=$movie["ID"]?>">
        </form>
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

        <div class="modal fade" id="modal_reserve" style="color:black;"></div>

        <div class="pl-5 pt-3 mx-5 fixed-top">
            <a id="logo" href="<?=base_url('')?>" class="mr-3"><img src="<?=base_url( 'movie/logo.jpg' )?>" style="width:180px; height: 50px" alt="Logo Image"></a>

            <?
            if ( isset( $user ) ){
            ?>
                <span onclick="document.location.href = '<?=base_url( "mjumovie/logout" )?>';" class="main-nav hover float-right mr-5 pt-2">로그아웃</span>
                <span class="main-nav hover float-right pt-2"><?=$user["name"]?>님의 홈</span>

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
            <?
            }
            else {
            ?>
               <span onclick="loginModal( false );" class="main-nav hover float-right mr-5 pt-2"> 로그인</span>
                <span onclick="document.location.href = '<?=base_url( "mjumovie/register" )?>';" class="main-nav hover float-right pt-2"> 회원가입</span>
            <?
            }
            ?>
            <span class="main-nav hover float-right pt-2" onclick="versionChange();">Version 변경</span>
        </div>

        <div class="swiper-container swiper-container-h">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="display: flex; flex-direction: column;">
                    <div class="pt-5 mt-3 row d-flex justify-content-center w-100">
                        <div class="col-4 d-flex justify-content-center ">
                            <div class="card ml-3" style="width: 12rem;">
                                <img src="<?=base_url( "movie/poster/" ).$movie["ID"].".jpg"?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <h2 class="lotte_font">
                                <img src="<?=base_url( "movie/age/" ).$movie["age"].".png"?>" width="35px;">
                                <?=$movie["name"]?>
                            </h2>
                            <br>
                            <span class="ml-1">평점 : </span>
                            <?
                            for ( $i = 1; $i < 6; $i ++ ){
                                echo "<span class='starR";

                                if ( $i <= $score ) echo " on";

                                echo "'></span>";
                            }
                            ?>
                            <div class="mt-3 ml-1">
                                <span>장르 : <?=$this->library_tool->return_genre_kor( $movie["genre"] )?></span>
                            </div>

                            <div class="mt-3 ml-1">
                                <span>감독 : <?=$movie["director"]?></span>
                            </div>

                            <div class="mt-3 ml-1">
                                <span>출연 :
                                    <?
                                    $i = 0;
                                    foreach ( $movie["actors"]->result_array() as $actor ) {
                                        echo $actor["name"];
                                        $i++;
                                        if ( $i != $movie["actors"]->num_rows() ) echo ", ";
                                    }
                                    ?>
                                </span>
                            </div>

                            <div class="mt-4 ml-1">
                                <?
                                if ( $like ) echo "<span class='glyphicons glyphicons-heart x15 hover mr-5' style='color:red;' onclick='movie_like( this);'></span>";
                                else echo "<span class='glyphicons glyphicons-heart-empty x15 hover mr-5' style='color:red;' onclick='movie_like( this);'></span>";
                                ?>
                                <button type="button" class="btn btn-danger px-5 ml-5" onclick="reservation( <?=$movie["ID"]?> );">예매하기</button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 pt-5">
                        <p> 옆으로 미세요! </p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-container swiper-container-v">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"
                                 style="display: flex; flex-direction: column; justify-content: space-around;">
                                <div>
                                    <span class="sub-title" style="font-size: 50px; font-weight: bold;">줄거리</span>
                                    <div class="mt-3">
                                        <pre style="word-break: keep-all; color:#f3f3f3;"><?=$movie["information"]?></pre>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide"style="display: flex; flex-direction: column; justify-content: space-around;">
                                <div>
                                    <span class="sub-title" style="font-size: 50px; font-weight: bold;">출연진</span>
                                    <fieldset class="mt-3">
                                        <div class="mt-2">
                                            <div class="mb-3 row">
                                                <?
                                                foreach ( $movie["actors"]->result_array() as $actor ){
                                                    ?>
                                                    <div class="col-6 col-md-4 mt-2">
                                                        <img src="<?=base_url( "movie/people.jpeg" )?>" class="card-img ml-2 mb-3" style="width:60px;">
                                                        <span><?=$actor["name"]?></span>
                                                    </div>
                                                    <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination swiper-pagination-v"></div>
                    </div>
                </div>
                <div class="swiper-slide" style="display: flex; flex-direction: column; justify-content: space-around;">
                    <div>
                        <span class="sub-title" style="font-size: 50px; font-weight: bold;">예고편</span>
                        <div class="mt-5">
                            <div class="play-backdrop"></div>
                            <div class="play-button">
                                <svg class="play-circles" viewBox="0 0 152 152">
                                    <circle class="play-circle-01" fill="none" stroke="#fff" stroke-width="3" stroke-dasharray="343" cx="76" cy="76" r="72.7"/>
                                    <circle class="play-circle-02" fill="none" stroke="#fff" stroke-width="3" stroke-dasharray="309" cx="76" cy="76" r="65.5"/>
                                </svg>
                                <div class="play-perspective">
                                    <button class="play-close"></button>
                                    <div class="play-triangle">
                                        <div class="play-video">
                                            <iframe width="600" height="400" src="<?=$movie["url"]?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="w-100">
                        <span class="sub-title" style="font-size: 50px; font-weight: bold;">후기/감상평</span>
                        <div class="review mt-3" style="width:80%">
                            <?
                            foreach ( $reviews->result_array() as $review ){
                                echo $this->library_tool->return_review_list( $review );
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-h"></div>
        </div>

        <script>
            var swiperH = new Swiper('.swiper-container-h', {
                spaceBetween: 50,
                pagination: {
                    el: '.swiper-pagination-h',
                    clickable: true,
                },
            });
            var swiperV = new Swiper('.swiper-container-v', {
                direction: 'vertical',
                spaceBetween: 50,
                pagination: {
                    el: '.swiper-pagination-v',
                    clickable: true,
                },
            });

            TweenMax.set(".play-circle-01", { rotation: 90, transformOrigin: "center" })
            TweenMax.set(".play-circle-02", { rotation: -90, transformOrigin: "center" })
            TweenMax.set(".play-perspective", { xPercent: 6.5, scale: .175, transformOrigin: "center", perspective: 1 })
            TweenMax.set(".play-video", { visibility: "hidden", opacity: 0, })
            TweenMax.set(".play-triangle", { transformOrigin: "left center", transformStyle: "preserve-3d", rotationY: 10, scaleX: 2 })
            const rotateTL = new TimelineMax({ paused: true })
                .to(".play-circle-01", .7, { opacity: .1, rotation: '+=360', strokeDasharray: 456, ease: Power1.easeInOut }, 0)
                .to(".play-circle-02", .7, { opacity: .1, rotation: '-=360', strokeDasharray: 411, ease: Power1.easeInOut }, 0)
            const openTL = new TimelineMax({ paused: true })
                .to(".play-backdrop", 1, { opacity: .95, visibility: "visible", ease: Power2.easeInOut }, 0)
                .to(".play-close", 1, { opacity: 1, ease: Power2.easeInOut }, 0)
                .to(".play-perspective", 1, { xPercent: 0, scale: 1,  ease: Power2.easeInOut }, 0)
                .to(".play-triangle", 1, { scaleX: 1, ease: ExpoScaleEase.config(2, 1, Power2.easeInOut) }, 0)
                .to(".play-triangle", 1, { rotationY: 0, ease: ExpoScaleEase.config(10, .01, Power2.easeInOut) }, 0)
                .to(".play-video", 1, { visibility: "visible", opacity: 1  }, .5)


            const button = document.querySelector(".play-button")
            const backdrop = document.querySelector(".play-backdrop")
            const close = document.querySelector(".play-close")

            button.addEventListener("mouseover", () => rotateTL.play())
            button.addEventListener("mouseleave", () => rotateTL.reverse())
            button.addEventListener("click", () => openTL.play())
            backdrop.addEventListener("click", () => openTL.reverse())
            close.addEventListener("click", e => {
                e.stopPropagation()
                openTL.reverse()
            })
        </script>
    </body>
</html>