<template>
    <div class="row">
        <div class="col-md-12">
            <form>
                <textarea class="form-control" name="name" rows="4" v-model="comment"></textarea>
                <br>
                <button type="submit" @click="AddComment" class="btn btn-primary">Add Comment</button>
            </form>
        </div>
    </div>
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
                alertify.success("Comment Added");
                this.comment = '';
                this.$dispatch('AddComment', response.body);
            }, function (response) {
                if (response.body == 'You Need To login.') {
                    alert(response.body);
                    window.location = '/login';
                }
                for (var key in response.body) {
                    alertify.error(response.body[key]);
                }
            });
        }
    }
}
</script>
