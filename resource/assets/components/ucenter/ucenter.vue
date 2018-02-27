<template>
    <form class="form-horizontal" @submit.prevent="submit()">
        <div class="ucenter">
            <div class="mobile-header text-center">
                <img src="./images/mobile_head_t.png">
            </div>
            <div class="uc-container">
                <textarea name="modules" hidden v-html="$store.state.ucenter.modules"></textarea>
                <textarea name="menus" hidden v-html="$store.state.ucenter.menus"></textarea>
                <textarea name="html" hidden v-html="html"></textarea>
                <div class="header" :style="{backgroundImage:'url('+field.bgimg+')'}">
                    <div class="col-xs-3 ico">
                        <img src="./images/user.jpg">
                    </div>
                    <div class="col-xs-7 user"><h2 class="col-xs-12">后盾人向军老师</h2>
                        <div class="col-xs-6">普通会员</div>
                        <div class="col-xs-6">100积分</div>
                    </div>
                    <div class="col-xs-2">
                        <a href="javascript:;" class="pull-right">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="pay clearfix">
                    <div class="col-xs-3"><a href="aaa"> <i class="fa fa-credit-card"></i> <span>折扣券</span> </a></div>
                    <div class="col-xs-3"><a href="aaa"> <i class="fa fa-diamond"></i> <span>代金券</span> </a></div>
                    <div class="col-xs-3"><a href="aaa"> <i class="fa fa-flag-o"></i> <span>积分</span> </a></div>
                    <div class="col-xs-3"><a href="aaa"> <i class="fa fa-money"></i> <span>余额</span> </a></div>
                </div>
                <div class="list-group">
                    <a href="aaa" class="list-group-item"><i class="fa fa-suitcase"></i> 余额充值 <i class="fa fa-angle-right pull-right"></i></a>
                    <a href="aaa" class="list-group-item"><i class="fa fa-pie-chart"></i> 我的折扣券 <i class="fa fa-angle-right pull-right"></i></a>
                    <a href="aaa" class="list-group-item"><i class="fa fa-gift"></i> 我的代金券 <i class="fa fa-angle-right pull-right"></i></a>
                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item"><i class="fa fa-mobile-phone"></i> 修改手机号 <i class="fa fa-angle-right pull-right"></i></a>
                    <a href="#" class="list-group-item"><i class="fa fa-external-link"></i> 退出系统 <i class="fa fa-angle-right pull-right"></i></a>
                    <a href="#" class="list-group-item"><i class="fa fa-film"></i> 地址管理 <i class="fa fa-angle-right pull-right"></i></a>
                </div>
                <!--快捷导航-->
                <div id="components">
                    <hd-menu></hd-menu>
                </div>
                <div v-if="field.isshow" class="editor panel panel-default clearfix">
                    <div class="panel-body">
                        <div class="arrow-left"></div>
                        <div>
                            <div class="ucheader">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label star">页面名称</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" v-model="field.title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">背景图片</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" v-model="field.bgimg">
                                        <button class="btn btn-default" @click="upImage({component:'head',field:'bgimg'})" type="button">选择图片</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label star">触发关键字</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" v-model="field.keyword">
                                        <span class="help-block keyword-error"></span>
                                        <span class="help-block">用户触发关键字，系统回复此页面的图文链接</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label star">封面</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" v-model="field.thumb">
                                        <button class="btn btn-default" @click="upImage({component:'head',field:'thumb'})" type="button">选择图片</button>
                                        <div class="input-group" style="margin-top:5px;" v-show="field.thumb">
                                            <img class="img-responsive img-thumbnail" width="150" :src="field.thumb">
                                            <em class="close" @click="field.thumb=''" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片">×</em>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label star">页面描述</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" v-model="field.description">
                                    </div>
                                </div>
                                <div class="page-header"> 个人中心扩展菜单</div>
                                <div class="col-sm-12 ext-menus" v-for="(v,k) in menus">
                                    <div class="del-menu">
                                        <i class="fa fa-times-circle delete-ico" @click="removeMenu(k)"></i>
                                    </div>
                                    <div class="alert">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">标题</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" v-model="v.name">
                                                    <span class="input-group-btn">
                                                <input type="hidden" v-model="v.css.icon">
                                                <button class="btn btn-default" type="button" @click="font(v)">选择图标</button>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">链接</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" v-model="v.url">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                            选择链接 <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li><a href="javascript:;" @click="systemLink(v)">系统菜单</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="add_item col-sm-12" @click="addMenu()">
                                    <i class="fa fa-plus"></i> 添加导航
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">保存数据</button>
        </div>
    </form>
</template>
<script>
    import hdMenu from './menu.vue'
    import hdcms from '../../../js/hdcms'
    import {mapMutations} from 'vuex'
    import hdjs from 'hdjs'

    export default {
        components: {
            hdMenu
        },
        computed: {
            field() {
                return this.$store.state.ucenter.modules.head;
            },
            menus() {
                return this.$store.state.ucenter.menus;
            }
        },
        mounted() {
            $('.ucenter a').attr('onclick', 'return false');
            this.format();
        },
        updated() {
            this.format();
        },
        data() {
            return {
                //删除元素后的html
                html: ''
            }
        },
        methods: {
            ...mapMutations('ucenter', [
                'set', 'addMenu','removeMenu', 'upImage', 'font', 'systemLink'
            ]),
            submit() {
                hdjs.submit();
            },
            //去除vue相关数据用于会员中心展示
            format() {
                this.html = $("#components").html();
            }
        }
    }
</script>
<style scoped lang="less">
    .ucenter {
        border: solid 1px #dddddd;
        border-radius: 10px;
        width: 350px;
        height: auto;
        overflow: hidden;
        margin-right: 15px;
        padding: 10px;
        background: #fff;
        .mobile-header {
            margin: 10px 0px 10px;
        }
        .uc-container {
            /*border: solid 1px #dddddd;*/
        }
        .header {
            position: relative;
            height: 110px;
            background-size: 100%;
            color: #ffffff;
            overflow: hidden;
            div.ico {
                img {
                    border-radius: 50%;
                    width: 65px;
                    height: 65px;
                    border: solid 2px #ffffff;
                    margin-top: 30px;
                }
            }
            div.user {
                padding-top: 20px;
                text-align: left;
                font-size: 12px;
                a {
                    color: #ffffff;
                }
                h2 {
                    font-size: 16px;
                }
                div {
                    padding-right: 0px;
                }
            }
            .setting {
                color: #ffffff;
                margin-top: 50px;
                font-size: 22px;
            }
        }

        .pay {
            padding: 10px 0px;
            border: solid 1px #dddddd;
            margin-bottom: 10px;
            div {
                text-align: center;
                font-size: 12px;
                a {
                    color: #666;
                    i {
                        font-size: 22px;
                        display: block;
                        color: #aaaaaa;
                        margin-bottom: 6px;
                    }
                }
            }
        }

        .editor {
            position: absolute;
            left: 380px;
            top: 120px;
            right: 20px;
            margin-bottom: 150px;
            .add_item {
                height: 45px;
                line-height: 45px;
                padding: 0 13px;
                border: 1px dashed #cccccc;
                background: #ffffff;
                font-size: 13px;
                cursor: pointer;
                text-align: center;
            }
            .ext-menus {
                position: relative;
                border: solid 1px #dddddd;
                background: #ffffff;
                padding: 0px;
                margin-bottom: 10px;
                .del-menu {
                    position: absolute;
                    right: -5px;
                    top: -15px;
                    font-size: 20px;
                    opacity: .5;
                    cursor: pointer;
                    /*display: none;*/
                }
                .alert {
                    background: #f8f8f8;
                    margin: 10px;
                }
            }
        }
    }
</style>