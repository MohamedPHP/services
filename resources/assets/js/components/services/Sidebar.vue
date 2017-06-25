<template>
    <div class="sidebar">
        <div class="btn-group">
            <a class="btn btn-info" v-link="{name: 'User', params:{user_id: service.user.id, name:service.user.name}}"><i class="fa fa-user"></i> {{ service.user.name }}</a>
            <a v-link="{name: '/SendMessage', params:{user_id: service.user.id}}" class="btn btn-primary"><i class="fa fa-send"></i></a>
        </div>
    </div>
</template>

<script>
export default {
    props: ['service'],
    data: function () {
        return {

        }
    }
}
</script>

<style>
    .sidebar{
        background-color: #fefefe;
        padding: 20px 10px;
        box-shadow: 2px 2px 8px #ccc;
    }
</style>
