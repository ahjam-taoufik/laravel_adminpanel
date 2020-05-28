<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>

                        <div class="card-tools">
                           <button class="btn btn-success"  @click="addUser">
                               Add New
                                <i class="fa fa-fw"></i>
                               <i class="fa fa-fw fa-user-plus"></i>

                           </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                             <!--   <th>Password</th>-->
                                <th>Type</th>
                                <th>Registred At</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                               <!-- <td>{{user.password}}</td>-->
                                <td>{{user.type | upText}}</td>
                                <td>{{user.created_at | myDate}}</td>

                                <td>
                                    <a href="#" @click="editUser(user)"><i class="fa fa-edit"></i></a>
                                    <a href="#" @click="deleteUser(user.id)">
                                        <i class="fa fa-trash "></i>
                                    </a>

                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editMode" class="modal-title" >New User</h5>
                        <h5 v-show="editMode" class="modal-title" >Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                   <!-- submit Form------------------------------------------------------>
                    <form @submit.prevent="editMode ? updateUser() : createUser() ">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Your Name</label>
                            <input v-model="form.name" type="text" name="name"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="email" name="email"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input v-model="form.password" type="password" name="password"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Bio (Optional)</label>
                            <textarea v-model="form.bio" type="text" name="bio"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                            <has-error :form="form" field="bio"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" v-model="form.type" id="type" class="form-control" :class="{
                                'is-invalid':form.errors.has('type')}">
                                <option value="">Select User Role</option>
                                <option value="admin">Admin</option>
                                <option value="user">standard User</option>
                                <option value="author">Author</option>


                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editMode" type="submit" class="btn btn-warning" >Update</button>
                        <button v-show="!editMode" type="submit" class="btn btn-primary" >Create</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'users',
        data(){
          return {
              editMode : false,
              users :{},
              form: new Form({
                  id:'',
                  name :'',
                  email :'',
                  password :'',
                  type :'',
                  bio :'',
                  photo :''
              })
          }
        },
        methods : {
            updateUser(){
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                .then(
                    ()=>{
                        $('#addNewModal').modal('hide');
                        Swal.fire(
                            'Updated!',
                            'Your User has been Updated.',
                            'success'
                        )
                        this.$Progress.finish();
                        Fire1.$emit('afterOperation');
                    }
                )
                .catch(
                   ()=>{
                        this.$Progress.fail();
                       Swal.fire(
                           'Problem',
                           'Your are not authorise',
                           'warning'
                       )
                       $('#addNewModal').modal('hide');
                    }
                );
            },
            addUser(){
                this.editMode=false;
                this.form.reset();
                this.form.clear();
                $('#addNewModal').modal('show');

            },
            editUser(user){
                this.editMode=true;
                this.form.reset();
                this.form.clear();
                $('#addNewModal').modal('show');
                this.form.fill(user)
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                      if (result.value){
                          this.form.delete('api/user/'+id)
                              .then(()=>{
                                  Swal.fire(
                                      'Deleted!',
                                      'Your User has been deleted.',
                                      'success'
                                  )
                                  Fire1.$emit('afterOperation');
                              })
                              .catch(()=>{
                                  //Swal("Failed","There was somthing wrong","Warning");
                                  Swal.fire(
                                      'Problem',
                                      'Your are not authorise',
                                      'warning'
                                  )
                                  $('#addNewModal').modal('hide');
                              });
                      }

                })
            },
            loadUsers(){
                axios.get("api/user").then(
                    ({data})=>(this.users=data.data) // this is a function anonym
                );
            },
           createUser(){
               this.$Progress.start();
               this.form.post('api/user')
                   .then(()=>{
                       $('#addNewModal').modal('hide');
                             toast.fire({
                              icon: 'success',
                              title: 'User Created successfully'
                              })}
                      )
                   .catch(
                       ()=>{
                           Swal.fire(
                               'Problem',
                               'Your are not authorise',
                               'warning'
                           )
                           $('#addNewModal').modal('hide');

                       }

                   );
              // this.loadUsers();  you can refresh on call loadUsers() function without $emit
               Fire1.$emit('afterOperation');


               this.$Progress.finish();
           }
        },
        created() {
           this.loadUsers();
           Fire1.$on('afterOperation',()=>{
              this.loadUsers();
           });
          // setInterval(()=>this.loadUsers(),3000);
        }
    }
</script>
