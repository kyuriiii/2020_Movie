<script>
    var nowGenre = "romance";
    var genreArr = {
        "action" : "0",
        "horror" : "1",
        "animation" : "2",
        "romance" : "3",
        "comedy" : "4",
        "fantasy" : "5",
        "mystery" : "6",
        "noil" : "7",
    };

    function form_trim( obj ){
        if ( !$( obj ).val() ) return false;

        $( obj ).val( $( obj ).val().trim() );
    }

    function modal_draggable(){
        $( ".modal-dialog" ).draggable( {
            cursor : "move",
            cancel : "select, input, textarea, button, .cke",
        } );
    }

    function phone_validation( obj ){
        if ( obj.value == "" ) return false;

        if ( obj.value.length < 11 ) {
            alert( "휴대폰 번호를 <?=TITLE_PHONE?> 형식에 맞게 입력해주십시오." );

            return false;
        }
        else if ( obj.value.length == 11 ){
            var contact = obj.value.substr( 0, 3 );

            contact += "-" + obj.value.substr( 3, 4 );

            contact += "-" + obj.value.substr( 7 );

            obj.value = contact;
        }
    }

    function login(){
        var form = document.getElementById( "form_login" );

        form_trim( form.userID );
        form_trim( form.password );

        if ( !form.checkValidity() ){
            html5_validation_report( form );

            return false;
        }

        $.post(
            "<?=base_url( 'mjumovie/user_control' )?>",
            { mode:"login", userID:form.userID.value, password:form.password.value },
            function( data ){
                var json = JSON.parse( data );

                if ( json["<?=KEY_POST_RETURN?>"] == "<?=VAL_POST_RETURN_TRUE?>" ){
                    alert( "환영합니다. " + json["name"] + " 고객님" );

                    document.location.reload();
                }
                else alert( json["<?=KEY_POST_MSG?>"] );
            }
        );
    }

    function reservation( id ){
        <?
            if ( !isset( $_SESSION["user_ID"] ) ){
                echo "loginModal();";
            } else {
        ?>
            $.post(
                "<?=base_url( 'mjumovie/movie_control' )?>",
                { mode: "pre_reserve", movie_ID:id },
                function( data ){
                    var json = JSON.parse( data );

                    if ( json["<?=KEY_POST_RETURN?>"] == "<?=VAL_POST_RETURN_TRUE?>" ){
                        $( "#modal_reserve" ).html( json["html"] );

                        $( "#modal_reserve" ).modal( "show" );

                        reserve_setting();
                    }
                    else alert( json["<?=KEY_POST_MSG?>"] );
                }
            );
        <?
            }
        ?>
    }

    function check( mode ){
        var form = document.getElementById( "form_login" );

        form_trim( form.userID );
        form_trim( form.name );
        form_trim( form.contact );

        if ( !form.checkValidity() ){
            html5_validation_report( form );

            return false;
        }

        $.post(
            "<?=base_url( 'mjumovie/user_control' )?>",
            { mode:mode, name:form.name.value, userID: form.userID.value, contact:form.contact.value },
            function( data ){
                var json = JSON.parse( data );

                if ( json["<?=KEY_POST_RETURN?>"] == "<?=VAL_POST_RETURN_TRUE?>" ){
                    if ( json["mode"] == "findID" ) alert( "고객님의 아이디는 " + json["id"] + " 입니다." );
                    else alert( "고객님의 비밀번호는 " + json["pw"] + " 입니다." );
                }
                else alert( json["<?=KEY_POST_MSG?>"] );

                form.reset();
            }
        );
    }

    function find( type ){
        $.post(
            "<?=base_url( 'mjumovie/findView' )?>",
            { type:type },
            function( data ){
                var json = JSON.parse( data );

                if ( json["<?=KEY_POST_RETURN?>"] == "<?=VAL_POST_RETURN_TRUE?>" ){
                    $( "#form_login" ).html( json["html"] );
                }
                else alert( json["<?=KEY_POST_MSG?>"] );
            }
        );
    }

    function loginModal(){
        $( "#modal_login" ).modal( "show" );
    }

    function html5_validation_report( obj ){
        if ( obj.reportValidity ) obj.reportValidity();
        else alert( "잘못 입력된 데이터가 있습니다. 정확한 오류원인을 보기 위해서는 Chrome을 이용하세요." );
    }

    function locationSelect( obj, id ){
        $( ".theater-place-wrapper" ).addClass( "d-none" );
        $( "#theater_" + id ).removeClass( "d-none" );

        $( ".btn-outline-secondary" ).removeClass( "active" );
        $( obj ).addClass( "active" );
    }

    function theaterSelect( obj, id ){
        $( ".btn-outline-info" ).removeClass( "active" );
        $( obj ).addClass( "active" );

        var form = document.getElementById( "form_movie_reserve" );
        form.theater_ID.value = id;
    }

    function dayClick( obj, date ){
        $( "td" ).removeClass( "active" );
        $( obj ).addClass( "active" );

        if ( $( ".reserve-time" ).hasClass( "d-none" ) ) $( ".reserve-time" ).removeClass( "d-none" );

        var form = document.getElementById( "form_movie_reserve" );
        form.date.value = date;
    }

    function timeSelect( obj ){
        $( ".btn-outline-warning" ).removeClass( "active" );
        $( obj ).addClass( "active" );

        var form = document.getElementById( "form_movie_reserve" );
        var child = $( obj ).children();

        form.time.value = $( child[0] ).text();
    }

    function reserveStep2( obj ){
        var form = document.getElementById( "form_movie_reserve" );

        if ( form.theater_ID.value == "" ){ alert( "영화관을 선택해주세요." ); return false; }
        if ( form.date.value == "" ){ alert( "날짜를 선택해주세요." ); return false; }
        if ( form.time.value == "" ){ alert( "시간을 선택해주세요." ); return false; }

        var child = $( "#ul_reserve" ).children();

        $( child[0] ).switchClass( "active", "disabled" );
        $( child[1] ).switchClass( "disabled", "active" );

        $( "#reserveStep01" ).addClass( "d-none" );
        $( "#reserveStep02" ).removeClass( "d-none" );

        $( obj ).text( "예매하기" );
        $( obj ).attr( "onclick", "reserve();" );

        $( "#reserve_date_span" ).text( form.date.value );
    }
    var price = 12000; //price
    function reserve_setting(){
        var $cart = $('#selected-seats'),
            $counter = $('#counter'),
            $total = $('#total');

        var sc = $('#seat-map').seatCharts({
            map: [
                'aaaaaaaaaa',
                'aaaaaaaaaa',
                '__________',
                'aaaaaaaa__',
                'aaaaaaaaaa',
                'aaaaaaaaaa',
                'aaaaaaaaaa',
                'aaaaaaaaaa',
                'aaaaaaaaaa',
                'aa__aa__aa'
            ],
            naming: {
                top: false,
                getLabel: function (character, row, column) {
                    return column;
                }
            },
            legend: {
                node: $('#legend'),
                items: [
                    ['a', 'available', '선택가능'],
                    ['a', 'unavailable', '선택불가'],
                    ['a', 'selected', '선택됨']
                ]
            },
            click: function () {
                if (this.status() == 'available') {
                    $('<li>R' + (this.settings.row + 1) + '-S' + this.settings.label + '</li>')
                        .attr('id', 'cart-item-' + this.settings.id)
                        .data('seatId', this.settings.id)
                        .appendTo($cart);

                    $counter.text(sc.find('selected').length + 1);
                    $total.text(getTotal(sc) + price);

                    return 'selected';
                } else if (this.status() == 'selected') {
                    $counter.text(sc.find('selected').length - 1);
                    $total.text(getTotal(sc) - price);
                    $('#cart-item-' + this.settings.id).remove();
                    return 'available';
                } else if (this.status() == 'unavailable') {
                    return 'unavailable';
                } else {
                    return this.style();
                }
            }
        });
        sc.get(['1_3', '4_4', '4_5', '6_6', '6_7', '8_5', '8_6', '8_7', '8_8', '9_3', '9_4','10_1', '10_2']).status('unavailable');
    }
    // 최종 결제 금액
    function getTotal(sc) {
        var total = 0;
        sc.find('selected').each(function () {
            total += price;
        });

        return total;
    }
    function reserve(){
        var form = document.getElementById( "form_movie_reserve" );
        form_trim( form.time );

        var selectedSeat = document.querySelector( "#selected-seats" );
        var count = 0;

        var seatName = "/";

        for ( var j = 0; j < $( selectedSeat ).children().length; j++ ){
            var liSelect = $( selectedSeat ).children()[j];
            seatName = seatName + $( liSelect ).text() + "/";
            count++;
        }

        $.post(
            "<?=base_url( 'mjumovie/movie_control' )?>",
            { mode:"reserve", movie_ID:form.movie_ID.value, theater_ID:form.theater_ID.value, time:form.time.value, date:form.date.value, num:count, seat:seatName},
            function( data ){
                var json = JSON.parse( data );

                if ( json["<?=KEY_POST_RETURN?>"] == "<?=VAL_POST_RETURN_TRUE?>" ){
                    alert( "영화 예매가 완료되었습니다." );

                    $( "#modal_reserve" ).modal( "hide" );
                }
                else alert( json["<?=KEY_POST_MSG?>"] );
            }
        );
    }
</script>