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
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
                Add Category
              </button>
            </div>
          </div>
          <div class="card-body">

            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Category Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Created at</th>
                  </tr>
                </thead>
                <tbody class="table-group-divider" v-if="this.categories.length > 0">
                  <tr class="row-pointer" v-on:click="getCategoryData(category.categoryID)" data-bs-toggle="modal" data-bs-target="#editRole" v-for="(category, index) in this.categories" :key="index">
                    <td>{{category.name}}</td>
                    <td>{{category.description}}</td>
                    <td>{{format_date(category.created_at)}}</td>
                  </tr>
                </tbody>
                <tbody class="table-group-divider" v-else-if="this.categories.length == 0">
                  <tr>
                    <td colspan="4" class="bg-danger">No data found</td>
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
    </div>
  </div>
  <!-- Add role Modal -->
  <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addCategoryModalLabel">Add Category</h1>
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
              <label for="categoryName" class="form-label">Category Name</label>
              <input type="text" class="form-control" v-model="model.category.name" id="categoryName" name="categoryName" aria-describedby="roleName">
            </div>
            <div class="mb-3">
              <label for="categoryDescription" class="form-label">Description</label>
              <input type="text" class="form-control" v-model="model.category.description" id="categoryDescription" name="categoryDescription">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" @click="storeCategory" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Edit role Modal -->
  <div class="modal fade" id="editRole" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editRoleModalLabel">Update Category</h1>
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
              <input type="hidden" v-model="model.editcategory.categoryID" id="editroleRoleID" name="editroleRoleID" aria-describedby="roleName">
              <label for="editroleName" class="form-label">Role Name</label>
              <input type="text" class="form-control" v-model="model.editcategory.name" id="editroleName" name="editroleName" aria-describedby="roleName">
            </div>
            <div class="mb-3">
              <label for="editroleDescription" class="form-label">Description</label>
              <input type="text" class="form-control" v-model="model.editcategory.description" id="editroleDescription" name="editroleDescription">
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="mr-auto btn btn-danger" @click="deleteCategory(model.editcategory.categoryID)">Delete</button>
          <div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" @click="updateCategory()" class="btn btn-primary ms-2">Update</button>
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
  import axios from 'axios'
  export default {
    name: 'ExpenseCategory',
    data(){
        return{
            errorList: '',
            errorEditList: '',
            categories: [],
            model: {
              category: {
                name: '',
                description: ''
              },
              editcategory: {
                categoryID: '',
                name: '',
                description: ''
              }
            }
        }
    },
    mounted(){
      this.getExpenseCategory();
    },
    methods: {
      format_date(value){
          if (value) {
              return moment(String(value)).format('YYYY-MM-DD hh:mm')
          }
      },
      getExpenseCategory(){
        axios.get('http://localhost:8000/api/expensecategory/lists').then(res => {
        this.categories = res.data.category
        });
      },
      storeCategory(){
        var thisVar = this;
        axios.post('http://localhost:8000/api/expensecategory/store', this.model.category).then(res => {
          this.model.category = {
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
      getCategoryData(categoryID){
        axios.get(`http://localhost:8000/api/expensecategory/${categoryID}`).then(res => {
          this.model.editcategory = res.data.getCategory
        });
      },
      updateCategory(){
        var thisVar = this;
        axios.put(`http://localhost:8000/api/expensecategory/${this.model.editcategory.categoryID}/edit`, this.model.editcategory).then(res => {
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
      deleteCategory(categoryID){
        axios.put(`http://localhost:8000/api/expensecategory/${categoryID}/delete`).then(res => {
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