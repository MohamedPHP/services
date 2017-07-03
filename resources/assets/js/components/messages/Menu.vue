<template>
    <div class="nicedivvv">
        <ul class="nav nav-pills nav-stacked">
            <li class="text-center">
                <a v-link="{name: '/Inbox'}"><i class="fa fa-inbox"></i> Inbox</a>
            </li>
            <li class="text-center">
                <a v-link="{name: '/SentMessages'}"><i class="fa fa-send"></i> Sent Messages</a>
            </li>
            <li class="text-center">
                <a v-link="{name: '/UnreadMessages'}"><i class="fa fa-eye-slash"></i> Unread Messages</a>
            </li>
            <li class="text-center">
                <a v-link="{name: '/ReadMessages'}"><i class="fa fa-eye"></i> Read Messages</a>
            </li>
        </ul>
    </div>
    <nav class="nicedivvv">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" v-if="type == 'inbox'">
                <div class="div-counter text-center">
                    <p class="counter-count">{{ (messages).length }}</p>
                    <p class="employee-p">Inbox</p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" v-if="type == 'sent'">
                <div class="div-counter text-center">
                    <p class="counter-count">{{ (messages).length }}</p>
                    <p class="employee-p">Sent Messages</p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" v-if="type == 'unread'">
                <div class="div-counter text-center">
                    <p class="counter-count">{{ (messages).length }}</p>
                    <p class="employee-p">Unread Messages</p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" v-if="type == 'read'">
                <div class="div-counter text-center">
                    <p class="counter-count">{{ (messages).length }}</p>
                    <p class="employee-p">Read Messages</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </nav>
</template>

<script>
export default {
    props: ['messages', 'type'],
    data: function () {
        return {

        }
    },
}
</script>

<style lang="css">
.nicedivvv {
    width: 100%;
    padding: 8px 0;
    box-shadow: 1px 1px 2px #ccc;
}
.btn-product{
    width: 100%;
}
@media (max-width: 767px) {
    .btn-product {
        margin-bottom: 10px;
    }
}
@media (min-width: 768px) {
    .btn-product {
        margin-bottom: 10px;
    }
}
.nicediv {
    box-shadow: 2px 2px 5px #ccc;
    padding: 5px 20px;
    margin-bottom: 30px;
}
.counter
{
    background-color: #eaecf0;
    text-align: center;
}
.div-counter
{
    margin-top: 70px;
    margin-bottom: 70px;
}
.counter-count
{
    font-size: 18px;
    background-color: #00b3e7;
    border-radius: 50%;
    position: relative;
    color: #ffffff;
    text-align: center;
    line-height: 92px;
    width: 92px;
    height: 92px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    display: inline-block;
}
.nicedivvv {
    width: 100%;
    padding: 8px 0;
    box-shadow: 1px 1px 2px #ccc;
}
.nicedivvv a {
    color: #333;
    -webkit-transition: all 0.08s linear;
    -moz-transition: all 0.08s linear;
    -o-transition: all 0.08s linear;
    transition: all 0.08s linear;
    -webkit-border-radius: 4px 0 0 4px;
    -moz-border-radius: 4px 0 0 4px;
    border-radius: 4px 0 0 4px;
}
.nicedivvv .active a {
    cursor: default;
    background-color: #428bca;
    color: #fff;
    text-shadow: 1px 1px 1px #666;
}
.nicedivvv .active a:hover {
    background-color: #428bca;
}
.nicedivvv .text-overflow a,
.nicedivvv .text-overflow .media-body {
    white-space: nowrap;
    overflow: hidden;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
}
li {
    font-size: 14px;
}
</style>
