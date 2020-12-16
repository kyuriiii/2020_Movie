<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mjumovie extends CI_Controller {
    public $member;

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $locations = $this->model_tools->get_by_where( DB_TABLE_MOVIE_LOCATION );
        $theaters = array();
        foreach ( $locations->result_array() as $location ){
            $where = array(
                "location_ID" => $location["ID"]
            );

            $order = array( array( "name", "ASC" ) );

            $result = $this->model_tools->get_by_where( DB_TABLE_MOVIE_THEATER, $where, $order );

            $data = array(
                "name"    => $location["name"],
                "cnt"     => $result->num_rows(),
                "theater" => $result
            );

            array_push( $theaters, $data );
        }

        $data = array(
            "events"        => $this->model_tools->get_by_where( DB_TABLE_EVENT ),
            "theaters"      => $theaters
        );

        if ( isset( $_SESSION["user_ID"] ) ){
            $user = $this->model_tools->get_self();

            $where = array(
                "user_ID" => $user["ID"]
            );

            $user["genre"] = $this->model_tools->get_by_where( DB_TABLE_USER_GENRE, $where );

            $data["user"] = $user;

            $data["likes"] = $this->model_tools->get_by_where( DB_TABLE_USER_MOVIE, $where );

            $data["reserves"] = $this->model_tools->get_reserve_with_movie( $user["ID"] );

            foreach ( $data["reserves"]->result_array() as $reserve ){
                $where = array(
                    "reserve_ID" => $reserve["ID"]
                );

                $seats = $this->model_tools->get_by_where( DB_TABLE_USER_RESERVE_SEAT, $where );

                $selectedSeat = array();
                foreach ( $seats->result_array() as $seat ){
                    array_push( $selectedSeat, $seat["seat"] );
                }
                $data["seats"][$reserve["ID"]] = $selectedSeat;
            }
        }

        $this->load->view( "movie/index", $data );
    }

    public function sample()
    {
        $locations = $this->model_tools->get_by_where( DB_TABLE_MOVIE_LOCATION );
        $theaters = array();
        foreach ( $locations->result_array() as $location ){
            $where = array(
                "location_ID" => $location["ID"]
            );

            $order = array( array( "name", "ASC" ) );

            $result = $this->model_tools->get_by_where( DB_TABLE_MOVIE_THEATER, $where, $order );

            $data = array(
                "name"    => $location["name"],
                "cnt"     => $result->num_rows(),
                "theater" => $result
            );

            array_push( $theaters, $data );
        }

        $data = array(
            "events"   => $this->model_tools->get_by_where( DB_TABLE_EVENT ),
            "theaters" => $theaters
        );

        if ( isset( $_SESSION["user_ID"] ) ){
            $data["user"] = $this->model_tools->get_self();
        }

        $this->load->view( "movie/index_sample", $data );
    }

    public function mainMovie( $genre ){
        $this->load->view( "movie/".$genre );
    }

    public function movie_detail()
    {
        $this->form_validation->set_rules( "mode", "", "required|in_list[v1,v2]" );
        $this->form_validation->set_rules( "movie_ID", "", "required|is_natural_no_zero" );

        if ( !$this->form_validation->run() ){
            $this->library_tool->error_msg( validation_errors( " ", " " ) );

            return false;
        }

        if ( !$movie = $this->model_tools->get( DB_TABLE_MOVIE, $this->input->post( "movie_ID" ) ) ){
            $this->library_tool->error_msg( ERRORMSG_WRONGDATA );

            return false;
        }

        $i = 0;
        foreach ( $this->library_tool->genre as $k => $v ){
            if ( $movie["genre"] == $k ) break;
            else $i++;
        }

        $where = array(
            "movie_ID" => $this->input->post( "movie_ID" )
        );

        $movie["actors"] = $this->model_tools->get_by_where( DB_TABLE_MOVIE_ACTOR, $where );

        $score_sum = 0;

        $reviews = $this->model_tools->get_by_where( DB_TABLE_MOVIE_REVIEW, $where );
        foreach ( $reviews->result_array() as $review ){
            $score_sum += $review["score"];
        }

        if ( $reviews->num_rows() != 0 ) $score = intval( $score_sum / $reviews->num_rows() );
        else $score = 0;

        $data = array(
            "movie"   => $movie,
            "reviews" => $reviews,
            "score"   => $score,
            "index"   => $i * 10
        );

        if ( isset( $_SESSION["user_ID"] ) ) {
            $where = array(
                "user_ID"  => $_SESSION["user_ID"],
                "movie_ID" => $this->input->post( "movie_ID" )
            );

            if ( $this->model_tools->get_by_where( DB_TABLE_USER_MOVIE, $where, array(), 1 ) ) $like = true;
            else $like = false;

            $data["reserves"] = $this->model_tools->get_reserve_with_movie( $_SESSION["user_ID"] );

            foreach ( $data["reserves"]->result_array() as $reserve ){
                $where = array(
                    "reserve_ID" => $reserve["ID"]
                );

                $seats = $this->model_tools->get_by_where( DB_TABLE_USER_RESERVE_SEAT, $where );

                $selectedSeat = array();
                foreach ( $seats->result_array() as $seat ){
                    array_push( $selectedSeat, $seat["seat"] );
                }
                $data["seats"][$reserve["ID"]] = $selectedSeat;
            }
        }
        else $like = false;

        $data["like"] = $like;

        if ( isset( $_SESSION["user_ID"] ) ){
            $data["user"] = $this->model_tools->get_self();
        }

        $this->load->view( "movie/movie_detail_".$this->input->post( "mode" ), $data );
    }

    public function movie_control()
    {
        $this->form_validation->set_rules( "mode", "", "required|in_list[pre_reserve,reserve,like,review]" );
        $this->form_validation->set_rules( "movie_ID", "", "required|is_natural_no_zero" );

        switch ( $this->input->post( "mode" ) ){
            case "reserve":
                $this->form_validation->set_rules( "theater_ID", "", "required|is_natural_no_zero" );
                $this->form_validation->set_rules( "num", "", "required|is_natural_no_zero" );
                $this->form_validation->set_rules( "date", "", "required" );
                $this->form_validation->set_rules( "time", "", "required" );
                $this->form_validation->set_rules( "seat", "", "required" );
            break;
        }

        if ( !$this->form_validation->run() ){
            $this->library_tool->error_msg( validation_errors( " ", " " ) );

            return false;
        }

        switch ( $this->input->post( "mode" ) ){
            case "pre_reserve":
                $locations = $this->model_tools->get_by_where( DB_TABLE_MOVIE_LOCATION );
                $theaters = array();
                foreach ( $locations->result_array() as $location ){
                    $where = array(
                        "location_ID" => $location["ID"]
                    );

                    $order = array( array( "name", "ASC" ) );

                    $result = $this->model_tools->get_by_where( DB_TABLE_MOVIE_THEATER, $where, $order );

                    $data = array(
                        "name"    => $location["name"],
                        "cnt"     => $result->num_rows(),
                        "theater" => $result
                    );

                    array_push( $theaters, $data );
                }

                $data = array(
                    "theaters" => $theaters
                );

                if ( $this->input->post( "movie_ID" ) != "" ){
                    $movie = $this->model_tools->get( DB_TABLE_MOVIE, $this->input->post( "movie_ID" ) );

                    $data["movie"] = $movie;
                }

                $rand = rand( 1,3 );
                $data["time"] = $this->load->view( "movie/reserve/time_v".$rand, $data, true );

                $data_json = array(
                    KEY_POST_RETURN => VAL_POST_RETURN_TRUE,
                    "html"          => $this->load->view( "movie/modal_reserve", $data, true )
                );

                print( json_encode( $data_json ) );
            break;

            case "reserve":
                $seats = explode( "/", substr( $this->input->post( "seat" ), 1, -1 ) );

                $data = array(
                    "user_ID"    => $_SESSION["user_ID"],
                    "movie_ID"   => $this->input->post( "movie_ID" ),
                    "theater_ID" => $this->input->post( "theater_ID" ),
                    "date"       => $this->input->post( "date" ),
                    "time"       => $this->input->post( "time" ),
                    "num"        => $this->input->post( "num" )
                );

                if ( !$inserted_ID = $this->model_tools->insert( DB_TABLE_USER_RESERVE, $data ) ){
                    $this->library_tool->error_msg( ERRORMSG_UNKNOWN );

                    return false;
                }

                for ( $i = 0; $i < sizeof( $seats ); $i++ ){
                    $data = array(
                        "reserve_ID" => $inserted_ID,
                        "seat"       => $seats[$i]
                    );

                    if ( !$this->model_tools->insert( DB_TABLE_USER_RESERVE_SEAT, $data ) ){
                        $this->library_tool->error_msg( ERRORMSG_UNKNOWN );

                        return false;
                    }
                }

                $this->library_tool->return_true();
            break;

            case "like":
                $user = $this->model_tools->get_self();

                if ( $this->input->post( "active" ) == "on" ){
                    $data = array(
                        "user_ID"  => $user["ID"],
                        "movie_ID" => $this->input->post( "movie_ID" )
                    );

                    if ( !$this->model_tools->insert( DB_TABLE_USER_MOVIE, $data ) ) $this->library_tool->error_msg( ERRORMSG_UNKNOWN );
                    else $this->library_tool->return_true();
                }
                else {
                    $where = array(
                        "user_ID"  => $user["ID"],
                        "movie_ID" => $this->input->post( "movie_ID" )
                    );

                    if ( !$this->model_tools->delete_by_where( DB_TABLE_USER_MOVIE, $where ) ) $this->library_tool->error_msg( ERRORMSG_UNKNOWN );
                    else $this->library_tool->return_true();
                }
            break;

            case "review":
                $data = array(
                    "user_ID"  => $_SESSION["user_ID"],
                    "movie_ID" => $this->input->post( "movie_ID" ),
                    "comment"  => $this->input->post( "comment" ),
                    "score"    => $this->input->post( "score" )
                );

                if ( !$inserted_ID = $this->model_tools->insert( DB_TABLE_MOVIE_REVIEW, $data ) ){
                    $this->library_tool->error_msg( ERRORMSG_UNKNOWN );

                    return false;
                }

                $review = $this->model_tools->get( DB_TABLE_MOVIE_REVIEW, $inserted_ID );

                $html = $this->library_tool->return_review_list( $review );

                $data_json = array(
                    KEY_POST_RETURN => VAL_POST_RETURN_TRUE,
                    "html"          => $html
                );

                print( json_encode( $data_json ) );
            break;
        }
    }

    public function findView(){
        $this->form_validation->set_rules( "type", "", "required|in_list[login,ID,PW]" );

        if ( !$this->form_validation->run() ){
            $this->library_tool->error_msg( validation_errors( " ", " " ) );

            return false;
        }

        switch ( $this->input->post( "type" ) ){
            case "login" :
                $html =
                "<input type='text' class='input-field' placeholder='아이디' name='userID' required>
                <input type='password' class='input-field' placeholder='비밀번호' name='password' onkeypress='if ( event.keyCode == 13 ) logind();' required>
                
                <div class='my-3 text-center'>
                    <span class='find-span hover' onclick=\"find('ID');\">ID 찾기</span>
                    <span class='find-span hover' onclick=\"find('PW');\">PW 찾기</span>
                </div>
                
                <button type='button' class='submit' onclick='login();'>Login</button>";
            break;

            case "ID" :
                $html =
                "<input type='hidden' class='input-field' placeholder='아이디' name='userID' value=''>
                <input type='text' class='input-field' placeholder='이름' name='name' required>
                <input type='tel' class='input-field' placeholder='전화번호' name='contact' onfocusout='phone_validation( this );' pattern='".PATTERN_PHONE."' title='".TITLE_PHONE."' required>
                
                <button type='button' class='submit' onclick=\"check( 'findID' );\">ID 찾기</button>";
            break;

            case "PW" :
                $html =
                "<input type='text' class='input-field' placeholder='아이디' name='userID' required>
                <input type='text' class='input-field' placeholder='이름' name='name' required>
                <input type='tel' class='input-field' placeholder='전화번호' name='contact' onfocusout='phone_validation( this );' pattern='".PATTERN_PHONE."' title='".TITLE_PHONE."' required>
                
                <button type='button' class='submit' onclick=\"check( 'findPW' );\">PW 찾기</button>";
            break;
        }

        $data_json = array(
            KEY_POST_RETURN => VAL_POST_RETURN_TRUE,
            "html"          => $html
        );

        print( json_encode( $data_json ) );
    }

    public function user_control(){
        $this->form_validation->set_rules( "mode", "", "required|in_list[findID,findPW,idCheck,register,login,delete,update]" );

        switch ( $this->input->post( "mode" ) ){
            case "findID" :
            case "findPW" :
                $this->form_validation->set_rules( "name", "", "required" );
                $this->form_validation->set_rules( "contact", "", "required|regex_match[/".PATTERN_PHONE."/]" );
            break;

            case "register" :
                $this->form_validation->set_rules( "userID", "", "required" );
                $this->form_validation->set_rules( "name", "", "required" );
                $this->form_validation->set_rules( "password", "", "required" );
                $this->form_validation->set_rules( "contact", "", "required|regex_match[/".PATTERN_PHONE."/]" );
                $this->form_validation->set_rules( "birth", "", "required|regex_match[/".PATTERN_DATE."/]" );
            break;

            case "login" :
                $this->form_validation->set_rules( "userID", "", "required" );
                $this->form_validation->set_rules( "password", "", "required" );
            break;

            case "delete" :
                $this->form_validation->set_rules( "user_ID", "", "required|is_natural_no_zero" );
            break;

            case "update":
                $this->form_validation->set_rules( "user_ID", "", "required|is_natural_no_zero" );
                $this->form_validation->set_rules( "name", "", "required" );
                $this->form_validation->set_rules( "password", "", "required" );
                $this->form_validation->set_rules( "contact", "", "required|regex_match[/".PATTERN_PHONE."/]" );
                $this->form_validation->set_rules( "birth", "", "required|regex_match[/".PATTERN_DATE."/]" );
            break;
        }
        if ( !$this->form_validation->run() ){
            $this->library_tool->error_msg( validation_errors( " ", " " ) );

            return false;
        }

        switch ( $this->input->post( "mode" ) ){
            case "idCheck" :
                $where = array(
                    "userID" => $this->input->post( "userID" )
                );

                if ( $this->model_tools->get_by_where( DB_TABLE_USERS, $where, array(), 1 ) ){
                    $this->library_tool->error_msg( "사용할 수 없는 아이디입니다." );

                    return false;
                }
                else {
                    $this->library_tool->return_true();
                }
            break;

            case "register":
                $data = array(
                    "userID"   => $this->input->post( "userID" ),
                    "password" => $this->input->post( "password" ),
                    "name"     => $this->input->post( "name" ),
                    "contact"  => $this->input->post( "contact" ),
                    "birth"    => $this->input->post( "birth" )
                );

                if ( !$inserted_ID = $this->model_tools->insert( DB_TABLE_USERS, $data ) ){
                    echo ERRORMSG_UNKNOWN;

                    echo "<br> 3초 후에 메인 화면으로 돌아갑니다.";

                    echo
                    "<script>
                        setTimeout( \"document.location.href='".base_url()."'\", 3000 );
                    </script>";

                    return false;
                }

                for( $i = 0; $i < sizeof( $_POST["genre"] ); $i++ ){
                    $data = array(
                        "user_ID" => $inserted_ID,
                        "genre"   => $_POST["genre"][$i]
                    );

                    if ( !$this->model_tools->insert( DB_TABLE_USER_GENRE, $data ) ){
                        echo ERRORMSG_UNKNOWN;

                        echo "<br> 3초 후에 메인 화면으로 돌아갑니다.";

                        echo
                        "<script>
                            setTimeout( \"document.location.href='".base_url()."'\", 3000 );
                        </script>";

                        return false;
                    }
                }

                echo "회원가입이 완료되었습니다. \n 3초 후에 메인 화면으로 돌아갑니다.";
                echo
                    "<script>
                        setTimeout( \"document.location.href='".base_url()."'\", 2000 );
                    </script>";
            break;

            case "login" :
                $where = array(
                    "userID"   => $this->input->post( "userID" ),
                    "password" => $this->input->post( "password" )
                );

                if ( !$user = $this->model_tools->get_by_where( DB_TABLE_USERS, $where, array(), 1 ) ){
                    $this->library_tool->error_msg( "아이디 혹은 비밀번호가 틀렸습니다." );

                    return false;
                }

                $this->session->set_userdata( "user_ID", $user["ID"] );

                $data_json = array(
                    KEY_POST_RETURN => VAL_POST_RETURN_TRUE,
                    "name"          => $user["name"]
                );

                print( json_encode( $data_json ) );
            break;

            case "findID":
                $where = array(
                    "name"    => $this->input->post( "name" ),
                    "contact" => $this->input->post( "contact" )
                );

                if ( !$user = $this->model_tools->get_by_where( DB_TABLE_USERS, $where, array(), 1 ) ){
                    $this->library_tool->error_msg( "일치하는 정보가 없습니다." );

                    return false;
                }

                $data_json = array(
                    KEY_POST_RETURN => VAL_POST_RETURN_TRUE,
                    "mode"          => $this->input->post( "mode" ),
                    "id"            => $user["userID"]
                );

                print( json_encode( $data_json ) );
            break;

            case "findPW" :
                $where = array(
                    "userID"  => $this->input->post( "userID" ),
                    "name"    => $this->input->post( "name" ),
                    "contact" => $this->input->post( "contact" )
                );

                if ( !$user = $this->model_tools->get_by_where( DB_TABLE_USERS, $where, array(), 1 ) ){
                    $this->library_tool->error_msg( "일치하는 정보가 없습니다." );

                    return false;
                }

                $data_json = array(
                    KEY_POST_RETURN => VAL_POST_RETURN_TRUE,
                    "mode"          => $this->input->post( "mode" ),
                    "pw"            => $user["password"]
                );

                print( json_encode( $data_json ) );
            break;

            case "delete" :

            break;

            case "update":

            break;
        }
    }

    public function logout(){
        unset( $_SESSION["user_ID"] );

        echo
        "<script>
			setTimeout( \"document.location.href='".base_url()."'\", 1 );
		</script>";
    }

    public function register(){
        $this->load->view( "movie/register" );
    }
}
