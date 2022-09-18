<? if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Model_tools extends CI_Model {

    public function get_self()
    {
        $this->db->where( "ID", $_SESSION["user_ID"] );

        $this->db->limit( 1 );

        $result = $this->db->get( DB_TABLE_USERS );

        if ( $result->num_rows() == 0 ) return false;

        return $result->row_array();
    }

	public function insert( $table, $data )
	{
		if ( !$this->db->insert( $table, $data ) ) return false;

		return $this->db->insert_id();
	}

	public function get( $table, $ID )
	{
		$this->db->where( "ID", $ID );

		$this->db->limit( 1 );

		$result = $this->db->get( $table );

		return $result->row_array();
	}

	public function get_by_where( $table, $where = array(), $order = array(), $limit = 0 )
	{
		$this->db->where( $where );

		if ( sizeof( $order ) > 0 ){
			for ( $i = 0; $i < sizeof( $order ); $i++ ) $this->db->order_by( $order[$i][0], $order[$i][1] );
		}

		if ( $limit > 0 ) $this->db->limit( $limit );

		$result = $this->db->get( $table );

		if ( $limit == 1 ){
			if ( $result->num_rows() == 0 ) return array();
			else return $result->row_array();
		}
		else return $result;
	}

	public function get_reserve_with_movie( $user_ID )
    {
        $this->db->select( DB_TABLE_MOVIE.".*, ".DB_TABLE_USER_RESERVE.".*, ".DB_TABLE_MOVIE_THEATER.".name AS theater, ".DB_TABLE_MOVIE_LOCATION.".name AS location" );

        $this->db->join( DB_TABLE_MOVIE, DB_TABLE_USER_RESERVE.".movie_ID = ".DB_TABLE_MOVIE.".ID", "inner" );
        $this->db->join( DB_TABLE_MOVIE_THEATER, DB_TABLE_USER_RESERVE.".theater_ID = ".DB_TABLE_MOVIE_THEATER.".ID", "inner" );
        $this->db->join( DB_TABLE_MOVIE_LOCATION, DB_TABLE_MOVIE_THEATER.".location_ID = ".DB_TABLE_MOVIE_LOCATION.".ID", "inner" );

        $this->db->where( DB_TABLE_USER_RESERVE.".user_ID", $user_ID );

        $this->db->order_by( DB_TABLE_USER_RESERVE.".date", "ASC" );

        return $this->db->get( DB_TABLE_USER_RESERVE );
    }

	public function update( $table, $set, $ID )
	{
		$this->db->where( "ID", $ID );

		$this->db->limit( 1 );

		return $this->db->update( $table, $set );
	}

	public function update_by_where( $table, $set, $where )
	{
		return $this->db->update( $table, $set, $where );
	}

	public function delete( $table, $ID )
	{
		$this->db->where( "ID", $ID );

		$this->db->limit( 1 );

		return $this->db->delete( $table );
	}

	public function delete_by_where( $table, $where )
	{
		$this->db->where( $where );

		return $this->db->delete( $table );
	}

    public function delete_file( $table, $row, $file_name )
    {
        if ( strpos( $row["file"], "/".$file_name."/" ) === false ) return true;

        if ( $row["file"] == "/".$file_name."/" ) $this->db->set( "file", "" );
        else $this->db->set( "file", "REPLACE( file, '/".$file_name."/', '/' )", false );

        $this->db->where( "ID", $row["ID"] );

        $this->db->limit( 1 );

        return $this->db->update( $table );
    }

    public function delete_file_homework( $table, $row, $file_name, $type )
    {
        if ( strpos( $row["file_".$type], "/".$file_name."/" ) === false ) return true;

        if ( $row["file_".$type] == "/".$file_name."/" ) $this->db->set( "file_".$type, "" );
        else $this->db->set( "file_".$type, "REPLACE( file_".$type.", '/".$file_name."/', '/' )", false );

        $this->db->where( "ID", $row["ID"] );

        $this->db->limit( 1 );

        return $this->db->update( $table );
    }

}

?>