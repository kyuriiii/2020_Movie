<style>
    .calendar { text-align: center; }
    .calendar td { border:1px solid black;}
    .calendar td:hover { cursor:pointer; transform:scale(1.1); }
    .calendar td .saturday { color:blue; }
    .calendar td .sunday {color:red;}
    .calendar .active { background-color:black; color:white; }

    .section_reserve_step ul{ height:100%; }
    .section_reserve_step ul li { list-style-type : none; position:relative; height:50%; border:1px solid #666;background-color:#FFF;}
    .section_reserve_step ul li > a {display:block; height:100%; color:#666;}
    .section_reserve_step ul li > a > strong {display:block; line-height:1.5; padding-top:120px; font-size:13px; text-align:center;}

    .section_reserve_step ul li.active {border-color:#FF243E; border-bottom-color:#666; background-color:#FF243E;}
    .section_reserve_step ul li.active > a {color:#FFF;}
    .section_reserve_step ul li.active > a > strong {font-size:15px;}

    .reserve-title {
        border-bottom: 1px solid #dddddd;
        background-color: #444444;
        text-align: center;
        color: #dddddd;
        font-size: 13px;
        font-weight: bold;
        padding: 5px;
    }
    .reserve-container #reserve-movie-part,
    .reserve-container #reserve-theater-part,
    .reserve-container #reserve-day-part,
    .reserve-container #reserve-time-part { border: 1px solid #000; height: 600px; }
    .theater-location-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column ;
    }
    /* PLACE BOX */
    .theater-place-wrapper {
        padding-left: 2px;
        padding-right: 2px;
        margin-top: 2px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        overflow: scroll;
        overflow-x: hidden;
        height:500px;
    }
    ::-webkit-scrollbar {
        width: 10px;
        /* height: 8px; */
        border: 3px solid #ffffff;
    }

    ::-webkit-scrollbar-track {
        background: #efefef;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 4px rgba(0, 0, 0, .2);
    }

    ::-webkit-scrollbar-thumb {
        width: 50px;
        height: 50px;
        background: #444444;
        -webkit-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: inset 0 0 4px rgba(0, 0, 0, .1);
    }

    @import url('https://fonts.googleapis.com/css2?family=Lato&display=swap');

    #reserve-seat-part,
    #reserve-detail-part {
        border: 1px solid #000; height: 600px;
    }
    .detail-container {
        padding-left: 2px;
        padding-right: 2px;
        margin-top: 2px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        height:500px;
    }
    .seats {
        background-color: rgba(112, 112, 112, 0.575);
    }
    .seat {
        background-color: #444451;
        height: 15px;
        width: 18px;
        margin: 4px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .seat.selected {
        background-color: #6feaf6;
    }

    .seat.occupied {
        background-color: #fff;
    }

    .seat:nth-of-type(2) {
        margin-right: 10px;
    }

    .seat:nth-last-of-type(2) {
        margin-left: 10px;
    }

    .seat:not(.occupied):hover {
        cursor: pointer;
        transform: scale(1.2);
    }

    .showcase .seat:not(.occupied):hover {
        cursor: pointer;
        transform: scale(1);
    }

    .showcase {
        background: rgba(49, 49, 49, 0.1);
        padding: 5px 10px;
        border-radius: 5px;
        color: #777;
        list-style-type: none;
        display: flex;
        justify-content: space-between;
    }

    .showcase li {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 10px;
    }

    .showcase li small {
        margin-left: 2px;
    }

    .row {
        display: flex;
    }

    .screen {
        background-color: rgba(0, 0, 0, 0.767);
        color: rgb(255, 255, 255);
        text-align: center;
        height: 70px;
        padding: 25px;
        margin: 1px 0;
        transform: rotateX(-45deg);
        text-transform: none;
        box-shadow: 0 3px 10px rgba(43, 43, 43, 0.781);
    }
    .detail-container {
        border-style: hidden;
        border-color: rgb(119, 119, 119);
        border-radius: 20px;
        background-color: rgb(206, 206, 206);
        padding: 8px;
    }
    p {
        border-bottom-style: ridge;
        border-color: black;
    }
    p.text {
        border-bottom-style: none;
    }
    p.text span {
        color: #33b1bd;

    }

    /* 기존 */
    .reserve-title {
        border-bottom: 1px solid #dddddd;
        background-color: #444444;
        text-align: center;
        color: #dddddd;
        font-size: 13px;
        font-weight: bold;
        padding: 5px;
    }
</style>