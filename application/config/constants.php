<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define( "SITE_IP", "118.67.132.48" );
define( "SITE_URL", "118.67.132.48" );
define( "SEARCH_TITLE", "MJU무비 > " );
define( "SEARCH_TAG", "MjuMovie,Mju,명지Movie" );

define( "DB_TABLE_USERS", "1_0_user" );
define( "DB_TABLE_USER_GENRE", "1_1_user_genre" );
define( "DB_TABLE_USER_MOVIE", "1_2_user_movie" );
define( "DB_TABLE_USER_RESERVE", "1_3_user_reserve" );
define( "DB_TABLE_USER_RESERVE_SEAT", "1_4_user_reserve_seats" );
define( "DB_TABLE_MOVIE_LOCATION", "2_0_movie_location" );
define( "DB_TABLE_MOVIE_THEATER", "2_1_movie_theater" );
define( "DB_TABLE_MOVIE", "2_2_movie" );
define( "DB_TABLE_MOVIE_ACTOR", "2_3_movie_actor" );
define( "DB_TABLE_MOVIE_REVIEW", "2_4_movie_review" );
define( "DB_TABLE_EVENT", "3_0_event" );

define( "KEY_POST_RETURN", "return" );
define( "KEY_POST_MSG", "msg" );
define( "VAL_POST_RETURN_TRUE", "true" );
define( "VAL_POST_RETURN_FALSE", "false" );

define( "TITLE_PHONE", "000-0000-0000 또는 00000000000" );
define( "TITLE_DATE", "0000-00-00" );
define( "TITLE_TIME", "00:00" );
define( "TITME_DATE_TIME", "0000-00-00 00:00" );

define( "PATTERN_PHONE", "^\d{3}-\d{3,4}-\d{4}$" );
define( "PATTERN_CONTENT_NO", "^\d{2}|\d{2}-\d{1}$" );
define( "PATTERN_TIME", "^|\d{2}:\d{2}$" );
define( "PATTERN_DATE", "^\d{4}-\d{2}-\d{2}$" );
define( "PATTERN_GUARDIAN_MSG_LATE", "^|\d+시간|\d+분|\d+시간 \d+분$" );

define( "ERRORMSG_WRONGSESSION", "RETURN_WRONGSESSION" );
define( "ERRORMSG_WRONGTOKEN", "RETURN_WRONGTOKEN" );
define( "ERRORMSG_WRONGDATA", "잘못된 형식의 데이터입니다." );
define( "ERRORMSG_UNKNOWN", "알 수 없는 오류가 발생했습니다." );
define( "ERRORMSG_NO_PERMISSION", "권한이 없습니다." );
/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
