<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>HDCMS - 免费开源多站点管理系统</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css?version={{HDCMS_VERSION}}"
          rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css?version={{HDCMS_VERSION}}"
          rel="stylesheet">
    <link rel="stylesheet" href="/resource/css/hdcms.css?version={{HDCMS_VERSION}}">
    <link rel="stylesheet" href="/resource/hdjs/dist/static/css/hdjs.css?version={{HDCMS_VERSION}}">
    <script>
        //HDJS组件需要的配置
        window.hdjs = {
            'base': '{{root_url()}}/resource/hdjs',
            'uploader': '{!! u("component/SystemUpload/uploader") !!}',
            'filesLists': '{!! u("component/SystemUpload/filesLists") !!}',
            'removeImage': '{!! u("component/SystemUpload/removeImage") !!}',
            'ossSign': '{!! u("component/oss/sign") !!}',
        };
        window.system = {
            attachment: "/attachment",
            root: "<?php echo __ROOT__;?>",
            url: "<?php echo __URL__;?>",
            siteid: "<?php echo siteid();?>",
            module: "<?php echo v('module.name');?>",
            //用于上传等组件使用标识当前是后台用户
            user_type: 'user',
            uid: <?php echo v('user.info.uid') ?: 0;?>,
        }
        if (navigator.appName == 'Microsoft Internet Explorer') {
            if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }
    </script>
    <script src="{{root_url()}}/resource/hdjs/dist/static/requirejs/require.js?version={{HDCMS_VERSION}}"></script>
    <script src="{{root_url()}}/resource/hdjs/dist/static/requirejs/config.js?version={{HDCMS_VERSION}}"></script>
    <link href="{{root_url()}}/resource/css/system.css?version={{HDCMS_VERSION}}" rel="stylesheet">
    <script>
        require(['hdjs'], function () {
            //为异步请求设置CSRF令牌
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
    </script>
</head>
<body class="system">
<div>
    <div class="container-fluid admin-top">
        <!--导航-->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <ul class="nav navbar-nav">
                        <if value="q('session.system.login')=='hdcms'">
                            <li>
                                <a href="?s=system/manage/menu"><i class="fa fa-w fa-cogs"></i> 系统管理</a>
                            </li>
                        </if>
                        <if value="v('site')">
                            <li>
                                <a href="?s=site/entry/home&siteid={{SITEID}}" target="_blank">
                                    <i class="fa fa-share"></i> 继续管理公众号 ({{v('site.info.name')}})
                                </a>
                            </li>
                        </if>
                        <li>
                            <a href="http://doc.hdcms.com" target="_blank">
                                <i class="fa fa-w fa-file-code-o"></i> 在线文档
                            </a>
                        </li>
                        <li>
                            <a href="http://bbs.houdunwang.com" target="_blank"><i
                                        class="fa fa-w fa-forumbee"></i> 论坛讨论</a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <if value="v('site') && q('session.system.login')=='hdcms'">
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle"
                                   data-toggle="dropdown"
                                   style="display:block; max-width:150px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; "
                                   aria-expanded="false">
                                    <i class="fa fa-group"></i> {{v('site.info.name')}} <b
                                            class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="?s=system/site/edit&siteid={{SITEID}}"><i
                                                    class="fa fa-weixin fa-fw"></i>
                                            编辑当前账号资料</a></li>
                                    <li><a href="?s=system/site/lists"><i
                                                    class="fa fa-cogs fa-fw"></i> 管理其它公众号</a></li>
                                </ul>
                            </li>
                        </if>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                               role="button">
                                <i class="fa fa-w fa-user"></i>
                                {{v('user.info.username')}}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="?s=system/user/info">我的帐号</a></li>
                                <if value="q('session.system.login')=='hdcms'">
                                    <li role="separator" class="divider"></li>
                                    <li><a href="?s=system/manage/menu">系统选项</a></li>
                                </if>
                                <li role="separator" class="divider"></li>
                                <li><a href="?s=system/entry/quit">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--导航end-->
    </div>
    <div class="container-fluid  system-container">
        <div class="container-fluid" style="margin-top: 30px;margin-bottom: 20px;">
            <div class="col-md-6"
                 style="background: url('resource/images/logo.png') no-repeat;background-size: contain;height: 60px;opacity: .9;"></div>
            <div class="col-md-6">
                <ul class="nav nav-pills pull-right">
                    <if value="q('session.system.login')=='hdcms'">
                        <li>
                            <a href="?s=system/site/lists" class="tile ">
                                <i class="fa fa-sitemap fa-2x"></i>网站管理
                            </a>
                        </li>
                        <li>
                            <a href="?s=system/manage/menu" class="tile ">
                                <i class="fa fa-support fa-2x"></i>系统设置
                            </a>
                        </li>
                    </if>
                    <li>
                        <a href="?s=system/entry/quit" class="tile">
                            <i class="fa fa-sign-out fa-2x"></i>退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="well clearfix">
            <blade name="content"/>
        </div>
        <div class="text-muted footer">
            <a href="http://www.houdunwang.com">高端培训</a>
            <a href="http://www.hdphp.com">开源框架</a>
            <a href="http://bbs.houdunwang.com">后盾论坛</a>
            <br/>
            <?php $cloud = Db::table('cloud')->first() ?>
            Powered by hdcms {{$cloud['version']}} Build: {{$cloud['build']}} © 2014-2019
            www.hdcms.com
            runtime: {{round(microtime(true)-RUNTIME,2)}}
        </div>
        <div class="hdcms-upgrade">
            <a href="{!! u('system/cloud/upgrade') !!}"><span class="label label-danger">亲:) 有新版本了,快更新吧</span></a>
        </div>
    </div>
    <if value="!empty($errors)">
        <div class="modal fade in" id="myModalMessage" role="dialog" tabindex="-1"
             aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 600px;">
                <div class="modal-content  alert alert-info">
                    <div class="modal-header" style="padding: 5px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">温馨提示</h4></div>
                    <div class="modal-body">
                        <i class="pull-left fa fa-4x fa-info-circle"></i>
                        <div class="pull-left">
                            <foreach from="$errors" value="$v">
                                <p>{{$v}}</p>
                            </foreach>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            require(['hdjs'], function () {
                $('#myModalMessage').modal('show');
            })
        </script>
    </if>
    <if value="v('config.site.hdcms_update_notice')">
        <script>
            //检测更新
            require(['hdjs'], function (hdjs) {
                $.get('{!! u("cloud/getUpgradeVersion") !!}', function (res) {
                    if (res.valid == 1) {
                        //有新版本
                        $(".hdcms-upgrade").show();
                    }
                }, 'json')
            })
        </script>
    </if>
</div>
</body>
</html>
