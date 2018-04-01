/**
 * 前端模块配置
 * @author 向军 <2300071698@qq.com>
 */

// window.hdjs = Object.assign({
//     node_modules: '', base: '/node_modules/hdjs/', uploader: '', filesLists: '', hdjs: ''
// }, window.hdjs);
require.config({
    urlArgs: 'version=1.2.102',
    baseUrl: window.hdjs.base,
    paths: {
        hdjs: 'dist/static/hdjs',
        css: 'dist/static/requirejs/css.min',
        domReady: 'dist/static/requirejs/domReady',
        vue: 'dist/static/package/vue',
        scroll: 'dist/static/package/jquery-scrollTo/jquery.scrollTo.min',
        Aliplayer: 'http://g.alicdn.com/de/prismplayer/2.0.1/aliplayer-min',
        //微信JSSDK
        jweixin: 'http://res.wx.qq.com/open/js/jweixin-1.2.0',
        //百度编辑器
        ueditor: 'dist/static/package/ueditor/ueditor.all',
        //代码高亮
        prism: 'dist/static/package/prism/prism',
        //剪贴版
        ZeroClipboard: 'dist/static/package/ZeroClipboard/ZeroClipboard.min',
        //上传组件
        webuploader: 'dist/static/package/webuploader/dist/webuploader',
        md5: 'dist/static/package/md5.min',
        bootstrap: 'dist/static/package/bootstrap-3.3.7-dist/js/bootstrap.min',
        lodash: 'dist/static/package/lodash.min',
        //复选框切换
        bootstrapswitch: 'dist/static/package/bootstrap-switch/bootstrap-switch.min',
        select2: 'dist/static/package/select2/select2.min',
        bootstrapfilestyle: 'dist/static/package/bootstrap-filestyle/bootstrap-filestyle.min',
        moment: 'dist/static/package/moment.min',
        util: "dist/static/component/util",
        oss: "dist/static/component/oss",
        'jquery-mousewheel': 'dist/static/package/jquery-mousewheel/jquery.mousewheel.min',
        'spark-md5':'dist/static/package/spark-md5/spark-md5.min',
        //markdown编辑器edit.md设置
        jquery: "dist/static/package/jquery.min",
        axios: "dist/static/package/axios.min",
        marked: "dist/static/package/editor.md/lib/marked.min",
        prettify: "dist/static/package/editor.md/lib/prettify.min",
        raphael: "dist/static/package/editor.md/lib/raphael.min",
        underscore: "dist/static/package/editor.md/lib/underscore.min",
        flowchart: "dist/static/package/editor.md/lib/flowchart.min",
        jqueryflowchart: "dist/static/package/editor.md/lib/jquery.flowchart.min",
        sequenceDiagram: "dist/static/package/editor.md/lib/sequence-diagram.min",
        katex: "dist/static/package/katex.min",
        editormd: "dist/static/package/editor.md/editormd.amd",
        codemirror: "dist/static/package/codemirror.min",
        //代码高亮
        highlight: "dist/static/package/highlight/highlight.min",
        plupload: "dist/static/package/plupload/plupload.full.min"
    },
    shim: {
        plupload: {
            exports: 'plupload'
        },
        highlight: {
            deps: ["css!dist/static/package/highlight/dracula.min.css"]
        },
        editormd: {
            deps: [
                "flowchart",
                "sequenceDiagram",
                "css!dist/static/package/editor.md/css/editormd.min.css",
                "css!dist/static/package/editor.md/lib/codemirror/codemirror.min.css"
            ]
        },
        sequenceDiagram: {
            deps: [
                "raphael"
            ]
        },
        jqueryflowchart: {
            deps: ['flowchart', 'raphael']
        },
        hdjs: {
            deps: ['css!dist/static/css/hdjs.css']
        },
        bootstrap: {
            exports: '$',
            deps: [
                'jquery',
                'css!dist/static/package/bootstrap-3.3.7-dist/css/bootstrap.min.css',
                'css!dist/static/package/font-awesome-4.7.0/css/font-awesome.min.css'
            ]
        },
        select2: {
            exports: '$',
            deps: ['jquery', 'bootstrap']
        },
        bootstrapswitch: {
            exports: '$',
            deps: [
                'bootstrap',
                'css!dist/static/package/bootstrap-switch/bootstrap-switch.min.css'
            ]
        },
        webuploader: {
            deps: ['css!dist/static/package/webuploader/css/webuploader.css']
        },
        prism: {
            deps: ['css!dist/static/package/prism/prism.css']
        },
        ueditor: {
            deps: ['ZeroClipboard', 'dist/static/package/ueditor/ueditor.config']
        }
    },
    waitSeconds: 30
});
require([
    'jquery',
    'axios',
    'lodash',
    'bootstrap'
], function ($, axios, _) {
    window.$ = window.jQuery = $;
    window._ = _;
    console.info('后盾人 人人做后盾  www.houdunren.com');
    //将属性hdjs元素显示出来
    $("[hd-cloak]").show();
    $("[hd-hide]").hide();
    $("[hd-loading]").hide();
    window.axios = axios;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    var token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        //为异步请求设置CSRF令牌
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    } else {
        // console.error('CSRF token not found');
    }
})