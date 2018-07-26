<template>

    <div class="row">

        <div class="col-lg-12">
            <h3 @click="del">{{data}},{{index}}</h3>
        </div>

    </div>

</template>

<script>
    export default {

        props: ['data','index','id'],

        methods:{

            del(){

                this.$emit('delete', this.index);

            }

        }

    }






</script>