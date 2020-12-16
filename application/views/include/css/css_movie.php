<? if ( ! defined('BASEPATH') ) exit('No direct script access allowed'); ?>

<style>
    :root {
        --primary: #141414;
        --light: #F3F3F3;
        --dark: 	#686868;
      }
    a,span,li,p,div,h1,fieldset,legend,pre{ font-family: 'LotteMartDream', sans-serif; }

    .lotte_font { font-family: 'LotteMartDream', sans-serif; }
    @font-face {
        font-family: 'LotteMartDream';
        font-style: normal;
        font-weight: 400;
        src: url('//cdn.jsdelivr.net/korean-webfonts/1/corps/lottemart/LotteMartDream/LotteMartDreamMedium.woff2') format('woff2'), url('//cdn.jsdelivr.net/korean-webfonts/1/corps/lottemart/LotteMartDream/LotteMartDreamMedium.woff') format('woff');
    }

    /* vh = 스크롤바 포함 */
    html, body {
        width: 100%;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        background-color: var(--primary);
        color: var(--light);
        box-sizing: border-box;
        line-height: 1.4;
        font-family: 'LotteMartDream', sans-serif;
    }
    img { max-width: 100%; }
    h1 { padding-top: 60px; }

    fieldset{
        border: 1px solid var(--light);
        border-top
    }

    .wrapper { margin: 0; padding: 0; }

    /* HEADER */
    header {
    padding: 20px 20px 0 20px;
    position: fixed;
    top: 0;
    display: grid;
    grid-gap:5px;
    grid-template-columns: 1fr 4fr 1fr;
    grid-template-areas:
     "nt mn mn sb . . . ";
    background-color: var(--primary);
    width: 100%;
    margin-bottom: 0px;
    }

    .MovieLogo {
    grid-area: nt;
    object-fit: cover;
    width: 100px;
    max-height: 100%;
    padding-left: 30px;
    padding-top: 0px;
    }

    .MovieLogo img { height: 35px; }

    #logo { color: #E50914; margin: 0; padding: 0; }

    .main-nav { color: var(--light); padding-right:10px; margin: 5px; }
    .main-nav:hover { color: var(--dark); }

    .find-span{ color: var(--dark); padding-right:10px;  margin: 5px; }
    .find-span:hover { color: #212738; }

    .hover:hover { cursor: pointer; transform: scale(1.2); }

    .sub-nav { grid-area: sb; padding: 0 40px 0 40px; }
    .sub-nav a { color: var(--light); text-decoration: none; margin: 5px; }
    .sub-nav a:hover {  color: var(--dark);}

    .bg-black { background-color: var(--primary); }
    /* 왼쪽 사이드 메뉴 */
    .slider-container { padding-top: 50px; display:flex; width:100%; }

    aside#left ul li:hover { cursor:pointer; transform:scale(1.2); }
    aside#left { float: left; line-height: 55px; width: 10em; margin-right: 1em; text-align: center; }
    aside#left ul { list-style: none;}
    aside#left ul li { background-color: var(--primary); padding: 5px 10px; border-bottom: 1px solid var(--light); }
    aside#left ul li a{ color: var(--light); text-decoration: none; }
    aside#left ul li:hover { background-color: var(--dark); }

    .slide_bar { display:-ms-flexbox; display:flex; -ms-flex-wrap:wrap; flex-wrap:wrap; width:70%; text-align:center; padding-bottom:100px; }

    .rank_img:hover {
        cursor:pointer;
   }
    .over_box {overflow:hidden; position:absolute; width:100%; height:0;}
    .over_box .btn_col3:first-child {margin-top:0}
    .over_box .hall_info_box {position:absolute; top:0; left:0; width:100%; background:red}
    .over_box .btn_end {border-color:#666; color:#666 !important}
    .over_box {overflow:inherit; position:absolute; z-index:1; top:0; left:0; width:100%; height:100%;}
    .over_box:before {content:''; position:absolute; top:0; left:0; width:100%; height:100%; background:#000; opacity:0.7;}
    .over_box .inner {position:absolute; z-index:1; top:50%; left:0; right:0; padding:0 18px;}
    /* MAIN CONTIANER */
    .box {
    display: grid;
    grid-gap: 20px;
    grid-template-columns: repeat(6, minmax(100px, 1fr));
    }

    .box a { transition: transform .3s; }
    .box a:hover {
    transition: transform .3s;
    -ms-transform: scale(1.3);
    -webkit-transform: scale(1.3);
    transform: scale(1.3);
    }

    .box img { border-radius: 2px; }
    /*자윤*/
    #likes p {
        text-align: center;
        color: #333;
    }
    section {
        position: relative;
        padding: 30px 0 50px;
    }
    section:last-of-type {
        min-height: 20vh;
    }
    section.focus .page-header {
        color: #2e2bc9;
    }
    section.focus .page-header:after {
        visibility: visible;
        opacity: 1;
    }

    .section-header {
        position: relative;
        margin-bottom: 40px;
        /*font-weight: 400;*/
        /*color: #333;*/
        text-align: center;
        line-height: 60px;
        letter-spacing: 1px;
    }
    /*자윤*/

    #detail { padding-top: 0px; }
    .sub-container { margin-top: 60px; }
    .likes {
    border: 1px solid white;
    height: 350px;
    margin-top: 50px;
    margin-bottom: 20px;

    }
    .event {
    border: 1px solid white;
    height: 350px;
    margin-top: 50px;
    margin-bottom: 20px;
    }

    /* LINKS */
    .link { padding: 50px; }
    .logos a{ padding: 10px; }
    .logo { color: var(--dark); }

    /* FOOTER */
    footer { padding: 20px; text-align: center; color: var(--dark); margin: 10px; }

    /* MEDIA QUERIES */
    @media(max-width: 900px) {
        header {
          display: grid;
          grid-gap: 20px;
          grid-template-columns: repeat(2, 1fr);
          grid-template-areas:
          "nt nt nt  .  .  . sb . . . "
          "mn mn mn mn mn mn  mn mn mn mn";
        }
        .box {
          display: grid;
          grid-gap: 20px;
          grid-template-columns: repeat(4, minmax(100px, 1fr));
        }
    }

    @media(max-width: 700px) {
        header {
          display: grid;
          grid-gap: 20px;
          grid-template-columns: repeat(2, 1fr);
          grid-template-areas:
          "nt nt nt  .  .  . sb . . . "
          "mn mn mn mn mn mn  mn mn mn mn";
         }
        .box {
          display: grid;
          grid-gap: 20px;
          grid-template-columns: repeat(3, minmax(100px, 1fr));
        }
    }

    @media(max-width: 500px) {
        .wrapper {
          font-size: 15px;
        }
        header {
          margin: 0;
          padding: 20px 0 0 0;
          position: static;
          display: grid;
          grid-gap: 20px;
          grid-template-columns: repeat(1, 1fr);
          grid-template-areas:
          "nt"
          "mn"
          "sb";
          text-align: center;
        }
        .MovieLogo {
          max-width: 100%;
          margin: auto;
          padding-right: 20px;
        }
        .main-nav {
          display: grid;
          grid-gap: 0px;
          grid-template-columns: repeat(1, 1fr);
          text-align: center;
        }
        h1 {
          text-align: center;
          font-size: 18px;
        }
        #detail { padding-top: 0px; }
        .box {
          display: grid;
          grid-gap: 20px;
          grid-template-columns: repeat(1, 1fr);
          text-align: center;
        }
        .box a:hover {
          transition: transform .3s;
          -ms-transform: scale(1);
          -webkit-transform: scale(1);
          transform: scale(1.2);
        }
        .logos {
          display: grid;
          grid-gap: 20px;
          grid-template-columns: repeat(2, 1fr);
          text-align: center;
        }
    }

    /*귤귤이*/
    #product-back{ display:none; transform: rotateY( 180deg ); }
    .animate #product-back,  .animate #product-front{ top:0px; left:0px; -webkit-transition: all 100ms ease-out;
        -moz-transition: all 100ms ease-out; -o-transition: all 100ms ease-out; transition: all 100ms ease-out; }
    .animate{ box-shadow:0px 13px 21px -5px rgba(0, 0, 0, 0.3); -webkit-transition:  100ms ease-out;
        -moz-transition:  100ms ease-out; -o-transition:  100ms ease-out; transition:  100ms ease-out;
    }
    .image_overlay{ justify-content: center; position:absolute; margin:auto; top:0; left:30%; width:40%; height:100%; background:black; opacity:0; }
    .animate .image_overlay{ opacity:0.7; -webkit-transition: all 200ms ease-out; -moz-transition: all 200ms ease-out; -o-transition: all 200ms ease-out; transition: all 200ms ease-out;}

    .image_overlay-genre{
        justify-content: center;
        position:absolute;
        margin:auto;
        top:0;
        left:0;
        width:90%;
        height:100%;
        background:black;
        opacity:0;
    }
    .animate .image_overlay-genre{
        opacity:0.7;
        -webkit-transition: all 200ms ease-out;
        -moz-transition: all 200ms ease-out;
        -o-transition: all 200ms ease-out;
        transition: all 200ms ease-out;
    }
    .over_view{
        position:absolute;
        left:55%;
        margin-left:-85px;
        border:2px solid #fff;
        color:#fff;
        font-size:14px;
        text-align:center;
        text-transform:uppercase;
        font-weight:500;
        padding:10px 0;
        width:10px;
        opacity:0;
        -webkit-transition: all 200ms ease-out;
        -moz-transition: all 200ms ease-out;
        -o-transition: all 200ms ease-out;
        transition: all 200ms ease-out;
    }
    .over_view:hover{
        background:#fff;
        color:black;
        cursor:pointer;
    }
    .animate .over_view{
        opacity:1;
        width:120px;
        font-size:13px;
        margin-left:-90px;
        -webkit-transition: all 200ms ease-out;
        -moz-transition: all 200ms ease-out;
        -o-transition: all 200ms ease-out;
        transition: all 200ms ease-out;
    }
    .view_detail{
        top:95px;
    }
    .view_reservation{
        top:190px;
    }
</style>