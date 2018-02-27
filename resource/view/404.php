<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Not Found</title>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css"
          rel="stylesheet">
    <script src="http://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.js"></script>
</head>
<body>
<div class="box">
    <h1>抱歉，我们没有找到您查找的网页</h1>
    <a href="{!! __ROOT__ !!}" class="paybtn">返回首页</a>
</div>
<style>
    body {
        background: #F5F5F5 !important;
    }

    .box {
        width: 1180px;
        border: 1px solid #E4E4E4;
        background: white;
        margin: 100px auto 0px;
        padding: 30px;
        box-sizing: border-box;
        overflow: hidden;
        position: relative;
        text-align: center;
    }

    .box h1 {
        font-size: 30px;
    }

    .box .paybtn {
        width: 150px;
        height: 50px;
        font-size: 18px;
        line-height: 50px;
        text-align: center;
        color: white;
        background: #ff8530;
        border-radius: 2px;
        clear: both;
        margin-right: 20px;
        display: inline-block;
        margin-top: 30px;
        text-decoration: none;
    }
</style>
</body>
</html>