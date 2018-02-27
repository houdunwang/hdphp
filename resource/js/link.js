/**
 |--------------------------------------------------------------------------
 | 选择链接组件
 |--------------------------------------------------------------------------
 */
define(['hdjs'], function (hdjs) {
    return {
        /**
         * 选择系统菜单
         * @param callback
         */
        system: function (callback) {
            var modalobj = hdjs.modal({
                content: ['?m=link&action=controller/link/system&siteid=' + window.system.siteid],
                title: '请选择链接',
                width: 650,
                show: true,//直接显示
                footer: '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>'
            });
            window.selectSystemLinkComplete = function (link) {
                if ($.isFunction(callback)) {
                    callback(link);
                    modalobj.modal('hide');
                }
            }
        }
    }
});