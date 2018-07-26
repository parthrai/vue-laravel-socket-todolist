<template>

    <section>
    <div class="row">
        <div class="col-lg-12">
            <h1>Todo List ({{tasks.length}}) </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <input type="text" class="add-task-txtBox" @blur="addTask()" >
        </div>

        <div class="col-lg-4">
            <button class="btn btn-primary" @click="addTask()">Add</button>
        </div>
    </div>


    <task
        v-for="(task,index) in tasks"
        v-bind:data="task.task"
        v-bind:index="task.id"
        :key="index"
        @delete="deleteTask"


    >
    </task>



    </section>


</template>


<script>
    window.io = require('socket.io-client');

    window.socket = io('http://vue.test:3000');


    export default{



        data(){
          return{
              task:'',
              tasks:[],

          }
        },
        mounted(){
            let ref=this;
            console.log('mounted');
            this.updateData();



                socket.on('test-channel:TaskAdded', function (data) {

                    console.log("New task from socket     " + data.taskName);
                    //console.log("Length     " + this.tasks.length);
                    //  this.tasks.push(data.taskName);
                    console.log("name is +" + this.name);


                    axios.get('http://vue.test/api/todo')
                        .then(response => {
                            //console.log(response.data);
                            //console.log('updated data : ' + response.data);

                            ref.tasks = (response.data);




                        });
                })




        },

        ready:function(){

            console.log("I am inready");
        },

        methods:{




            updateData(){


                axios.get('http://vue.test/api/todo')
                    .then(response => {
                        //console.log(response.data);

                        this.tasks=(response.data);


                        console.log("in update");
                    });

            },

            addTask(){
                let task = event.target.value;

                this.tasks.push(task);

                const data = {
                    task:task,
                }
                axios.post('http://vue.test/api/todo',data)
                    .then(response => {

                        console.log(response);
                    });

                event.target.value="";

              this.updateData();

            },

            deleteTask(index){

                const data = {
                    id:index,
                }
                axios.delete('http://vue.test/api/todo/'+index,data)
                    .then(response => {
                        console.log(response);
                    });
                this.tasks.splice(index,1);

                axios.get('http://vue.test/api/todo')
                    .then(response => {
                        //console.log(response.data);

                        this.tasks=(response.data);



                    });
            }
        }
    }
</script>

<style>
    .add-task-txtBox{
        width:100%;
    }
</style>