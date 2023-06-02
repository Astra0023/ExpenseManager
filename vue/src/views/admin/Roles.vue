<template>
  <div class="d-flex align-items-center justify-content-center vh-100">
    <div class="border-0 card">
      <div class="card-header">
        <div class="text-end">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRole">
            Add Role
          </button>
        </div>
      </div>
      <div class="card-body">

        <table class="table">
            <thead>
              <tr>
                <th scope="col">Role Name</th>
                <th scope="col">Description</th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody class="table-group-divider" v-if="this.roles.length > 0">
              <tr class="row-pointer" v-on:click="getRoleData(role.roleID)" data-bs-toggle="modal" data-bs-target="#editRole" v-for="(role, index) in this.roles" :key="index">
                <td>{{role.name}}</td>
                <td>{{role.description}}</td>
                <td>{{role.created_at}}</td>
              </tr>
            </tbody>
            <tbody class="table-group-divider" v-else>
              <tr>
                <td colspan="4">Loading ...</td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
  </div>

  <!-- Add role Modal -->
  <div class="modal fade" id="addRole" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addRoleModalLabel">Add Role</h1>
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
              <label for="roleName" class="form-label">Role Name</label>
              <input type="text" class="form-control" v-model="model.role.name" id="roleName" name="roleName" aria-describedby="roleName">
            </div>
            <div class="mb-3">
              <label for="roleDescription" class="form-label">Description</label>
              <input type="text" class="form-control" v-model="model.role.description" id="roleDescription" name="roleDescription">
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
  <!-- Edit role Modal -->
  <div class="modal fade" id="editRole" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
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
              <input type="hidden" v-model="model.editrole.roleID" id="editroleRoleID" name="editroleRoleID" aria-describedby="roleName">
              <label for="editroleName" class="form-label">Role Name</label>
              <input type="text" class="form-control" v-model="model.editrole.name" id="editroleName" name="editroleName" aria-describedby="roleName">
            </div>
            <div class="mb-3">
              <label for="editroleDescription" class="form-label">Description</label>
              <input type="text" class="form-control" v-model="model.editrole.description" id="editroleDescription" name="editroleDescription">
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" v-if="model.editrole.name != 'Administrator' " class="mr-auto btn btn-danger" @click="deleteRole(model.editrole.roleID)">Delete</button>
          <div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" v-if="model.editrole.name != 'Administrator' " @click="updateRole()" class="btn btn-primary ms-2">Update</button>
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
import axios from 'axios'
    export default {
        name: 'Roles',
        data(){
            return{
                errorList: '',
                errorEditList: '',
                roles: [],
                model: {
                  role: {
                    name: '',
                    description: ''
                  },
                  editrole: {
                    roleID: '',
                    name: '',
                    description: ''
                  }
                }
            }
        },
        mounted(){
          this.getRole();
        },
        methods: {
            getRole(){
              axios.get('http://localhost:8000/api/role/lists').then(res => {
              this.roles = res.data.roles
              });
            },
            storeRole(){
              var thisVar = this;
              axios.post('http://localhost:8000/api/role/store', this.model.role).then(res => {
                this.model.role = {
                  name: '',
                  description: ''
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
            getRoleData(roleID){
              axios.get(`http://localhost:8000/api/role/${roleID}`).then(res => {
                this.model.editrole.roleID = res.data.getRole.roleID
                this.model.editrole.name = res.data.getRole.name
                this.model.editrole.description = res.data.getRole.description
              });
            },
            updateRole(){
              var thisVar = this;
              axios.put(`http://localhost:8000/api/role/${this.model.editrole.roleID}/edit`, this.model.editrole).then(res => {
                this.model.editrole = {
                  roleID: '',
                  name: '',
                  description: ''
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
            deleteRole(roleID){
              axios.put(`http://localhost:8000/api/role/${roleID}/delete`).then(res => {
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