<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-11-29 00:02:15 --> 404 Page Not Found: Modal_reserve/index
ERROR - 2020-11-29 00:14:47 --> 404 Page Not Found: Boaform/admin
ERROR - 2020-11-29 00:46:56 --> 404 Page Not Found: Config/getuser
ERROR - 2020-11-29 02:00:00 --> Query error: Unknown column '1_2_user_movie.theater_ID' in 'on clause' - Invalid query: SELECT `1_2_user_movie`.*, `1_3_user_reserve`.*, `2_1_movie_theater`.`name` AS `theater`, `2_0_movie_location`.`name` AS `location`
FROM `1_3_user_reserve`
INNER JOIN `1_2_user_movie` ON `1_3_user_reserve`.`movie_ID` = `1_2_user_movie`.`ID`
INNER JOIN `2_1_movie_theater` ON `1_2_user_movie`.`theater_ID` = `2_1_movie_theater`.`ID`
INNER JOIN `2_0_movie_location` ON `2_1_movie_theater`.`location_ID` = `2_0_movie_location`.`ID`
WHERE `1_3_user_reserve`.`user_ID` = '1'
ERROR - 2020-11-29 02:03:31 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 02:03:31 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 02:03:31 --> Severity: Notice --> Undefined index: name /var/www/application/views/movie/index.php 192
ERROR - 2020-11-29 02:05:18 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 02:05:18 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 02:13:52 --> 404 Page Not Found: Portal/redlion
ERROR - 2020-11-29 06:21:41 --> 404 Page Not Found: Actuator/health
ERROR - 2020-11-29 06:35:26 --> 404 Page Not Found: 5188210227/echo.php
ERROR - 2020-11-29 06:46:35 --> 404 Page Not Found: Config/getuser
ERROR - 2020-11-29 08:02:44 --> 404 Page Not Found: Boaform/admin
ERROR - 2020-11-29 08:47:29 --> 404 Page Not Found: Boaform/admin
ERROR - 2020-11-29 09:09:44 --> 404 Page Not Found: Boaform/admin
ERROR - 2020-11-29 12:19:29 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-11-29 12:57:01 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 12:57:01 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 12:57:22 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 12:57:22 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 12:58:48 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 12:59:23 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given /var/www/application/controllers/Mjumovie.php 63
ERROR - 2020-11-29 13:22:19 --> Severity: Notice --> Undefined index: seat /var/www/application/views/movie/index.php 203
ERROR - 2020-11-29 13:22:19 --> Severity: Notice --> Undefined index: seat /var/www/application/views/movie/index.php 203
ERROR - 2020-11-29 13:22:37 --> Severity: Warning --> Illegal string offset 'seat' /var/www/application/views/movie/index.php 203
ERROR - 2020-11-29 13:22:37 --> Severity: Warning --> Illegal string offset 'seat' /var/www/application/views/movie/index.php 203
ERROR - 2020-11-29 13:36:11 --> Severity: error --> Exception: syntax error, unexpected '$seats' (T_VARIABLE), expecting ',' or ';' /var/www/application/views/movie/index.php 203
ERROR - 2020-11-29 14:37:45 --> 404 Page Not Found: Robotstxt/index
ERROR - 2020-11-29 14:37:45 --> 404 Page Not Found: Adstxt/index
ERROR - 2020-11-29 17:01:47 --> 404 Page Not Found: Hudson/index
ERROR - 2020-11-29 17:20:09 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-11-29 17:50:54 --> 404 Page Not Found: Boaform/admin
ERROR - 2020-11-29 19:32:37 --> 404 Page Not Found: System_apiphp/index
ERROR - 2020-11-29 19:32:37 --> 404 Page Not Found: C/version.js
ERROR - 2020-11-29 19:32:38 --> 404 Page Not Found: Streaming/clients_live.php
ERROR - 2020-11-29 19:32:38 --> 404 Page Not Found: Stalker_portal/c
ERROR - 2020-11-29 19:32:39 --> 404 Page Not Found: Client_area/index
ERROR - 2020-11-29 19:32:39 --> 404 Page Not Found: Stalker_portal/c
ERROR - 2020-11-29 19:49:19 --> Severity: Notice --> Undefined variable: reserves /var/www/application/views/movie/movie_detail_v1.php 106
ERROR - 2020-11-29 19:49:19 --> Severity: error --> Exception: Call to a member function result_array() on null /var/www/application/views/movie/movie_detail_v1.php 106
ERROR - 2020-11-29 19:49:22 --> Severity: Notice --> Undefined variable: reserves /var/www/application/views/movie/movie_detail_v1.php 106
ERROR - 2020-11-29 19:49:22 --> Severity: error --> Exception: Call to a member function result_array() on null /var/www/application/views/movie/movie_detail_v1.php 106
ERROR - 2020-11-29 19:50:27 --> Severity: Notice --> Undefined variable: reserves /var/www/application/views/movie/movie_detail_v1.php 106
ERROR - 2020-11-29 19:50:27 --> Severity: error --> Exception: Call to a member function result_array() on null /var/www/application/views/movie/movie_detail_v1.php 106
ERROR - 2020-11-29 20:20:18 --> 404 Page Not Found: Boaform/admin
ERROR - 2020-11-29 20:26:27 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-11-29 20:42:49 --> 404 Page Not Found: Cgi-bin/kerbynet
ERROR - 2020-11-29 20:43:00 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-11-29 20:58:30 --> 404 Page Not Found: Boaform/admin
ERROR - 2020-11-29 21:11:24 --> 404 Page Not Found: Config/getuser
ERROR - 2020-11-29 21:12:06 --> 404 Page Not Found: Boaform/admin
ERROR - 2020-11-29 21:23:16 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-11-29 22:25:59 --> 404 Page Not Found: Boaform/admin
