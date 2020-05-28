<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!---->
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username" >{{user.name}}</h3>

                        <h5 class="widget-user-desc"> Email :  {{user.email}}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="img/person.png" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">SALES</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text">FOLLOWERS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text">PRODUCTS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!---->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'profile',
        data(){
          return {
              user :'',
             /* form: new Form({
                  id:'',
                  name :'',
                  email :'',
                  password :'',
                  type :'',
                  bio :'',
                  photo :''
              })*/
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
           /* axios.get("api/profile")
            .then(({data})=>(this.form.fill(data)));*/
            axios.get("api/profile").then(
                ({data})=>(this.user=data) // this is a function anonym
            );
        }
    }
</script>
