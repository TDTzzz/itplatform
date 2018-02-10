
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('question-follow', require('./components/QuestionFollow.vue'));
Vue.component('user-follow', require('./components/UserFollow.vue'));
Vue.component('user-vote', require('./components/UserVote.vue'));
Vue.component('send-message', require('./components/SendMessage.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('change-avatar', require('./components/Avatar.vue'));
Vue.component('post-follow', require('./components/PostFollow.vue'));
Vue.component('notice', require('./components/Notice.vue'));

const app = new Vue({
    el: '#app'
});
