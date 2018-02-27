/*
 |--------------------------------------------------------------------------
 | 站点后台菜单管理
 |--------------------------------------------------------------------------
 */
define(['hdjs'], function (hdjs) {
    return {
        //修改后台点击后的左侧菜单样式
        changeCurrentLinkStyle: function () {
            $('#' + hdjs.get.get('mi')).addClass('active');
        },
        //后台菜单搜索
        search: function (elem) {
            var con = $(elem).val();
            //让所有当前菜单先隐藏
            $(".left-menu .panel-heading").addClass('hide');
            $(".left-menu .list-group").addClass('hide');
            $("a").each(function () {
                if ($.trim($(this).text()).indexOf(con) >= 0) {
                    $(this).parent().parent().removeClass('hide').prev().removeClass('hide');
                    $(this).removeClass('hide');
                }
            });
        },
    }
});