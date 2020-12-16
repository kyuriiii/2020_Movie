    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title lotte_font" id="introHeader">
                    <?
                        if ( !isset( $movie ) ) echo "영화 예매";
                        else echo $movie["name"]." 예매";
                    ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="d-none" id="form_movie_reserve">
                    <input type="hidden" name="theater_ID">
                    <?
                        if ( !isset( $movie ) ) echo "<input type='hidden' name='movie_ID'>";
                        else echo "<input type='hidden' name='movie_ID' value='".$movie["ID"]."'>";
                    ?>
                    <input type="hidden" name="date">
                    <input type="hidden" name="time">
                    <input type="hidden" name="seat">
                </form>
                <div class="reserve-container">
                    <div class="row w-100 h-100">
                        <div class="col-2">
                            <div class="section_reserve_step">
                                <ul id="ul_reserve">
                                    <li class="active">
                                        <a href="#reserveStep01">
                                            <strong><span>01</span> <br>상영시간 </strong>
                                        </a>
                                    </li>
                                    <li class="disabled">
                                        <a href="#reserveStep02">
                                            <strong>
                                                <span>02</span> <br>
                                                인원 / 좌석
                                            </strong>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="reserveStep01" class="row col">
                            <div class="col" id="reserve-theater-part">
                                <div class="reserve-title">THEATER</div>
                                <div class="theater-continer row">
                                    <div class="theater-location-wrapper col-5">
                                        <?
                                        for ( $i = 0; $i < sizeof( $theaters ); $i++ ){
                                            if ( $i == 0 ) $class = " active";
                                            else $class = "";

                                            echo "<button class='btn btn-outline-secondary btn-sm".$class."' onclick='locationSelect( this, ".$i." );'>".$theaters[$i]["name"]."(".$theaters[$i]["cnt"].")</button>";
                                        }
                                        ?>
                                    </div>
                                    <?
                                    for ( $i = 0; $i < sizeof( $theaters ); $i++ ){
                                        if ( $i == 0 ) $class = "";
                                        else $class = " d-none";

                                        echo "<div class='theater-place-wrapper col-7".$class."' id='theater_".$i."'>";

                                        foreach ( $theaters[$i]["theater"]->result_array() as $theater ){
                                            echo "<button class='btn btn-sm btn-outline-info' onclick='theaterSelect( this, ".$theater["ID"]." )'>".$theater["name"]."</button>";
                                        }
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <?
                                if ( !isset( $movie ) ){
                            ?>
                                <div class="col" id="reserve-movie-part">
                                    <div class="reserve-title">MOVIE</div>
                                    <div class="sort-wrapper">
                                        <div class="sort-rate sort-selected">예매율순</div>
                                        <div class="sort-korean">가나다순</div>
                                    </div>
                                    <div class="movie-list-wrapper">
                                        <div class="movie-list">
                                        </div>
                                    </div>
                                </div>
                            <?
                                }
                            ?>
                            <div class="col" id="reserve-day-part">
                                <div class="reserve-title">DAY</div>
                                <div class="reserve-day">
                                    <table class="table calendar">
                                        <tr>
                                            <?
                                            $year = date("Y");
                                            $month = date("m");
                                            $now_day = date( "j" );
                                            $now = $now_day;

                                            for ( $i = 0; $i < 5; $i++ ){
                                                if ( $now_day > 30 ) {
                                                    $now_day = 1;
                                                    $month = $month + 1;
                                                }

                                                if ( $now_day < $now )

                                                if ( $month < 10 ) $month = "0".strval( $month );
                                                else $month = $month;

                                                if ( $now_day < 10 ) $day = "0".strval( $now_day );
                                                else $day = $now_day;

                                                $date = $year."-".$month."-".$day;

                                                $day_kor = array( "일", "월", "화", "수", "목", "금", "토" );
                                                $dya_num = date( "w", strtotime( $date ) );

                                                if ( $dya_num == 0 ) $class = " sunday";
                                                else if ( $dya_num==6 ) $class = " saturday";
                                                else $class = "";

                                                echo
                                                    "<td onclick=\"dayClick(this, '".$date."');\">
                                                            <div class='font-weight-bold".$class."'>
                                                                ".$day."
                                                            </div>";

                                                echo "<div class='".$class."'>
                                                                ".$day_kor[$dya_num]."
                                                            </div>
                                                        </td>";

                                                $now_day++;
                                            }
                                            ?>
                                        </tr>
                                    </table>
                                </div>
                                <div class="reserve-time d-none">
                                    <?=$time?>
                                </div>
                            </div>
                        </div>

                        <div id="reserveStep02" class="row col d-none">
                            <div class="col-6" id="reserve-theater-part">
                                <div class="reserve-title">Seat</div>
                                <div>
                                    <div id="seat-map">
                                        <div class="screen">SCREEN</div>
                                    </div>

                                    <div style="clear:both"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="reserve-title">Movie</div>
                                <div class="movie-continer">
                                    <div class="booking-details d=flex justify-content-center">
                                        <p><span><strong><?=$movie["name"]?></strong></span><span><img src="<?=base_url( "movie/age/" ).$movie["age"].".png"?>" width="18px;"></span></p>
                                        <p><span id="reserve_date_span"></span></p>

                                        <p>선택 좌석: </p>
                                        <ul id="selected-seats"></ul>
                                        <p>성인 <span id="counter">0</span></p>
                                        <p>최종 결제 금액 <b><span id="total">0</span></b>원</p>
                                        <div id="legend"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" class="reservation">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button type="button" id="btn_reserve" class="btn btn-primary" onclick="reserveStep2( this );">인원/좌석 선택</button>
                </div>
            </div>
        </div>
    </div>
</div>