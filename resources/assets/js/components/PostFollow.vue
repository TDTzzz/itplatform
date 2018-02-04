<template>
    <button class="btn btn-default"
            v-bind:class="{'btn-success':followed}"
            v-text="text"
            v-on:click="follow"></button>
</template>

<script>
    export default {
        props:['post'],

        mounted() {
            axios.post('/api/post/follower',{post:this.post}).then(response=>{
                console.log(response.data)
                this.followed=response.data.followed
            })
        },

        data(){
            return{
                followed:false,
            }
        },
        computed:{
            text(){
                return this.followed?'已收藏':'收藏该文章'
            }
        },
        methods:{
            follow(){
                axios.post('/api/post/follow',{post:this.post}).then(response=>{
                    console.log(response.data)
                    this.followed=response.data.followed
                })
            }
        }
    }
</script>
