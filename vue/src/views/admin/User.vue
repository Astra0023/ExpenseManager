<script setup>
  import SidebarLayout from '../../components/SidebarLayout.vue';
  import headerNavbarLayout from '../../components/headerNavbarLayout.vue';
</script>
<template>
  <div class="wrapper">
    <!-- Sidebar  -->
  <SidebarLayout></SidebarLayout>
  <div id="content">
      <!-- Header -->
    <headerNavbarLayout></headerNavbarLayout>
    <div class="container align-items-center justify-content-center vh-100">
      <div class="border-0 card">
        <div class="card-header">
          <div class="text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRole">
              Add User
            </button>
          </div>
        </div>
        <div class="card-body">
          <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Email Address</th>
                  <th scope="col">Role</th>
                  <th scope="col">Created at</th>
                </tr>
              </thead>
              <tbody class="table-group-divider" v-if="this.users.length > 0">
                <tr class="row-pointer" v-on:click="getUserData(user.userID)" data-bs-toggle="modal" data-bs-target="#editUser" v-for="(user, index) in this.users" :key="index">
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.role.name}}</td>
                  <td>{{format_date(user.created_at)}}</td>
                </tr>
              </tbody>
              <tbody class="table-group-divider" v-else-if="this.users.length == 0">
                <tr>
                  <td colspan="4" class="bg-danger">No data found</td>
                </tr>
              </tbody>
              <tbody class="table-group-divider" v-else>
                <tr class="row-pointer">
                  <td>Loading ...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!-- Add user Modal -->
  <div class="modal fade" id="addRole" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content" style="height: 500px;">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addRoleModalLabel">Add User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
            <li class="mb-0 ms-3" v-for="(errorMessage, index) in this.errorList" :key="index">
              {{ errorMessage[0] }}
            </li>
          </ul>
          <form>
            <div class="mb-3">
              <label for="userName" class="form-label">User Name</label>
              <input type="text" class="form-control" v-model="model.user.name" id="userName" name="userName" aria-describedby="roleName">
            </div>
            <div class="mb-3">
              <label for="userEmail" class="form-label">Email</label>
              <input type="email" class="form-control" v-model="model.user.email" id="userEmail" name="userEmail">
            </div>
            <div class="mb-3">
              <select class="form-select" v-model="model.user.roleID">
                  <option disabled value="selected">Please select one</option>
                  <option v-for="(role, index) in this.roles" :key="index" v-bind:value="role.roleID">
                    {{ role.name }}
                  </option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" @click="storeRole" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Edit user Modal -->
  <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editRoleModalLabel">Update Role</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="alert alert-warning" v-if="Object.keys(this.errorEditList).length > 0">
            <li class="mb-0 ms-3" v-for="(errorMessage, index) in this.errorEditList" :key="index">
              {{ errorMessage[0] }}
            </li>
          </ul>
          <form>
            <div class="mb-3">
              <input type="hidden" v-model="model.edituser.userID" id="edituserUserID" name="edituserUserID" aria-describedby="roleName">
              <label for="edituserName" class="form-label">User Name</label>
              <input type="text" class="form-control" v-model="model.edituser.name" id="edituserName" name="edituserName" aria-describedby="roleName">
            </div>
            <div class="mb-3">
              <label for="edituserEmail" class="form-label">Email</label>
              <input type="text" class="form-control" v-model="model.edituser.email" id="edituserEmail" name="edituserEmail">
            </div>
            <div class="mb-3">
              <select class="form-select" v-model="model.edituser.roleID" name="edituserRole" id="edituserRole">
                  <option disabled value="selected">Please select one</option>
                  <option v-for="(role, index) in this.roles" :key="index" v-bind:value="role.roleID">
                    {{ role.name }}
                  </option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" v-if="model.edituser.roleID != '6' " class="mr-auto btn btn-danger" @click="deleteUser(model.edituser.userID)">Delete</button>
          <div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" v-if="model.edituser.roleID != '6' " @click="updateRole()" class="btn btn-primary ms-2">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<style lang="css" scoped>
  .row-pointer {
    cursor: pointer;
  }
</style>
  
<script>
  import moment from 'moment';
  import { ref } from "vue";
  import axios from 'axios'
  export default {
    name: 'Users',
    data(){
        return{
            errorList: '',
            errorEditList: '',
            users: [],
            roles: [],
            editusers: [],
            model: {
              user: {
                  name: '',
                  email: '',
                  roleID: 'selected'
              },
              edituser: {
                  userID: '',
                  name: '',
                  email: '',
                  roleID: ''
              }
            }
        }
    },
    mounted(){
      this.getUser();
    },
    methods: {
      format_date(value){
        if (value) {
            return moment(String(value)).format('YYYY-MM-DD hh:mm')
        }
      },
      getUser(){
          axios.get('http://localhost:8000/api/user/lists').then(res => {
          this.users = res.data.users
          this.roles = res.data.roles
          });
      },
      storeRole(){
          var thisVar = this;
          axios.post('http://localhost:8000/api/user/store', this.model.user).then(res => {
            this.model.user = {
              name: '',
              email: '',
              roleID: 'selected'
            }
            this.errorList = '';
            if(alert(res.data.message)){}
            else    window.location.reload(); 
          }).catch(function (error){
            if(error.response){
              if (error.response.status === 422) {
                thisVar.errorList = error.response.data.errors;
              } else if (error.request) {
                console.log(error.request);
              } else {
                console.log('Error', error.message);
              }
            } 
          })
      },
      getUserData(userID){
          axios.get(`http://localhost:8000/api/user/${userID}`).then(res => {
            this.model.edituser.userID = res.data.userGet.userID
            this.model.edituser.name = res.data.userGet.name
            this.model.edituser.email = res.data.userGet.email
            this.model.edituser.roleID = res.data.userGet.roleID
          });
      },
      updateRole(){
        var thisVar = this;
        axios.put(`http://localhost:8000/api/user/${this.model.edituser.userID}/edit`, this.model.edituser).then(res => {
          this.model.edituser = {
            userID: '',
            roleID: '',
            name: '',
            email: ''
          }
          this.errorEditList = '';
          if(alert(res.data.message)){}
          else    window.location.reload(); 
        
        }).catch(function (error){
          if(error.response){
            if (error.response.status === 422) {
              thisVar.errorEditList = error.response.data.errors;
            } else if (error.request) {
              console.log(error.request);
            } else {
              console.log('Error', error.message);
            }
          } 
        })
      },
      deleteUser(userID){
        axios.put(`http://localhost:8000/api/user/${userID}/delete`).then(res => {
          if(alert(res.data.message)){}
          else    window.location.reload(); 
        }).catch(function (error){
          if(error.response){
            if (error.response.status === 422) {
              thisVar.errorEditList = error.response.data.errors;
            } else if (error.request) {
              console.log(error.request);
            } else {
              console.log('Error', error.message);
            }
          } 
        })
      }
    },
  }
</script>