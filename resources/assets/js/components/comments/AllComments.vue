<template>

    <add_comments :order="order"></add_comments>

<hr>
<h4 v-if="comments.length > 0">Sort</h4>
    <div class="row" v-if="comments.length > 0">
        <div class="col-md-5">
            <input type="text" class="form-control" v-model="user_search" placeholder="search by the commment maker name ...">
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" @click="sort('id')" class="btn btn-success btn-block">All Comments</button>
                </div>
                <div class="col-md-6">
                    <button type="button" @click="sort('created_at')" class="btn btn-primary btn-block">Creation Date</button>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
<br>
    <div class="row" v-if="comments.length > 0">
        <div class="col-md-12">
            <h3>Comments ({{ comments.length }})</h3>
            <hr>
            <article class="row" v-for="comment in comments | orderBy sortKey reverse | filterBy user_search in 'user.name'" track-by="$index">
                <div class="col-md-2 col-sm-2 hidden-xs">
                    <figure class="thumbnail">
                        <img class="img-responsive" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
                    </figure>
                </div>
                <div class="col-md-10 col-sm-10">
                    <div class="panel panel-default arrow left">
                        <div class="panel-body">
                            <header class="text-left">
                                <div class="comment-user"><i class="fa fa-user"></i> <a  v-link="{name: 'User', params:{user_id: comment.user.id, name:comment.user.name}}">{{ comment.user.name }}</a></div>
                                <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> {{ comment.created_at }}</time>
                            </header>
                            <div class="comment-post">
                                <p>
                                    {{ comment.comment }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <div class="row" v-else>
        <div class="col-md-12">
            <div class="alert alert-danger">
                There is no comments to this order
            </div>
        </div>
    </div>
</template>

<script>
import AddComments from './../comments/AddComments.vue';
export default {
    props: ['order'],
    data:function () {
        return {
            comments: [],
            user_search: '',
            sortKey: '',
            reverse: 1,
        }
    },
    components: {
        add_comments: AddComments,
    },
    ready: function () {
        this.getAllComments();
    },
    methods: {
        getAllComments: function () {
            this.$http.get('getAllComments/' + this.order.id).then(
                function (response) {
                    this.comments = response.body;
                },
                function (response) {
                    alert('There Is An Error Please Contact Us');
                    this.$router.go({
                        path: '/',
                    });
                }
            );
        },
        sort: function (sortval) {
            this.reverse = (this.sortKey == sortval) ? this.reverse * -1 : 1;
            this.sortKey = sortval;
        }
    },
    events: {
        AddComment: function (val) {
            this.comments.unshift(val);
        },
    }
}
</script>
