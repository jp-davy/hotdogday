<template id="student-template">
    <div>
        <hr class="mb-2 mt-2 border-primary">
        <div class="row mb-3">
            <div class="col-md-3 pb-3">

                <h3>{{ student.name }}<span class="ml-3 d-xs-inline d-sm-inline d-md-none float-right"><button class="btn btn-light btn-sm" @click="deleteStudent()"><i class="fa fa-trash text-danger"></i></button></span></h3>
                <h4>{{ (studentCost/100).toLocaleString("en-US", {style:"currency", currency:"USD"}) }}</h4>
                
                <span class="my-3 d-none d-md-inline"><button class="btn btn-light btn-sm" @click="deleteStudent()"><i class="fa fa-trash text-danger"></i></button></span>
                
                
            </div>
            <div class="col-md-9">

                <div class="row align-items-center mb-3" v-for="(hotDogDay, itemObjKey) in hotDogDays" v-bind:key="hotDogDay.id" v-bind:student="student" v-bind:class="[hotDogDays.length != itemObjKey+1 ? 'border-bottom' : '']">
                    <div class="col-md-4 font-weight-bold">
                       <h5><format :value="hotDogDay.event_date" fn="date"></format></h5>
                    </div>
                    <div class="col-md-4 form text-center">
                        <div class="form-group">
                            <label for="meals[itemObjKey]" class="">Meal <span class="small text-muted">{{ (mealPrice/100).toLocaleString("en-US", {style:"currency", currency:"USD"}) }}/ea.</span></label><br>
                            <number-control-component v-model="student.meals[itemObjKey]" :min="0" :max="25" class="form-control form-control-lg"></number-control-component>
                        </div>
                    </div>
                    <div class="col-md-4 form text-center">
                        <div class="form-group">
                            <label for="extras[itemObjKey]" class="">Extra Dog <span class="small text-muted">{{ (extraPrice/100).toLocaleString("en-US", {style:"currency", currency:"USD"}) }}/ea.</span></label><br>
                            <number-control-component v-model="student.extras[itemObjKey]" :min="0" :max="25" class="form-control form-control-lg"></number-control-component>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</template>

<script>
    export default {
        props: ['student'],

        model: {
            prop: 'student',
            event: 'input'
        },

        template : '#student-template',

        data : function(){
            return {

            }
        },

        computed: {
            mealPrice: function () { return window.meal_price; },
            extraPrice: function () { return window.extra_price; },
            daysThisMonth: function () { return window.daysThisMonth; },
            hotDogDays: function () { return window.hotDogDays; },
            studentCost: function () { 
                var totalCost = ((this.student.meal_qty * window.meal_price) + (this.student.extra_qty * window.extra_price));
                return totalCost; 
            },
        },

        created: function () {
            // _.debounce is a function provided by lodash to limit how
            // often a particularly expensive operation can be run.
            // In this case, we want to limit how often we access
            // yesno.wtf/api, waiting until the user has completely
            // finished typing before making the ajax request. To learn
            // more about the _.debounce function (and its cousin
            // _.throttle), visit: https://lodash.com/docs#debounce
            this.debouncedUpdateStudent = _.debounce(this.updateStudent, 500)
        },

        watch: {
            'student.name': function() {
                this.debouncedUpdateStudent();
            },
            'student.meals': function() {
                this.debouncedUpdateStudent();
            },
            'student.extras': function() {
                this.debouncedUpdateStudent();
            },
        },
        methods: {
            updateStudent() {
                    
                var student = this.student;
                
                var updateStudent = new Promise((resolve, reject) => {
                        axios.put('/family/' + student.user.uuid + '/students/' + student.id ,
                            {
                                name: student.name,
                                meals: student.meals,
                                extras: student.extras
                            })
                            .then(response => {
                                this.student.meal_qty = response.data.student.meal_qty;
                                this.student.extra_qty = response.data.student.extra_qty;
                                resolve(response.data);
                            })
                            .catch(error => {
                                console.log(error.response.data);
                                reject(error.response.data);
                            });
                    });
            },

            deleteStudent() {
                var student = this.student;
               
                var confirm = window.confirm("Delete this student?");
                if(confirm) {
                    var deleteStudent = new Promise((resolve, reject) => {
                        
                            axios.delete('/family/' + student.user.uuid + '/students/' + student.id)
                                .then(response => {
                                    this.$parent.students
                                        .splice(this.$parent.students.findIndex(item => item.id === student.id), 1);
                                    resolve(response.data);
                                })
                                .catch(error => {
                                    console.log(error.response.data);
                                    reject(error.response.data);
                                });
                        });
                }
            },
        },
        mounted() {
            
        }
    }
</script>
