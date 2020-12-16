<style>
    .screen{
        width: 100%;
        height: 50px;
        /*margin: 5px 32px 45px 32px;*/
        background-color: rgba(114, 114, 114, 0.767);
        color: rgb(255, 255, 255);
        text-align: center;
        padding-top: 25px;
        border-radius: 3px;
        box-shadow: 0 3px 10px rgba(221, 221, 221, 0.781);
        transform: rotateX(-45deg);
        text-transform: none;
        margin: 0 10% 5% 0;
    }
    #seat-title {
        width: 400px;
    }
    #seat-map {
        background-color: rgb(0, 0, 0);
    }
    #reserve-seat-part,
    #reserve-detail-part {
        float: left;
    }
    .reserve-title {
        border-bottom: 1px solid #dddddd;
        background-color: #444444;
        text-align: center;
        color: #dddddd;
        font-size: 13px;
        font-weight: bold;
        padding: 5px;
    }
    #age {
        width: 30px;
        height: 30px;
        border-radius: 14px;
        background-color: #f1c064;
    }
    .booking-details {
        padding-left: 12px;
        float: left;
        position: absolute;
        height: 400px;
    }
    .booking-details h3 {
        margin: 5px 5px 0 0;
        font-size: 16px;
    }
    .booking-details p{
        line-height:26px;
        font-size:16px;
        color:rgb(22, 22, 22)
    }
    .booking-details p span{
        color:rgb(22, 22, 22)
    }
    div.seatCharts-cell {
        color: #182C4E;
        height: 25px;
        width: 25px;
        line-height: 25px;
        margin: 3px;
        float: left;
        text-align: center;
        outline: none;
        font-size: 13px;
    }
    div.seatCharts-seat {
        color: #fff;
        cursor: pointer;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        margin: 4px;
        height: 23px;
    }
    div.seatCharts-row {
        height: 35px;
    }
    div.seatCharts-seat.available {
        background-color: rgba(158, 158, 158, 0.651);
    }
    div.seatCharts-seat.focused {
        background-color: #5bc9d3;
        border: none;
    }
    div.seatCharts-seat.selected {
        background-color: #5bc9d3;
    }
    div.seatCharts-seat.unavailable {
        background-color: #444451;
        cursor: not-allowed;
    }
    div.seatCharts-container {
        border-right: 1px #000000;
        width: 400px;
        position: absolute;
        padding: 10px;
        float: left;
    }
    div.seatCharts-legend {
        padding-left: 0px;
        position: absolute;
        bottom: 0;
        font-size: small;
    }
    ul {
        list-style-type: none;
    }
    ul.seatCharts-legendList {
        padding-left: 0px;
    }

    .seatCharts-legendItem{
        float:left;
        width:100px;
        margin-top: 10px;
        line-height: 2px;

    }
    span.seatCharts-legendDescription {
        margin-left: 5px;
        line-height: 20px;
    }

    .button{
        width:140px;
        height:50px;
        border:2px solid hsl(245, 53%, 17%);
        float:left;
        text-align:center;
        cursor:pointer;
        position:relative;
        box-sizing:border-box;
        overflow:hidden;
        margin:0 0 35px 35px;
    }
    .button a{
        font-family:arial;
        font-size:16px;
        color:#fff;
        text-decoration:none;
        line-height:50px;
        transition:all .5s ease;
        z-index:2;
        position:relative;
    }
    .effect{
        width:140px;
        height:50px;
        border:70px solid hsl(245, 53%, 17%);
        position:absolute;
        transition:all .5s ease;
        z-index:1;
        box-sizing:border-box;
    }
    .button:hover .effect{
        border:0px solid hsl(245, 53%, 17%);
    }
    .button:hover a{
        color:hsl(245, 53%, 17%);
    }
    #selected-seats {max-height: 150px;overflow-y: auto;overflow-x: none;width: 200px;}
    #selected-seats li{float:left; width:72px; height:26px; line-height:26px; border:1px solid #d3d3d3; background:#f7f7f7; margin:6px; font-size:14px; font-weight:bold; text-align:center}
</style>