<template>
    <nav class="nav-sidebar">
        <div class="btn-group">
            <a style="color: #fff" class="btn btn-info" v-link="{name: 'User', params:{user_id: service.user.id, name:service.user.name}}"><i class="fa fa-user"></i> {{ service.user.name }}</a>
            <a style="color: #fff" v-link="{name: '/SendMessage', params:{user_id: service.user.id}}" class="btn btn-primary"><i class="fa fa-send"></i></a>
        </div>
    </nav>
    <hr>

    <nav class="nav-sidebar" v-if="sidebarsection2.length > 0">
        <ul class="nav">
            <li class="active">
                <a class="nav-link"><h4>Recommended Services</h4></a>
            </li>
            <br>
            <li v-for="service in sidebarsection2">
                <a class="nav-link" v-link="{name: 'ServiceDetails', params: {service_id: service.id, service_name: service.name}}">{{ service.name }}</a>
            </li>
        </ul>
    </nav>

    <nav class="nav-sidebar">
        <ul class="nav">
            <li class="active">
                <a class="nav-link"><h4>Most Rated Services</h4></a>
            </li>
            <br>
            <li v-for="service in most_rated_services">
                <a class="nav-link" v-link="{name: 'ServiceDetails', params: {service_id: service.id, service_name: service.name}}">{{ service.name }} <span class="label label-info pull-right"><i class="fa fa-star"></i> {{ service.vote_sum }}</span></a>
            </li>
        </ul>
    </nav>
    <nav class="nav-sidebar">
        <ul class="nav">
            <li class="active">
                <a class="nav-link"><h4>Most Viewed Services</h4></a>
            </li>
            <br>
            <li v-for="service in most_viewed_services">
                <a class="nav-link" v-link="{name: 'ServiceDetails', params: {service_id: service.id, service_name: service.name}}">{{ service.name }} <span class="label label-info pull-right"><i class="fa fa-eye"></i> {{ service.view_times }}</span></a>
            </li>
        </ul>
    </nav>

</template>

<script>
export default {
    props: ['service', 'most_rated_services', 'most_viewed_services', 'sidebarsection2'],
    data: function () {
        return {

        }
    },
}
</script>

<style>
    .nav-sidebar {
        width: 100%;
        padding: 8px 0;
        box-shadow: 1px 1px 2px #ccc;
    }
    .nav-sidebar a {
        color: #333;
        -webkit-transition: all 0.08s linear;
        -moz-transition: all 0.08s linear;
        -o-transition: all 0.08s linear;
        transition: all 0.08s linear;
        -webkit-border-radius: 4px 0 0 4px;
        -moz-border-radius: 4px 0 0 4px;
        border-radius: 4px 0 0 4px;
    }
    .nav-sidebar .active a {
        cursor: default;
        background-color: #428bca;
        color: #fff;
        text-shadow: 1px 1px 1px #666;
    }
    .nav-sidebar .active a:hover {
        background-color: #428bca;
    }
    .nav-sidebar .text-overflow a,
    .nav-sidebar .text-overflow .media-body {
        white-space: nowrap;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
    }
</style>
