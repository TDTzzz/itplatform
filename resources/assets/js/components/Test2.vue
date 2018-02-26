<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{data}}</div>

                    <div class="panel-body">
                        {{data}}
                        <p>----</p>
                        {{data3}}
                        <br>
                        <p v-for="option in data3">
                            {{option}}
                        </p>
                        <p>{{items}}</p>
                        <p v-for="k in items">
                            {{k.message}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['data'],
        data(){
            return {
                data2:[{"title":"php1"},{"title":"php2"}],
//                data3:[this.data],
                data3:[{"id":1,"title":"php\u9898\u76ee1","choose_content":"{\"A\":\"\u9009\u9879a\",\"B\":\"\u9009\u9879B\"}","choose_type":1,"grade":1,"test_type":"php","created_at":"2018-02-20 08:27:41","updated_at":"2018-02-20 08:27:41"},{"id":2,"title":"1","choose_content":"{\"A\":\"\u9009\u9879a\",\"B\":\"\u9009\u9879B\"}","choose_type":1,"grade":1,"test_type":"php","created_at":"2018-02-20 08:29:04","updated_at":"2018-02-20 08:29:04"}],
                items: [
                    { message: 'Foo',title:'title1' },
                    { message: 'Bar',title:'title2' }
                ]
            }
        },
        created: function () {
            // `this` 指向 vm 实例
            console.log(this.data)
        },
        method:{
//            toArray(json){
//                for (var i in json) {
//                    this.content.push(i);
//                    this.content.push(json[i])
//                }
//            }
        },

    }
</script>
