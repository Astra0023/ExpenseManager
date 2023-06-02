<script setup>
import SidebarLayout from '../../components/SidebarLayout.vue';
import headerNavbarLayout from '../../components/headerNavbarLayout.vue';
</script>
<template>
    <div class="wrapper">
        <!-- Sidebar  -->
    <SidebarLayout></SidebarLayout>
        <!-- Page Content  -->
        <div id="content">
            <headerNavbarLayout></headerNavbarLayout>
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <table class="table caption-top" style="width: 500px;">
                            <caption><h3>My Expenses</h3></caption>
                            <thead>
                                <tr>
                                    <th>Expenses Categories</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in this.categories" :key="index">
                                   <td>
                                        {{category.expense_category.name}}
                                   </td>
                                   <td>
                                        {{category.amount}}
                                   </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="piechart" style="width: 900px; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
</style>

<script>
import axios from 'axios'
export default {
    name: "Dashboard",
    data(){
        return{
            categories: [],
            model: {
                category: {
                name: '',
                total: ''
                }
            }
        }
    },    
    mounted(){
      
      this.getExpenses();

    },
    methods: {
        getExpenses(){
        var myvar = this;
        axios.get('http://localhost:8000/api/dashboard/expenses').then(res => {
            this.model.category = res.data.categoriesexpenses
            this.categories = this.model.category
            $(document).ready(function(){
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Expenses Categories');
                        data.addColumn('number', 'Total');
                    for(let i = 0; i < res.data.categoriesexpenses.length; i++) {
                        if(res.data.categoriesexpenses[i])
                        data.addRow([res.data.categoriesexpenses[i].expense_category.name, res.data.categoriesexpenses[i].amount]);
                    }
                    
                    var options = {
                    legend:'left',
                    title: 'Expenses Chart'
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                    chart.draw(data, options);
                }
            }); 
        });
      },
    }
}
</script>