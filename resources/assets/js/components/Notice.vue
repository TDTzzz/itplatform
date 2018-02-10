<template>
    <span
            class="glyphicon glyphicon-bell col-xs-3"
            style=" cursor: pointer;margin-top: 15px;line-height: 24px;font-size: 25px;"
            v-bind:class="{active:isActive}"
            onclick="window.location.href='/notification'">{{count}}
    </span>

</template>

<script>
    export default {
        props:['user'],
        data() {
            return {
                count:0,
                isActive:false
            }
        },
        mounted(){
            this.countNum(this.user)
        },
        methods:{
            countNum() {
                axios.post('/api/countNotice',{user:this.user}).then(response=>{
                    console.log(response.data)
                    if(response.data.count>0){
                        this.count=response.data.count;
                        isActive:true;
                    }else{
                        this.count="";
                    }
                })
            },

        }
    }
</script>
