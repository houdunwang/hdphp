<!--会员中心父级模板-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css?version={{HDCMS_VERSION}}" rel="stylesheet">
<link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css?version={{HDCMS_VERSION}}" rel="stylesheet">
<link rel="stylesheet" href="/resource/hdjs/dist/static/css/hdjs.css?version={{HDCMS_VERSION}}">
<link rel="stylesheet" href="/resource/css/member.css">
<script>
    //HDJS组件需要的配置
    window.hdjs = {
        'base': '/resource/hdjs',
        'uploader': '{!! u("component/upload/uploader",["m"=>Request::get("m"),"siteid"=>siteid()]) !!}',
        'filesLists': '{!! u("component/upload/filesLists",["m"=>Request::get("m"),"siteid"=>siteid()]) !!}',
        'removeImage': '{!! u("component/upload/removeImage",["m"=>Request::get("m"),"siteid"=>siteid()]) !!}',
        'ossSign': '{!! u("component/oss/sign",["m"=>Request::get("m"),"siteid"=>siteid()]) !!}',
    };
    window.system = {
        attachment: "/attachment",
        root: "<?php echo __ROOT__?>",
        url: "<?php echo __URL__?>",
        siteid: "<?php echo siteid()?>",
        module: "<?php echo v('module.name')?>",
        //用于上传等组件使用标识当前是后台用户
        user_type: 'member',
        is_wechat: '<?php echo \houdunwang\request\Request::isWeChat() ? 1 : 0;?>',
        is_mobile: '<?php echo \houdunwang\request\Request::isMobile() ? 1 : 0;?>'
    }
    window.user = {
        uid: "{{ v('member.info.uid')}}",
        nickname: "{{ v('member.info.nickname')}}",
        mobile: "{{ v('member.info.mobile')}}",
        gender: "{{ v('member.info.gender')}}",
        email_valid: "{{ v('member.info.email_valid')}}",
        mobile_valid: "{{ v('member.info.mobile_valid')}}",
    }
    if (navigator.appName == 'Microsoft Internet Explorer') {
        if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
            alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
        }
    }
</script>
<script src="/resource/hdjs/dist/static/requirejs/require.js?version={{HDCMS_VERSION}}"></script>
<script src="/resource/hdjs/dist/static/requirejs/config.js?version={{HDCMS_VERSION}}"></script>