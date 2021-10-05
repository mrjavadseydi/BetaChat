<!DOCTYPE html>
<html lang="fa">
<head>
    <title>ورود</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('loginAsset/images/icons/favicon.ico')}}"/>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v27.0.0/dist/font-face.css" rel="stylesheet">
    <!--===============================================================================================-->
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);
        @import url('https://fonts.googleapis.com/css?family=Varela+Round');
        :root {
            --main-bg-color:gray;
        }
        .login-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;

        }
        .form .btn {
            background: var(--main-bg-color) none repeat scroll 0 0;
            border: medium none;
            border-radius: 30px;
            color: #fff;
            cursor: pointer;
            display: block;
            font-size: 23px;
            margin: 10px auto 0;
            padding: 8px 10px;
            text-align: center;
            min-width: 120px;
        }
        img{
            width:160px;
            margin-bottom:25px;
        }
        .form {
            position: relative;
            z-index: 1;
            background-color:#304aca;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            border-radius:30px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        .form input {
            font-family: 'Varela Round', sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            border-radius: 30px;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
            direction:rtl;
        }
        .form button {
            font-family: 'Varela Round', sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
        }

        .form .message {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 12px;
        }
        .form .message a {
            color: var(--main-bg-color);
            text-decoration: none;
        }
        .form .status{
            color:var(--main-bg-color);
            font-weight: 600;
        }
        .form .register-form {
            display: none;
        }
        .container {
            position: relative;
            z-index: 1;
            max-width: 300px;
            margin: 0 auto;
        }
        .container:before, .container:after {
            content: "";
            display: block;
            clear: both;
        }
        .container .info {
            margin: 50px auto;
            text-align: center;
        }
        .container .info h1 {
            margin: 0 0 15px;
            padding: 0;
            font-size: 36px;
            font-weight: 300;
            color: #1a1a1a;
        }
        .container .info span {
            color: #4d4d4d;
            font-size: 12px;
        }
        .container .info span a {
            color: #000000;
            text-decoration: none;
        }
        .container .info span .fa {
            color: var(--main-bg-color);
        }
        body {
            background: #f2f2f2; /* fallback for old browsers */
            font-family: 'Varela Round', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .cont {
            position: relative;
            height: 100%;
            background-image: url('{{asset('loginAsset/images/bg.jpg')}}');
            background-size: cover;
            overflow: auto;
        }
        *{
            font-family: Vazir!important;
        }
    </style>
</head>
<body class="cont" >
<div class="login-page">
    <div class="form">
        <form class="login-form" method="post" action="{{route('login')}}">
            @csrf
            <img src="{{asset('loginAsset/images/logo.png')}}" />
            <br>
            <input type="text" name="email" required placeholder="کد ملی"/>
            <input type="password" name="password" required placeholder="کلمه عبور"/>
            <button class="btn" type='submit'>ورود</button>
        </form>
    </div>
</div>

@include('sweetalert::alert')
</body>
</html>
