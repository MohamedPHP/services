<template>
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

    <nav class="nav-sidebar" v-if="sidebarsection3.length > 0">
        <ul class="nav">
            <li class="active">
                <a class="nav-link"><h4>Best selling</h4></a>
            </li>
            <br>
            <li v-for="service in sidebarsection3">
                <a class="nav-link" v-link="{name: 'ServiceDetails', params: {service_id: service.id, service_name: service.name}}">{{ service.name }} <span class="label label-default pull-right"><i class="fa fa-money"></i> {{ service.order_count }}</span></a>
            </li>
        </ul>
    </nav>

    <nav class="nav-sidebar">
        <ul class="nav">
            <li class="active">
                <a class="nav-link"><h4>Categouries</h4></a>
            </li>
            <br>
            <li v-for="cat in cats">
                <a class="nav-link" href="javascript:;" v-link="{name: '/Cat', params: {cat_id: cat.id, cat_name: cat.name}}">{{ cat.name }}</a>
            </li>
        </ul>
    </nav>
    <br>
    <nav class="nav-sidebar">
        <ul class="nav">
            <li class="active">
                <a class="nav-link"><h4>Most Viewed Services</h4></a>
            </li>
            <br>
            <li v-for="service in sidebarsection1">
                <a class="nav-link" v-link="{name: 'ServiceDetails', params: {service_id: service.id, service_name: service.name}}">{{ service.name }} <span class="label label-info pull-right"><i class="fa fa-eye"></i> {{ service.view_times }}</span></a>
            </li>
        </ul>
    </nav>

</template>

<script>
export default {
    props:['cats', 'sidebarsection1', 'sidebarsection2', 'sidebarsection3'],
    data: function () {
        return {

        }
    }
}
</script>
