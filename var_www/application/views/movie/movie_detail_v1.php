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

        <script type="text/javascript" src="<?=base_url( "js/jquery.seat-charts.js" )?>"></script>
        <style>
            .tablink {
                background-color: var(--primary);
                color: var(--light);
                font-family: 'LotteMartDream', sans-serif;
                float: left;
                border: 1px var(--dark) solid;
                border-bottom: none; /* content와 이어지는 선을 막기 위해 */
                outline: none;
                cursor: pointer;
            }

            .tablink:hover {
                background-color: var(--light);
                color: var(--primary);
            }

            .tabcontent {
                display: none;
                border-bottom: 2px #f2f2f2 solid;
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
    </head>

    <body>
        <form class="d-none" id="form_detail" method="post" action="<?=base_url( "mjumovie/movie_detail" )?>">
            <input type="hidden" name="mode" value="v2">
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

        <div class="container mt-5 pt-5">
            <div class="row">
                <div class="col-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                        </ol>
                        <div class="carousel-inner" style="height:300px;">
                            <?
                            for ( $i = 1; $i < 6; $i++ ){
                            ?>
                                <div class="carousel-item <?if ( $i == 1 ) echo "active";?>" data-interval="3000">
                                    <img src="<?=base_url( "movie/steel/" ).$movie["ID"]."_".$i.".jpg"?>" class="d-block w-100 h-100" alt="...">
                                </div>
                            <?
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-5 mt-3 row d-flex justify-content-center">
                <div class="col-4 text-center">
                    <div class="card" style="width: 12rem;">
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

            <div class="pt-5 mt-3 row mx-0">
                <div class="col-6 tablink py-2" onclick="openTab( 'detail', this, '#F3F3F3' );">
                    <div class="d-flex justify-content-center" id="defaultOpen">
                        <h5 class="lotte_font"> 영화정보 </h5>
                    </div>
                </div>
                <div class="col-6 tablink py-2" onclick="openTab( 'review', this, '#F3F3F3' );">
                    <div class="d-flex justify-content-center">
                        <h5 class="lotte_font"> 평점 및 관람평 ( <?=$reviews->num_rows()?> )</>
                    </div>
                </div>
            </div>

            <div id="detail" class="pt-5 tabcontent">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <fieldset>
                            <legend style="width:auto; margin-left:30px;">  줄거리</legend>
                            <div class="mt-3">
                                <pre style="word-break: keep-all; color:#f3f3f3;"><?=$movie["information"]?></pre>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-12 col-md-6">
                        <fieldset>
                            <legend style="width:auto; margin-left:30px;">  관람선호도</legend>
                            <div class="mt-2">
                                <img src="<?$num = rand(1,5); echo base_url( "movie/review/" ).$num.".png";?>" class="pb-3 px-3">
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row mt-3 pt-5">
                    <div class="col-12">
                        <fieldset>
                            <legend style="width:auto; margin-left:30px;">  출연진</legend>
                            <div class="mt-2">
                                <div class="mb-3 row">
                                    <?
                                        foreach ( $movie["actors"]->result_array() as $actor ){
                                    ?>
                                        <div class="col-6 col-md-4">
                                            <img src="<?=base_url( "movie/people.jpeg" )?>" class="card-img ml-5 mb-3" style="width:60px;">
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

                <div class="mt-3 pt-5">
                    <span class="ml-4" style="font-size:1.4em;">예고편</span>
                    <div class="mt-5 d-flex justify-content-center">
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

                <div class="mt-3 py-5 mb-5">
                    <span class="ml-4" style="font-size:1.4em;">스틸컷</span>
                    <div id="carouselExampleBottom" class="carousel slide mt-3" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleBottom" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleBottom" data-slide-to="1"></li>
                            <li data-target="#carouselExampleBottom" data-slide-to="2"></li>
                            <li data-target="#carouselExampleBottom" data-slide-to="3"></li>
                            <li data-target="#carouselExampleBottom" data-slide-to="4"></li>
                        </ol>
                        <div class="carousel-inner" style="height:300px;">
                            <?
                            for ( $i = 1; $i < 6; $i++ ){
                                ?>
                                <div class="carousel-item <?if ( $i == 1 ) echo "active";?>" data-interval="3000">
                                    <img src="<?=base_url( "movie/steel/" ).$movie["ID"]."_".$i.".jpg"?>" class="d-block w-40 h-100 m-auto rank_img" alt="...">
                                </div>
                                <?
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleBottom" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleBottom" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <div id="review" class="pt-5 tabcontent">
                <div class="review">
                    <?
                    foreach ( $reviews->result_array() as $review ){
                        echo $this->library_tool->return_review_list( $review );
                    }
                    ?>
                </div>
                <?
                if ( isset( $user ) ){
                ?>
                    <div class="mt-3 mb-5 px-5">
                        <form class="row" id="form_review">
                            <div class="col-2 mx-auto">
                                <div class="text-center mb-2">
                                    <span class="text-center">평점</span>
                                </div>
                                <div class="d-flex justify-content-center" id="span_stars">
                                    <?
                                    for ( $i = 1; $i < 6; $i ++ ){
                                        echo "<span class='starR hover' onclick='score_star( this );'></span>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-8">
                                <textarea class="form-control" rows="3" name="comment"></textarea>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary w-100 h-100" style="font-size:1.3em;" onclick="review_write();">작성</button>
                            </div>
                        </form>
                    </div>
                <?
                }
                ?>
            </div>
        </div>

        <footer>
            <p>웹프로그래밍2팀</p>
            <p>2020</p>
        </footer>

        <script>
            function openTab( pageName, elmnt, color ) {
                var i, tabcontent, tablinks;

                tabcontent = document.getElementsByClassName( "tabcontent" );

                for ( i = 0; i < tabcontent.length; i++ ) {
                    tabcontent[i].style.display = "none";
                }

                tablinks = document.getElementsByClassName( "tablink" );

                for ( i = 0; i < tablinks.length; i++ ) {
                    tablinks[i].style.backgroundColor = "";
                    tablinks[i].style.color = "#F3F3F3";
                }

                document.getElementById( pageName ).style.display = "block";

                elmnt.style.backgroundColor = color;
                elmnt.style.color = "#141414";
            }
            document.getElementById( "defaultOpen" ).click();

            TweenMax.set(".play-circle-01", {
                rotation: 90,
                transformOrigin: "center"
            })

            TweenMax.set(".play-circle-02", {
                rotation: -90,
                transformOrigin: "center"
            })

            TweenMax.set(".play-perspective", {
                xPercent: 6.5,
                scale: .175,
                transformOrigin: "center",
                perspective: 1
            })

            TweenMax.set(".play-video", {
                visibility: "hidden",
                opacity: 0,
            })

            TweenMax.set(".play-triangle", {
                transformOrigin: "left center",
                transformStyle: "preserve-3d",
                rotationY: 10,
                scaleX: 2
            })

            const rotateTL = new TimelineMax({ paused: true })
                .to(".play-circle-01", .7, {
                    opacity: .1,
                    rotation: '+=360',
                    strokeDasharray: 456,
                    ease: Power1.easeInOut
                }, 0)
                .to(".play-circle-02", .7, {
                    opacity: .1,
                    rotation: '-=360',
                    strokeDasharray: 411,
                    ease: Power1.easeInOut
                }, 0)

            const openTL = new TimelineMax({ paused: true })
                .to(".play-backdrop", 1, {
                    opacity: .95,
                    visibility: "visible",
                    ease: Power2.easeInOut
                }, 0)
                .to(".play-close", 1, {
                    opacity: 1,
                    ease: Power2.easeInOut
                }, 0)
                .to(".play-perspective", 1, {
                    xPercent: 0,
                    scale: 1,
                    ease: Power2.easeInOut
                }, 0)
                .to(".play-triangle", 1, {
                    scaleX: 1,
                    ease: ExpoScaleEase.config(2, 1, Power2.easeInOut)
                }, 0)
                .to(".play-triangle", 1, {
                    rotationY: 0,
                    ease: ExpoScaleEase.config(10, .01, Power2.easeInOut)
                }, 0)
                .to(".play-video", 1, {
                    visibility: "visible",
                    opacity: 1
                }, .5)


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