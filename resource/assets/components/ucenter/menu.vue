<template>
    <div class="list-group">
        <a :href="v.url" class="list-group-item" v-for="v in menus">
            <i :class="v.css.icon"></i> {{v.name}}
            <i class="fa fa-angle-right pull-right"></i>
        </a>
    </div>
</template>
<script>
    import hdjs from 'hdjs'
    import hdcms from '../../../js/hdcms'
    import {mapMutations} from 'vuex'
    import 'hdjs/dist/hdjs.css'
    export default {
        computed: {
            menus() {
                return this.$store.state.ucenter.menus;
            }
        },
        methods: {
            ...mapMutations('ucenter', [
                'set', 'addMenu'
            ]),
        },
    }
</script>
<style scoped lang="less">
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
</style>