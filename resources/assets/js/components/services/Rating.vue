<template>
    <select id="rate" v-if="user_vote != null">
        <option value="1" v-bind:selected="user_vote.vote == 1">1</option>
        <option value="2" v-bind:selected="user_vote.vote == 2">2</option>
        <option value="3" v-bind:selected="user_vote.vote == 3">3</option>
        <option value="4" v-bind:selected="user_vote.vote == 4">4</option>
        <option value="5" v-bind:selected="user_vote.vote == 5">5</option>
    </select>
    <select id="rate" v-if="user_vote == null">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</template>

<script>
export default {
    props: ['service', 'user_vote'],
    data: function () {
        return {

        }
    },
    ready: function () {
        var service_id = this.service.id;
        $('#rate').barrating({
            theme: 'fontawesome-stars',
            onSelect: function(value, text, event) {
                event.preventDefault();
                $.ajax({
                    method: 'get',
                    url: '/AddNewVote',
                    data: {
                        value: value,
                        service_id: service_id,
                    },
                    success: function (response) {
                        if (response == 'voting added') {
                            alertify.success("thanks for voting");
                        }
                        if (response == 'voting updated') {
                            alertify.success("thanks for voting update");
                        }
                        if (response == 'error') {
                            alertify.error("there is some errors");
                        }
                        if (response == 'not loged in') {
                            alertify.error("you need to log in");
                        }
                    }
                });
            }
        });
    },
    methods: {
        
    }
}
</script>

<style lang="css">
</style>
