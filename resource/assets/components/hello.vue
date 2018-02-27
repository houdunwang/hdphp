<template>
    <div class="container">
        <h2 class="red">{{msg}}</h2>
    </div>
</template>
<script>
    export default {
        mounted() {
            this.show();
        },
        data() {
            return {
                msg: 'Welcome to HDCMS'
            }
        },
        methods: {
            show() {
            }
        }
    }
</script>
<style scoped lang="less">
    .container {
        border: 1px solid #00f;
        .red {
            color: yellow;
        }
    }
</style>