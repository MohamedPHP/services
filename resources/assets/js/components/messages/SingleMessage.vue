<template>
    <div v-if="messages.length > 0">
        <div class="row">
            <div class="col-md-5">
                <input type="text" class="form-control" v-model="title" placeholder="search by the title ...">
            </div>
            <div class="col-md-7">
                <div class="btn-group">
                    <button type="button" @click="sort('')" class="btn btn-default">All Data</button>
                    <button type="button" @click="sort('created_at')" class="btn btn-info">Creation Date</button>
                    <button type="button" @click="sort('seen')" class="btn btn-success">Seen</button>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="list-group" v-for="message in messages | orderBy sortKey reverse | filterBy title in 'title'" track-by="$index">
                    <a v-link="{name: '/GetMessageById', params: {msg_id: message.id, message_title: message.title}}" class="list-group-item read">
                        <span v-if="message.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                        <span v-else class="glyphicon glyphicon-ok-circle"></span>
                        <span class="name" style="min-width: 120px;display: inline-block;" v-if="message.get_sender">
                            {{ message.get_sender.name }}
                        </span>
                        <span class="name" style="min-width: 120px;display: inline-block;" v-if="message.get_receiver">
                            {{ message.get_receiver.name }}
                        </span>
                        <span class="">{{ message.title }}</span>
                        <span class="text-muted" style="font-size: 11px;">
                            - {{ (message.content).substring(0,30) + '..' }}
                        </span>
                        <span class="badge">
                            {{ message.created_at }}
                        </span>
                        <span  v-if="message.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                        <span  v-else class="badge" style="background-color: #2ecc71">seen</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="alert alert-danger">There IS No Messages</div>
</template>

<script>
export default {
    props: ['messages'],
    data: function () {
        return {
            sortKey: '',
            reverse: 1,
            title: '',
        }
    },
    methods: {
        sort: function (sortval) {
            this.reverse = (this.sortKey == sortval) ? this.reverse * -1 : 1;
            this.sortKey = sortval;
        }
    }
}
</script>
