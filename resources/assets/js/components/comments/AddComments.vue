<template>
    <textarea class="form-control" name="name" rows="8" cols="80"></textarea>
    <br>
    <button type="button" class="btn btn-primary">Add Comment</button>
    <pre>{{ service | json }}</pre>
</template>

<script>
export default {
    props: ['service'],
    data:function () {
        return {

        }
    }
}
</script>
