<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{v('site.info.name')}} - HDCMS开源免费内容管理系统</title>
    <meta http-equiv="Cache-Control" content="Public"/>
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
            'base': '{{root_url()}}/resource/hdjs/',
            'uploader': '{!! u("component/SiteUpload/uploader",["m"=>Request::get("m"),"siteid"=>siteid()]) !!}',
            'filesLists': '{!! u("component/SiteUpload/filesLists",["m"=>Request::get("m"),"siteid"=>siteid()]) !!}',
            'removeImage': '{!! u("component/SiteUpload/removeImage",["m"=>Request::get("m"),"siteid"=>siteid()]) !!}',
            'ossSign': '{!! u("component/oss/sign",["m"=>Request::get("m"),"siteid"=>siteid()]) !!}',
        };
        window.system = {
            attachment: "/attachment",
            root: "<?php echo __ROOT__?>",
            url: "<?php echo __URL__?>",
            siteid: "<?php echo siteid()?>",
            module: "<?php echo v('module.name')?>",
            //用于上传等组件使用标识当前是后台用户
            user_type: 'user'
        }
        if (navigator.appName == 'Microsoft Internet Explorer') {
            if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }
    </script>
    <script src="{{root_url()}}/resource/hdjs/dist/static/requirejs/require.js?version={{HDCMS_VERSION}}"></script>
    <script src="{{root_url()}}/resource/hdjs/dist/static/requirejs/config.js?version={{HDCMS_VERSION}}"></script>
    <link href="{{root_url()}}/resource/css/site.css?version={{HDCMS_VERSION}}" rel="stylesheet">
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
<body class="site">
<div>
    <!--后台站点父级模板-->
    <?php $LINKS = model('menu')->getMenus(); ?>
    <div class="container-fluid admin-top">
        <!--导航-->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <ul class="nav navbar-nav">
                        <if value="q('session.system.login')=='hdcms'">
                            <li>
                                <a href="?s=system/site/lists">
                                    <i class="fa fa-reply-all"></i> 返回系统
                                </a>
                            </li>
                        </if>
                        <foreach from="$LINKS['menus']" value="$m">
                            <if value="$m['mark']==Request::get('mark')">
                                <li class="top_menu active">
                                    <else/>
                                <li class="top_menu">
                            </if>
                            <a href="{{$m['url']}}&siteid={{SITEID}}&mark={{$m['mark']}}"
                               class="quickMenuLink">
                                <i class="'fa-w {{$m['icon']}}"></i> {{$m['title']}}
                            </a>
                            </li>
                        </foreach>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <if value="q('session.system.login')=='hdcms'">
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle"
                                   data-toggle="dropdown"
                                   style="display:block; max-width:150px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; "
                                   aria-expanded="false">
                                    <i class="fa fa-group"></i> {{v('site.info.name')}} <b
                                            class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="?s=system/site/edit&siteid={{SITEID}}"><i
                                                    class="fa fa-weixin fa-fw"></i>
                                            编辑当前账号资料
                                        </a>
                                    </li>
                                    <li><a href="?s=system/site/lists"><i
                                                    class="fa fa-cogs fa-fw"></i> 管理se其它公众号</a></li>
                                    <li><a href="javascript:;" onclick="updateSiteCache()"><i
                                                    class="fa fa-sitemap"></i> 更新站点缓存</a></li>
                                </ul>
                                <script>
                                    function updateSiteCache() {
                                        require(['resource/js/hdcms.js'], function (hdcms) {
                                            hdcms.updateSiteCache();
                                        })
                                    }
                                </script>
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
    <!--主体-->
    <div class="container-fluid admin_menu">
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-lg-2 left-menu">
                <div class="search-menu">
                    <input class="form-control input-lg" id="searchMenu" type="text"
                           placeholder="输入菜单名称可快速查找">
                </div>
                <script>
                    require(['hdjs', '/resource/js/site_menu.js'], function (hdjs, menu) {
                        //当前点击样式
                        menu.changeCurrentLinkStyle();
                        //菜单搜索
                        $('#searchMenu').blur(function () {
                            menu.search(this);
                        });
                    })
                    require(['hdjs', '/resource/js/site_footer_quickmenu.js'], function (hdjs, menu) {
                        //后台底部快捷导航
                        menu.quickmenu();
                    })
                </script>
                <!--扩展模块动作 start-->
                <if value="'package'==Request::get('mark') && Request::get('m')">
                    <div class="btn-group module_action_type">
                        <a class="btn {{Request::get('mt')=='default'?'btn-primary':'btn-default'}} default col-sm-4"
                           href="{!! url_del('mt') !!}&mt=default">
                            默认
                        </a>
                        <a class="btn {{Request::get('mt')=='system'?'btn-primary':'btn-default'}} system  col-sm-4"
                           href="{!! url_del('mt') !!}&mt=system">
                            系统
                        </a>
                        <a class="btn {{Request::get('mt')=='group'?'btn-primary':'btn-default'}} group  col-sm-4"
                           href="{!! url_del('mt') !!}&mt=group">
                            组合
                        </a>
                    </div>
                </if>
                <div class="panel panel-default">
                    <!--系统菜单-->
                    <if value="!in_array(Request::get('mt'),['default'])">
                        <foreach from="$LINKS['menus']" value="$m">
                            <if value="$m['mark']==Request::get('mark')">
                                <foreach from="$m['_data']" value="$d">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">{{$d['title']}}</h4>
                                        <a class="panel-collapse" data-toggle="collapse"
                                           href="javascript:;">
                                            <i class="fa fa-chevron-circle-down"></i>
                                        </a>
                                    </div>
                                    <ul class="list-group menus">
                                        <foreach from="$d['_data']" value="$g">
                                            <li class="list-group-item" id="{{$g['id']}}">
                                                <if value="$g['append_url']">
                                                    <a class="pull-right append_url"
                                                       href="{{$g['append_url']}}&siteid={{SITEID}}&mark={{$g['mark']}}&mi={{$g['id']}}">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </a>
                                                </if>
                                                <a href="{{$g['url']}}&siteid={{SITEID}}&mark={{$g['mark']}}&mi={{$g['id']}}&mt={{Request::get('mt')}}"
                                                   class="quickMenuLink">
                                                    {{$g['title']}}
                                                </a>
                                            </li>
                                        </foreach>
                                    </ul>
                                </foreach>
                            </if>
                        </foreach>
                    </if>
                    <!----------返回模块列表 start------------>
                    <if value="$LINKS['module'] && Request::get('mark')=='package' && in_array(Request::get('mt'),['default'])">
                        <div class="panel-heading">
                            <h4 class="panel-title">系统功能</h4>
                            <a class="panel-collapse" data-toggle="collapse" aria-expanded="true">
                                <i class="fa fa-chevron-circle-down"></i>
                            </a>
                        </div>
                        <ul class="list-group" aria-expanded="true" mark="package">
                            <li class="list-group-item">
                                <a href="{!! u('site.entry.home',['siteid'=>siteid(),'mark'=>'package']) !!}">
                                    <i class="fa fa-reply-all"></i> 返回模块列表
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{site_url('site.entry.module')}}&m={{$_GET['m']}}">
                                    <i class="fa fa-desktop"></i>
                                    {{$LINKS['module']['module']['title']}}
                                </a>
                            </li>
                        </ul>
                    </if>
                    <if value="Request::get('mark')=='package' && in_array(Request::get('mt'),['group','default'])">
                        <foreach from="$LINKS['module']['access']" key="$title" value="$t">
                            <if value="!empty($t) && $title!='extPermissions'">
                                <div class="panel-heading module_back module_action">
                                    <h4 class="panel-title">{{$title}}</h4>
                                    <a class="panel-collapse" data-toggle="collapse"
                                       aria-expanded="true">
                                        <i class="fa fa-chevron-circle-down"></i>
                                    </a>
                                </div>
                                <ul class="list-group " aria-expanded="true">
                                    <foreach from="$t" value="$m">
                                        <li class="list-group-item" id="{{$m['_hash']}}">
                                            <a href="{{$m['url']}}&siteid={{siteid()}}&mi={{$m['_hash']}}&mt={{Request::get('mt')}}"
                                               class="quickMenuLink">
                                                <i class="{{$m['ico']}}"></i> {{$m['title']}}
                                            </a>
                                        </li>
                                    </foreach>
                                </ul>
                            </if>
                        </foreach>
                    </if>
                    <!--模块列表-->
                    <if value="Request::get('mark')=='package' && in_array(Request::get('mt'),['group','system',''])">
                        <foreach from="$LINKS['moduleLists']" key="$t" value="$d">
                            <div class="panel-heading">
                                <h4 class="panel-title">{{$t}}</h4>
                                <a class="panel-collapse">
                                    <i class="fa fa-chevron-circle-down"></i>
                                </a>
                            </div>
                            <ul class="list-group menus">
                                <foreach from="$d" value="$g">
                                    <li class="list-group-item">
                                        <a href="{{site_url('site.entry.module')}}&m={{$g['name']}}&mt=default">
                                            {{$g['title']}}
                                        </a>
                                    </li>
                                </foreach>
                            </ul>
                        </foreach>
                    </if>
                    <!--模块列表 end-->
                </div>
            </div>
            <div class="col-xs-12 col-sm-9 col-lg-10">
                <!--有模块管理时显示的面包屑导航-->
                <if value="v('module.title') && v('module.is_system')==0">
                    <ol class="breadcrumb" style="padding:8px 0;margin-bottom:10px;">
                        <li>
                            <a href="?s=site/entry/home&mark=package">
                                <i class="fa fa-cogs"></i> 扩展模块
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{site_url('site.entry.module')}}&m={{v('module.name')}}">{{v('module.title')}}</a>
                        </li>
                        <if value="$module_action_name">
                            <li class="active">
                                {{$module_action_name}}
                            </li>
                        </if>
                    </ol>
                </if>
                <div>
                    <blade name="content"/>
                    <div style="height: 100px;"></div>
                </div>
            </div>
        </div>
        <!--右键菜单添加到快捷导航-->
        <div id="context-menu">
            <ul class="dropdown-menu" role="menu">
                <li><a tabindex="-1" href="#">添加到快捷菜单</a></li>
            </ul>
        </div>
        <!--右键菜单删除快捷导航-->
        <div id="context-menu-del">
            <ul class="dropdown-menu" role="menu">
                <li><a tabindex="-1" href="#">删除菜单</a></li>
            </ul>
        </div>
        <!--底部快捷菜单导航-->
        <?php $QUICKMENU = model('menu')->getQuickMenu(); ?>
        <if value="$QUICKMENU['status']">
            <div class="quick_navigate">
                <div class="btn-group">
            <span class="btn btn-default btn-sm" id="delAllQuickMenu">
                删除所有菜单
            </span>
                    <foreach from="$QUICKMENU['system']" value="$v">
                        <a class="btn btn-default btn-sm" href="{{$v['url']}}">
                            {{$v['title']}}
                        </a>
                    </foreach>
                    <foreach from="$QUICKMENU['module']" value="$v">
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown">
                                {{$v['title']}} <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <foreach from="$v['action']" value="$a">
                                    <li><a href="{{$a['url']}}">{{$a['title']}}</a></li>
                                </foreach>
                            </ul>
                        </div>
                    </foreach>
                </div>
                <i class="fa fa-times-circle-o pull-right fa-2x close_quick_menu"></i>
            </div>
        </if>
        <if value="!empty($errors)">
            <div class="modal fade in" id="myModalMessage" role="dialog" tabindex="-1"
                 aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 600px;">
                    <div class="modal-content  alert alert-info">
                        <div class="modal-header" style="padding: 5px;">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            <h4 class="modal-title">系统提示</h4></div>
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
            <script type="application/ecmascript">
                require(['hdjs'], function () {
                    $('#myModalMessage').modal('show');
                })
            </script>
        </if>
    </div>
</div>
</body>
</html>