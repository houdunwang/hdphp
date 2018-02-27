/**
 |--------------------------------------------------------------------------
 | 会员相关组件库
 |--------------------------------------------------------------------------
 */
define(['hdjs'], function (hdjs) {
    return {
        /**
         * 登录检测
         * @returns {boolean}
         */
        isLogin: function () {
            return !!window.user.uid;
        },
        /**
         * 获取会员列表
         * @param callback
         * @param siteid
         */
        lists: function (callback, siteid) {
            var modalobj = hdjs.modal({
                content: ['?s=component/member/lists&siteid=' + window.system.siteid],
                title: '选择前台会员',
                width: 800,
                show: true,
                footer: '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>'
            });
            window._selectMemberUser = function (user) {
                if ($.isFunction(callback)) {
                    modalobj.modal('hide');
                    callback(user);
                }
            }
        },
        /**
         * 获取微信粉丝
         * @param callback
         * @param siteid
         */
        wechat: function (callback, siteid) {
            var modalobj = hdjs.modal({
                content: ['?s=component/member/wechat&siteid=' + window.system.siteid],
                title: '选择微信粉丝',
                width: 800,
                show: true,
                footer: '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>'
            });
            window._selectMemberWeChatUser = function (user) {
                if ($.isFunction(callback)) {
                    callback(user);
                    modalobj.modal('hide');
                }
            }
        }
    }
});