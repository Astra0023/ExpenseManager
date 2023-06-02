<template>
    <div class="d-flex align-items-center justify-content-center vh-100">
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
                    <th scope="col">Expense Category</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Entry Date</th>
                    <th scope="col">Created at</th>
                </tr>
                </thead>
                <tbody class="table-group-divider" v-if="this.expenses.length > 0">
                <tr class="row-pointer" v-on:click="getExpensesData(expense.expensesID)" data-bs-toggle="modal" data-bs-target="#editExpenses" v-for="(expense, index) in this.expenses" :key="index">
                    <td>{{expense.expense_category.name}}</td>
                    <td>₱ {{expense.amount}}</td>
                    <td>{{format_date(expense.entry_date)}}</td>
                    <td>{{format_date(expense.created_at)}}</td>
                </tr>
                </tbody>
                <tbody class="table-group-divider" v-else-if="this.expenses.length == 0">
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
                    <select class="form-select" v-model="model.expenses.categoryID">
                        <option disabled value="selected">Please select category</option>
                        <option v-for="(category, index) in this.categories" :key="index" v-bind:value="category.categoryID">
                          {{ category.name }}
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="expensesAmount" class="form-label">Amount</label>
                    <input type="number" class="form-control" v-model="model.expenses.amount" min=0 oninput="validity.valid||(value='');" id="expensesAmount" name="expensesAmount">
                </div>
                <div class="mb-3">
                    <p>
                        Date: 
                    </p>
                    <input type="text" v-model="model.expenses.entryDate" id="expensesEntryDate" name="expensesEntryDate">
                </div>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" @click="storeExpenses" class="btn btn-primary">Add</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Edit role Modal -->
    <div class="modal fade" id="editExpenses" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
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
                            <select class="form-select" v-model="model.editexpenses.categoryID">
                                <option disabled value="selected">Please select category</option>
                                <option v-for="(category, index) in this.categories" :key="index" v-bind:value="category.categoryID">
                                {{ category.name }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editexpensesAmount" class="form-label">Amount</label>
                            <input type="number" class="form-control" v-model="model.editexpenses.amount" min=0 oninput="validity.valid||(value='');" id="editexpensesAmount" name="editexpensesAmount">
                        </div>
                        <div class="mb-3">
                            <p>
                                Date: 
                            </p>
                            <input type="text" v-model="model.editexpenses.entry_date" id="editexpensesEntryDate" name="expensesEntryDate">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="mr-auto btn btn-danger" @click="deleteExpenses(model.editexpenses.expensesID)">Delete</button>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" @click="updateExpenses()" class="btn btn-primary ms-2">Update</button>
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
        name: 'Expense',
        data(){
            return{
                errorList: '',
                errorEditList: '',
                categories: [],
                expenses: [],
                model: {
                    expenses: {
                        amount: '',
                        entryDate: '',
                        categoryID: 'selected'
                    },
                    editexpenses: {
                        expensesID: '',
                        categoryID: '',
                        amount: '',
                        entry_date: ''
                    }
                }
            }
        },
        mounted(){
            var thisVar = this;
            this.getExpenses();
            $(function() {
                $( "#expensesEntryDate" ).datepicker( { maxDate: new Date(), dateFormat: "yy-mm-dd" } );
                    $("#expensesEntryDate").on("change",function(){
                    
                    var selected = $(this).val();
                    thisVar.model.expenses.entryDate = selected;
                });

                $( "#editexpensesEntryDate" ).datepicker( { maxDate: new Date(), dateFormat: "yy-mm-dd" } );
                    $("#editexpensesEntryDate").on("change",function(){
                    var selected = $(this).val();
                    thisVar.model.editexpenses.entry_date = selected;
                });
            });
        },
        methods: {
            format_date(value){
                if (value) {
                    return moment(String(value)).format('YYYY-MM-DD hh:mm')
                }
            },
            getExpenses(){
            axios.get('http://localhost:8000/api/expenses/lists').then(res => {
                this.categories = res.data.categories
                this.expenses = res.data.expenses
                });
                
            },
            storeExpenses(){
            var thisVar = this;
            axios.post('http://localhost:8000/api/expenses/store', this.model.expenses).then(res => {
                this.model.expenses = {
                    categoryID: 'selected',
                    amount: '',
                    entryDate: ''
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
            getExpensesData(expensesID){
                axios.get(`http://localhost:8000/api/expenses/${expensesID}`).then(res => {
                    this.model.editexpenses = res.data.getCategory
                });
            },
            updateExpenses(){
            var thisVar = this;
            axios.put(`http://localhost:8000/api/expenses/${this.model.editexpenses.expensesID}/edit`, this.model.editexpenses).then(res => {
                this.model.editrole = {
                    expensesID: '',
                    categoryID: '',
                    amount: '',
                    entry_date: ''
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
            deleteExpenses(expenesID){
            axios.put(`http://localhost:8000/api/expenses/${expenesID}/delete`).then(res => {
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