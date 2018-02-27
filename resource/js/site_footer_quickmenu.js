/**
 |--------------------------------------------------------------------------
 | 后台底部快捷导航菜单控制
 |--------------------------------------------------------------------------
 */
define(['hdjs'], function (hdjs) {
    return {
        quickmenu: function () {
            require(['https://cdn.bootcss.com/bootstrap-contextmenu/0.3.4/bootstrap-contextmenu.min.js'], function () {
                //添加菜单
                $('a.quickMenuLink').contextmenu({
                    target: '#context-menu',
                    before: function (e, context) {
                    },
                    onItem: function (context, e) {
                        var obj = $(context);
                        var data = {
                            module: window.system.module,
                            url: obj.attr('href'),
                            title: $.trim(obj.text())
                        };
                        $.post('?m=quicknavigate&action=controller/site/post&siteid=' + window.system.siteid, data, function (json) {
                            if (json['valid'] == 1) {
                                hdjs.message('添加菜单成功,系统将刷新页面。', window.system.url, 'success', 1);
                            }
                        }, 'JSON');
                    }
                })
                //删除菜单
                $('.quick_navigate a').contextmenu({
                    target: '#context-menu-del',
                    before: function (e, context) {
                    },
                    onItem: function (context, e) {
                        var obj = $(context.context);
                        var data = {
                            url: obj.attr('href')
                        };
                        $.post('?m=quicknavigate&action=controller/site/del&siteid=' + window.system.siteid, {url: data.url}, function (json) {
                            if (json['valid'] == 1) {
                                hdjs.message('删除菜单成功,系统将刷新页面。', window.system.url, 'success', 1);
                            }
                        }, 'JSON');
                    }
                })
                //删除底部所有快捷菜单
                $('#delAllQuickMenu').click(function () {
                    if (confirm('确定删除所有快捷菜单吗?')) {
                        $.post('?m=quicknavigate&action=controller/site/delAll&siteid=' + window.system.siteid, {}, function (json) {
                            if (json['valid'] == 1) {
                                hdjs.message('菜单删除成功,系统将刷新页面。', window.system.url, 'success', 1);
                            }
                        }, 'JSON');
                    }
                })
                //删除底部快捷菜单
                $(".close_quick_menu").click(function () {
                    $.post('?m=quicknavigate&action=controller/site/status&siteid=' + window.system.siteid, {'quickmenu': 0}, function (json) {
                        hdjs.message('菜单关闭显示成功,下次要开启底部快捷菜单请在 [系统设置] 中进行开启。', 'refresh', 'success');
                    }, 'JSON');
                })
            })
        }
    }
});