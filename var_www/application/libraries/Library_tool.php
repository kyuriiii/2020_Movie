<? if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Library_tool {
	private $CI;
	public $genre;
	public $event_type;

	public function __construct()
	{
		$this->CI = & get_instance();

		$this->genre = array(
            "action"    => "액션",
		    "horror"    => "호러",
            "animation" => "애니매이션",
		    "romance"   => "로맨스",
            "comedy"    => "코미디",
            "fantasy"   => "판타지",
            "mystery"   => "미스테리",
            "noil"      => "느와르"
        );

		$this->event_type = array( "movie", "sale", "corona" );
	}

    public function html_header( $data )
	{
		$html =
		"<html>

			<head>
				<meta charset='utf-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>";

                if ( isset( $data["jquery"] ) ) $html = $html.$this->CI->load->view( "include/include_jquery", array(), true );

                if ( isset( $data["bootstrap"] ) ) $html = $html.$this->CI->load->view( "include/include_bootstrap", array(), true );

                if ( isset( $data["css"] ) ){
					for ( $i = 0; $i < sizeof( $data["css"] ); $i++ ){
						$html = $html.$this->CI->load->view( "include/css/".$data["css"][$i], array(), true );
					}
				}

				if ( isset( $data["js"] ) ){
					for ( $i = 0; $i < sizeof( $data["js"] ); $i++ ){
						$html = $html.$this->CI->load->view( "include/js/".$data["js"][$i], array(), true );
					}
				}

		return $html;
	}

	public function return_true()
	{
		$data_json = array(
			KEY_POST_RETURN => VAL_POST_RETURN_TRUE
		);

		print ( json_encode( $data_json ) );
	}

	public function photo_delete( $movie )
    {
        unlink( "img/movie/".$movie  );

        return true;
    }

	public function error_msg( $msg )
	{
	    if ( $msg == ERRORMSG_WRONGTOKEN ){
            if ( !( isset( $_POST ) && sizeof( $_POST ) > 0 ) || $this->CI->input->post( "is_new_window" ) == "true" ){
                echo "<p>이미 다른 기기에서 접속 중인 계정입니다.</p>";

                return false;
            }
        }

	    if ( ( isset( $_POST ) && sizeof( $_POST ) > 0 ) && $this->CI->input->post( "is_new_window" ) != "true" ){
            $data_json = array(
                KEY_POST_RETURN => VAL_POST_RETURN_FALSE,
                KEY_POST_MSG    => $msg
            );

            print ( json_encode( $data_json ) );
        }
        else echo $msg;

		return false;
	}

	public function return_genre_kor( $eng ){
        foreach ( $this->genre as $e => $k ){
            if ( $e == $eng ) return $k;

            // 한글이 들어왔을 경우, 그대로 리턴
            if ( $k == $eng ) return $k;
        }

        return false;
    }

    public function return_review_list( $review ){
	    $user = $this->CI->model_tools->get( DB_TABLE_USERS, $review["user_ID"] );

	    $html =
	    "<div class='mb-3'>
            <div>
                <img src='".base_url( "movie/people.jpeg" )."' class='card-img ml-5 mb-3' style='width:60px'>
                <span class='mr-5 ml-2'>".$user["userID"]."</span>";

                for ( $i = 1; $i < 6; $i ++ ){
                    $html = $html."<span class='starR";

                    if ( $i <= $review["score"] ) $html = $html." on";

                    $html = $html."'></span>";
                }


                $html = $html.
                "<div class='ml-5 pl-5'>".$review["comment"]."</div>
            </div>
        </div>";

	    return $html;
    }
}
?>