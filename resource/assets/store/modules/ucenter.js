import hdjs from 'hdjs'
import hdcms from '../../../js/hdcms'
import link from '../../../js/link'

export default {
    namespaced: true,
    state: {
        //数据
        modules: window.modules && window.modules.head ? window.modules : {
            head: {isshow: true, "title": "会员中心", "bgimg": require('../../components/ucenter/images/mobile-center-bg.jpg'), "thumb": "", "description": "", "keyword": ""}
        },
        //个人中心扩展菜单
        menus: window.menus
    },
    getters: {},
    mutations: {
        //设置组件变量
        set: (state, component, field, value) => {
            state['modules'][component][field] = value;
        },
        //添加菜单
        addMenu(state) {
            let menu = {
                name: '',
                url: '',
                status: 1,
                icontype: 1,
                entry: 'profile',
                orderby: 0,
                css: {"icon": "fa fa-external-link", "image": "", "color": "#333333", "size": 35}
            };
            state.menus.push(menu);
        },
        //删除菜单
        removeMenu(state, pos) {
            state.menus.splice(pos, 1);
        },
        //上传图片
        upImage(state, data) {
            hdjs.image((images) => {
                state['modules'][data['component']][data['field']] = images[0];
            })
        },
        //图标选择
        font(state, item) {
            hdjs.font((icon) => {
                item.css.icon = icon
            })
        },
        //系统链接
        systemLink(state, item) {
            link.system((url) => {
                item.url = url;
            })
        },
    },
    actions: {}
}