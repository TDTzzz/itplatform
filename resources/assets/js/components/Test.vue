<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12" v-if="has_test==0">
                <div class="panel panel-default">
                    <div>
                        <div v-for="n in correct.length" style="display: inline-block" v-on:click="boxActive(n,0)">
                            <div class="box active" v-if="n-1==i" >
                                {{n}}
                            </div>
                            <div  class="box" v-else>
                                {{n}}
                            </div>

                        </div>

                    </div>
                    <div class="panel-heading" style="font-size: large">第{{i+1}}题:{{data[i].title}}</div>

                    <div class="panel-body">
                        <p v-for="(value,key) in data[i].choose_content" >
                            <input type="radio" name="optionsRadios" :value="key" v-model="picked">{{key}}:{{value}}
                        </p>
                    </div>
                </div>
                <button href="" class="btn btn-success btn-lg" v-if="i>0" v-on:click="i -= 1">上一题</button>
                <button href="" class="btn btn-success btn-lg" v-if="i<data.length-1" v-on:click="nextQuestion">下一题</button>
                <button href="" class="btn btn-success btn-lg" v-if="i==data.length-1" v-on:click="submit">提交</button>

            </div>
            <div class="col-md-12" v-if="has_test==1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        答题报告
                    </div>

                    <div class="panel-body">
                        <p>试卷类型:{{type}}</p>
                        <p>正确题数:{{grade}}</p>
                        <p>正确答案:{{correct}}</p>
                        <p>我的答案:{{record}}</p>
                    </div>
                    <button href="" class="btn btn-success btn-lg" v-on:click="watchTest">查看错题</button>

                </div>

            </div>
            <div class="col-md-12" v-if="has_test==3">
                <div class="panel panel-default">
                    <div>
                        <div v-for="n in correct.length" style="display: inline-block" v-on:click="boxActive(n,1)">
                            <div class="box active" v-if="n-1==i" >
                                {{n}}
                            </div>
                            <div  class="box" v-else>
                                {{n}}
                            </div>

                        </div>

                    </div>
                    <div class="panel-heading" style="font-size: large">第{{i+1}}题:{{data[i].title}}</div>

                    <div class="panel-body">
                        <div v-for="(value,key) in data[i].choose_content" style="height: 50px;line-height: 50px;margin:10px 0;">
                            <p v-if="key==correct[i]"  style="border: 2px solid #6dc57b;border-radius: 20px;padding-left: 10px">
                                <input type="radio" name="optionsRadios"  :value="key" v-model="picked2" disabled>{{key}}:{{value}}
                            </p>
                            <p v-else-if="key==record[i]&&record[i]!=correct[i]" style="border: 2px solid #ff351a;border-radius: 20px;padding-left: 10px">
                                <input type="radio" name="optionsRadios"  :value="key" v-model="picked2" disabled>{{key}}:{{value}}
                            </p>
                            <p v-else style="border: 2px solid #6f6f6f;border-radius: 20px;padding-left: 10px">
                                <input type="radio" name="optionsRadios"  :value="key" v-model="picked2" disabled>{{key}}:{{value}}
                            </p>
                        </div>

                        <p>正确答案:{{correct[i]}}</p>
                        <p>你的答案:{{record[i]}}</p>
                        <p>解析:<span v-html="data[i].parsing"></span></p>
                    </div>
                </div>
                <button href="" class="btn btn-success btn-lg" v-if="i>0" v-on:click="lastQuestion2">上一题</button>
                <button href="" class="btn btn-success btn-lg" v-if="i<data.length-1" v-on:click="nextQuestion2">下一题</button>
                <button href="" class="btn btn-success btn-lg pull-right" v-on:click="watchReport">查看报告</button>

            </div>

    </div>
    </div>
</template>

<script>
    export default {
        props:['type','user'],
        data(){
            return{
                data:{},
                i:0,
                hasData:{},
                picked:"",
                has_test:0,
                grade:0,
                correct:'',
                record:'',
                isActive:false,
                picked2:'',
            }
        },
        created(){
            axios.get('/api/hasTest/'+this.type+'/'+this.user).then(response=>{
                this.correct=response.data.correct;
                if (response.data.has_test!=0){
                    this.has_test=1;
                    this.grade=response.data.grade;
                    this.record=eval ("(" + response.data.record+ ")");
                }
            })
        },
        mounted(){
            axios.post('/api/test',{type:this.type}).then(response=>{
                this.data=response.data.data;
                this.data.forEach(function(e){
                    e.choose_content=JSON.parse(e.choose_content);
                });

            })
        },
        methods:{
            nextQuestion(){
                //把当前第i个的选择题答案保存起来
                this.hasData[this.i]=this.picked;
                this.i+=1;
                this.picked='';

            },
            nextQuestion2(){
                //把当前第i个的选择题答案保存起来
                this.i+=1;
                this.picked2=this.record[this.i];

            },
            lastQuestion2(){
                //把当前第i个的选择题答案保存起来
                this.i-=1;
                this.picked2=this.record[this.i];
            },
            submit(){
                this.hasData[this.i]=this.picked;
                axios.post('/api/testSubmit',{type:this.type,data:this.hasData}).then(response=>{
                    this.grade=response.data.grade;
                    this.record=eval ("(" + response.data.record+ ")");
                    this.correct=response.data.correct;
                    this.has_test=1;
                    this.i=0;
                })


            },
            watchTest(){
                this.has_test=3;
                this.picked2=this.record[this.i];

            },
            boxActive(n,hasTest){
                this.i=n-1;
                if(hasTest==1){
                    this.picked2=this.record[this.i];
                }
            },
            watchReport(){
                this.has_test=1;
            }
        }
    }
</script>
