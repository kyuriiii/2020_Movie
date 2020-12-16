<style>
    .play-button { width: 152px; height: 152px; position: relative; cursor: pointer }

    .play-backdrop { width: 100%; height: 100%; position: fixed; left: 0; top: 0; background-color: #000; opacity: 0; visibility: hidden; }

    .play-close { width: 30px; height: 30px; position: absolute; right: 0; bottom: calc(100% + 15px); border: none;
        outline: none; background: none; opacity: 0; cursor: pointer; }

    .play-close::before,
    .play-close::after { content: ""; display: block; width: 100%; height: 1px; position: absolute; top: 50%;
        left: 0; transform: rotate(45deg); background-color: #fff; }

    .play-close::after { transform: rotate(-45deg); }

    .play-circles { display: block; width: 100%;  height: 100%; }

    .play-perspective { width: 600px; height: 400px; position: absolute; left: -230px; top: -125px; }

    .play-triangle { width: 600px; height: 400px; background-color: #fff; cursor: pointer; }

    .review{
        margin-top: 2px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        overflow: scroll;
        overflow-x: hidden;
        height:500px;
    }
</style>