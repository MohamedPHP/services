<template>
    <span v-if="status == 0" class="label label-default">
        Wating..
    </span>
    <span v-if="status == 1" class="label label-info">
        Seen..
    </span>
    <span v-if="status == 2" class="label label-success">
        Accepted
    </span>
    <span v-if="status == 3" class="label label-danger">
        Rejected
    </span>
    <span v-if="status == 4" class="label label-primary">
        Done
    </span>
</template>

<script>
export default {
    props: ['status'],
}
</script>

<style lang="css">
</style>
