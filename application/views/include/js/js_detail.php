<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.4/TweenMax.min.js'></script>
<script>
    function score_star( obj ){
        $( obj ).parent().children( "span" ).removeClass( "on" );
        $( obj ).addClass( "on" ).prevAll( "span" ).addClass( "on" );
    }

    function review_write(){
        var form = document.getElementById( "form_review" );

        var rating = 0;

        for ( var i = 0; i < $( "#span_stars" ).children().length; i++ ){
            var star = $( "#span_stars" ).children()[i];
            if ( $( star ).hasClass( "on" ) ){
                rating++;
            }
        }

        $.post(
            "<?=base_url( 'mjumovie/movie_control' )?>",
            { mode: "review", movie_ID: <?=$movie["ID"]?>, comment: form.comment.value, score: rating },
            function( data ){
                var json = JSON.parse( data );

                if ( json["<?=KEY_POST_RETURN?>"] == "<?=VAL_POST_RETURN_TRUE?>" ){
                    var selector = document.querySelectorAll( "#review > div" );

                    $( selector[0] ).append( json["html"] );

                    form.reset();
                }
                else alert( json["<?=KEY_POST_MSG?>"] );
            }
        );
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

    function versionChange()
    {
        var form = document.getElementById( "form_detail" );

        form.submit();
    }
</script>