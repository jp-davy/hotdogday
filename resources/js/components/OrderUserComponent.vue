<template id="order-user-template">
    <div class="row align-items-center">
        
        <div class="col-12 form">
            <div class="form-inline align-items-center">
                <label for="name" class="mr-3 card-title lead" style="">Family Last Name</label>
                <input type="text" name="name" v-model="user.name" class="form-control form-control-lg w-auto" placeholder="Family Last Name...">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
        model: {
            prop: 'user',
            event: 'input'
        },

        template : '#order-user-template',

        data : function(){
            return {
                user: window.user
            }
        },

        created: function () {
            // _.debounce is a function provided by lodash to limit how
            // often a particularly expensive operation can be run.
            // In this case, we want to limit how often we access
            // yesno.wtf/api, waiting until the user has completely
            // finished typing before making the ajax request. To learn
            // more about the _.debounce function (and its cousin
            // _.throttle), visit: https://lodash.com/docs#debounce
            this.debouncedUpdateUser = _.debounce(this.updateUser, 500)
        },

        watch: {
            'user.name': function() {
                this.debouncedUpdateUser();
            },
        },
        methods: {
            updateUser() {
                    
                var user = this.user;
                
                var updateUser = new Promise((resolve, reject) => {
                        axios.put('/users/' + user.uuid, 
                            {
                                name: user.name,
                            })
                            .then(response => {
                                window.user = response.data.user;
                                resolve(response.data);
                            })
                            .catch(error => {
                                console.log(error.response.data);
                                reject(error.response.data);
                            });
                    });
            },
        },
        mounted() {
            
        }
    }
</script>
