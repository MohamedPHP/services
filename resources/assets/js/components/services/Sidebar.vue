<template>
    <div class="btn-group">
        <a class="btn btn-info" v-link="{name: 'User', params:{user_id: service.user.id, name:service.user.name}}"><i class="fa fa-user"></i> {{ service.user.name }}</a>
        <button type="button" class="btn btn-primary"><i class="fa fa-send"></i></button>
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
