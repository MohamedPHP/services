<template>
    <form>
        <textarea class="form-control" name="name" rows="8" cols="80" v-model="comment"></textarea>
        <br>
        <button type="submit" @click="AddComment" class="btn btn-primary">Add Comment</button>
    </form>
    <br><br><hr>
</template>

<script>
export default {
    props: ['order'],
    data:function () {
        return {
            comment: "",
        }
    },
    methods: {
        AddComment:function (e) {
            e.preventDefault();
            var formdata = new FormData();
            formdata.append('comment', this.comment);
            formdata.append('order_id', this.order.id);
            this.$http.post('/AddComment', formdata).then(function (response) {
                swal("Good job!", "Comment added!", "success");
                this.comment = '';
            }, function (response) {
                for (var key in response.body) {
                    alertify.error(response.body[key]);
                }
            });
        }
    }
}
</script>
