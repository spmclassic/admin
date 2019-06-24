<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>平台管理</title>
    <link rel="stylesheet" href="/admin/css/font_zn.css">
    <link rel="stylesheet" href="/admin/css/reset.css">
    <link rel="stylesheet" href="/admin/css/passport.css">
    <script src="/vendor/seajs/1.3.1/sea.js" id="seajsnode"></script>
</head>

<body>
<div class="passport-wrap">
    <div class="passport-type">
        <h5 class="active" id="login">平台管理</h5>
    </div>
    <div class="passport-select-wrap active">
        <div class="passport-step active">
            <!-- 密码登录 -->
            <div class="passport-step-login active">
                <form method="post" action="{!! url('login') !!}">
                    {!! csrf_field() !!}
                    <div class="pr">
                        <input class="form-control c_control" placeholder="请输入您的手机号" name="mobile" type="text">
                        <i class="error pa">  {{ $errors->first('mobile') }}</i>
                    </div>
                    <div class="pr">
                        <input class="form-control" placeholder="请输入密码" name="password" type="password" value="">
                        <i class="error pa">  {{ $errors->first('password') }}</i>
                    </div>
                    <button class="submit">登录</button>
                </form>
            </div>
            <!-- 短信验证码登录 -->
        </div>
    </div>
</div>
<script>
    var __seajs_debug = 0;
    seajs.use("/admin/js/app.js", function (app) {
        app.context.user = {login: false};
        app.bootstrap();
    });
</script>
</body>

</html>