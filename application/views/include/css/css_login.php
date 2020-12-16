<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }
    .wrap {
        height: 100%;
        width: 100%;
        z-index: 99;
    }
    .form-wrap {
        width: 380px;
        height: 480px;
        position: relative;
        margin: 6% auto;
        background: #fff;
        padding: 5px;
        overflow: hidden;
    }
    .button-wrap {
        width: 110px;
        margin: 25px auto;
        position: relative;
        box-shadow: 0 0 600px 9px #fcae8f;
        border-radius: 30px;
    }
    .toggleLogin {
        padding: 10px 30px;
        text-align:center;
        cursor: pointer;
        background: transparent;
        border: 0;
        outline: none;
        position: relative;
    }
    #myBtn {
        top: 0;
        left: 0;
        position: absolute;
        width: 110px;
        height: 100%;
        background: linear-gradient(to right, #ff105f, #ffad06);
        border-radius: 30px;
        transition: .5s;
    }
    .login-input-group {
        top: 130px;
        position: absolute;
        width: 280px;
        transition: .5s;
    }
    .input-field {
        width: 100%;
        padding: 10px 0;
        margin: 10px 0;
        border: none;
        border-bottom: 1px solid #999;
        outline: none;
        background: transparent;
    }
    .submit {
        width: 85%;
        padding: 10px 30px;
        cursor: pointer;
        display: block;
        margin: auto;
        margin-top:10px;
        background: linear-gradient(to right, #ff105f, #ffad06);
        border: 0;
        outline: none;
        border-radius: 30px;
    }
    .checkbox {
        margin: 30px 10px 30px 0;
    }

    #form_login {
        left: 50px;
    }
</style>