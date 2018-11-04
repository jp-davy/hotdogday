
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import swal from 'sweetalert';

window.swal = require('sweetalert');

import Errors from './components/errors';
import Form from './components/form';



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import moment from 'moment';

var formatter = {
    date: function (value, format) { 
        if (value) {
            return moment(String(value)).format(format || 'MM.DD.YYYY')
        }
    },
    time: function (value, format) {
        if (value) {
            return moment(String(value)).format(format || 'h:mm A');
        }
    }
};

Vue.component('format', {
    template: `<span>{{ formatter[fn](value, format) }}</span>`,
    props: ['value', 'fn', 'format'],
    computed: {
        formatter() {
            return formatter;
        }
    }
});

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('order-user-component', require('./components/OrderUserComponent.vue'));
Vue.component('number-control-component', require('./components/NumberControlComponent.vue'));
Vue.component('student-component', require('./components/StudentComponent.vue'));


var orderInfo = new Vue({
    el: '#orderInfo',

    data: {
        form: new Form({
            id : '',
            user_id : '',
            name : '',
            meal_qty : 0,
            extra_qty : 0
        }),
        user : window.user,
        students : window.user.students,
        success: false
    },

    components: {
        user: 'order-user-component',
        student: 'student-component',
    },

    computed: {
    	mealPrice: function () { return window.meal_price; },
        extraPrice: function () { return window.extra_price; },
    	totalMealQty: function () { 
    		return this.students.reduce( (qty, student) => qty + student.meal_qty, 0); 
    	},
    	totalExtraQty: function () { 
    		return this.students.reduce( (qty, student) => qty + student.extra_qty, 0); 
    	},
    	grandTotalCost: function () { 
    		return ((this.totalMealQty * window.meal_price) + (this.totalExtraQty * window.extra_price)); 
    	},
    },

    methods: {
        
        onSubmit() {
            
            this.form.post('/family/' + this.user.uuid + '/students')
                .then(response => {
                    if(response.success) this.success = true;
                    if(response) this.addStudent(response.student);
                    this.form.reset();
                });
            
        },

        addStudent(item) {
            this.students.push(
                item
            );
        }
    },
});


