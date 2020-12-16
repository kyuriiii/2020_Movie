<? if ( ! defined('BASEPATH') ) exit('No direct script access allowed'); ?>

<?
    $data = array(
        "title"     => "",
        "bootstrap" => true,
        "jquery"    => true,
        "js"        => array( "js_tool", "js_datepicker" ),
        "css"       => array( "css_movie", "css_login" )
    );

    echo $this->library_tool->html_header( $data );
?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <style>
            .information_label {
                width: 200px;
                font-weight: bold;
                font-family: 'LotteMartDream', sans-serif;
            }

            .information_subtitle{
                font-size: 0.9em;
                font-family: 'LotteMartDream', sans-serif;
            }
        </style>

        <script>
            function passwordCheck( obj ){
                var form = document.getElementById( "form_register" );

                if ( obj.value != form.password.value ){
                    if ( $( "#pwalert" ).hasClass( "d-none" ) ) $( "#pwalert" ).removeClass( "d-none" );
                } else {
                    if ( !$( "#pwalert" ).hasClass( "d-none" ) ) $( "#pwalert" ).addClass( "d-none" );
                }
            }

            function register(){
                var form = document.getElementById( "form_register" );

                form_trim( form.userID );
                form_trim( form.name );
                form_trim( form.password );
                form_trim( form.password_re );
                form_trim( form.contact );

                if ( !form.checkValidity() ){
                    html5_validation_report( form );

                    return false;
                }

                if ( form.password.value != form.password_re.value ) {
                    alert( "비밀번호가 일치하지 않습니다." );

                    return false;
                }

                form.submit();
            }

            function auto_check( ID ){
                if( $( "#" + ID ).prop("checked") ){
                    $( "#" + ID ).prop("checked", false );
                } else if( $( "#" + ID ).prop("checked") == false ){
                    $( "#" + ID ).prop("checked", true );
                } else{
                    alert( "Incorrect Input" );
                }
            }
        </script>
    </head>

    <body>
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
        <div class="wrapper mx-5">
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
                    <?
                }
                ?>
            </div>

            <div class="container mt-5 pt-5">
                <fieldset>
                    <legend align="center"> <h4 class="font-weight-bold text-center lotte_font pt-4 "> 필수 정보 입력 </h4></legend>

                    <hr class="hr_custom">
                    <form id="form_register" method="post" action="<?=base_url( 'mjumovie/user_control' )?>">
                        <input type="hidden" name="mode" value="register">
                        <div class="d-flex justify-content-start py-2">
                            <p class="px-5 align-middle information_label"> 아이디 </p>
                            <input type="text" class="form-control" style="width:250px;" name="userID" required>
                        </div>
                        <hr class="hr_custom">

                        <div class="d-flex justify-content-start py-2">
                            <p class="px-5 align-middle information_label"> 이름 </p>
                            <input type="text" class="form-control" style="width:250px;" name="name" required>
                        </div>
                        <hr class="hr_custom">

                        <div class="d-flex justify-content-start py-2">
                            <p class="px-5 align-middle information_label"> 비밀번호 </p>
                            <input type="password" class="form-control" style="width:250px;" name="password" required>
                            <p class="text-muted information_subtitle px-3 pt-2 align-middle"> 영어 소문자만 입력해주세요. </p>
                        </div>
                        <hr class="hr_custom">

                        <div class="d-flex justify-content-start py-2">
                            <p class="px-5 align-middle information_label"> 비밀번호 확인 </p>
                            <input type="password" class="form-control" style="width:250px;" name="password_re" onfocusout="passwordCheck(this);" required>
                            <p id="pwalert" class="d-none text-danger information_subtitle px-3 pt-2 align-middle"> 비밀번호가 일치하지 않습니다. </p>
                        </div>
                        <hr class="hr_custom">

                        <div class="d-flex justify-content-start py-2">
                            <p class="px-5 align-middle information_label"> 전화번호 </p>
                            <input type="tel" class="form-control" style="width:250px;" name="contact" onfocusout="phone_validation( this );" pattern="^\d{3}-\d{3,4}-\d{4}$" title="<?=TITLE_PHONE?>" required>
                        </div>
                        <hr class="hr_custom">

                        <div class="d-flex justify-content-start py-2">
                            <p class="px-5 align-middle information_label"> 생일 </p>
                            <input type="text" class="form-control" name="birth" id="birth" style="width:250px;" pattern="<?=PATTERN_DATE?>" title="<?=TITLE_DATE?>" placeholder="<?=TITLE_DATE?>" required>
                            <span class="glyphicons glyphicons-calendar text-light hover font-weight-bold x15" onclick="$( '#birth' ).datepicker('show');"></span>
                        </div>
                        <hr class="hr_custom">

                        <div class="d-flex justify-content-start py-2">
                            <p class="px-5 align-middle information_label">좋아하는 장르</p>

                            <input type="checkbox" name="genre[]" id="romance" value="romance" class="mx-2">
                            <span class="hover" onclick="auto_check('romance');"> 로맨스 </span>

                            <input type="checkbox" name="genre[]" id="action" value="action" class="mx-2">
                            <span class="hover" onclick="auto_check('action');"> 액션 </span>

                            <input type="checkbox" name="genre[]" id="comedy" value="comedy" class="mx-2">
                            <span class="hover" onclick="auto_check('comedy');"> 코미디 </span>

                            <input type="checkbox" name="genre[]" id="animation" value="animation" class="mx-2">
                            <span class="hover" onclick="auto_check('animation');"> 애니매이션 </span>
                        </div>

                        <div class="d-flex justify-content-start">
                            <p class="px-5 align-middle information_label"></p>

                            <input type="checkbox" name="genre[]" id="mystery" value="mystery" class="mx-2">
                            <span class="hover" onclick="auto_check('mystery');"> 미스테리 </span>

                            <input type="checkbox" name="genre[]" id="fantasy" value="fantasy" class="mx-2">
                            <span class="hover" onclick="auto_check('fantasy');"> 판타지 </span>

                            <input type="checkbox" name="genre[]" id="horror" value="horror" class="mx-2">
                            <span class="hover" onclick="auto_check('horror');"> 호러 </span>

                            <input type="checkbox" name="genre[]" id="noil" value="noil" class="mx-2">
                            <span class="hover" onclick="auto_check('noil');"> 느와르 </span>
                        </div>
                    </form>

                    <div class="d-flex justify-content-center py-4 mt-4">
                        <div>
                            <button type="button" class="btn btn-primary ml-1" onclick="register();" > 회원가입 </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </body>
</html>