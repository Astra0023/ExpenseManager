<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img :src="'/userprofile.png'" class="rounded-circle ms-5" alt="Cinque Terre" width="100" height="100">
                <h6 class="ms-3">
                    Jhon Carlos Tamba
                </h6> 
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">User Management</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#">Role</a>
                        </li>
                        <li>
                            <a href="#">Users</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#pageSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Expenses Management</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Expense Category</a>
                        </li>
                        <li>
                            <a href="#">Expenses</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="d-flex container-fluid">
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="gap-5 ml-auto nav navbar-nav">
                            <li class="mt-1 nav-item">
                                <p class="text-muted">Welcome to Expense Manager</p>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <h1>
                            My Expenses
                        </h1>
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
    /*
    DEMO STYLE
*/

@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";
body {
    font-family: 'Poppins', sans-serif;
    background: #fafafa;
}

p {
    font-family: 'Poppins', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    line-height: 1.7em;
    color: #999;
}

a,
a:hover,
a:focus {
    color: inherit;
    text-decoration: none;
    transition: all 0.3s;
}

.navbar {
    padding: 15px 10px;
    background: #fff;
    border: none;
    border-radius: 0;
    margin-bottom: 40px;
    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

.navbar-btn {
    box-shadow: none;
    outline: none !important;
    border: none;
}

.line {
    width: 100%;
    height: 1px;
    border-bottom: 1px dashed #ddd;
    margin: 40px 0;
}

/* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

.wrapper {
    display: flex;
    width: 100%;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    background: #7386D5;
    color: #fff;
    transition: all 0.3s;
}

#sidebar.active {
    margin-left: -250px;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: #6d7fcc;
}

#sidebar ul.components {
    padding: 20px 0;
    border-bottom: 1px solid #47748b;
}

#sidebar ul p {
    color: #fff;
    padding: 10px;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1.1em;
    display: block;
}

#sidebar ul li a:hover {
    color: #7386D5;
    background: #fff;
}

#sidebar ul li.active>a,
a[aria-expanded="true"] {
    color: #fff;
    background: #6d7fcc;
}

a[data-toggle="collapse"] {
    position: relative;
}

.dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
}

ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: #6d7fcc;
}

ul.CTAs {
    padding: 20px;
}

ul.CTAs a {
    text-align: center;
    font-size: 0.9em !important;
    display: block;
    border-radius: 5px;
    margin-bottom: 5px;
}

a.download {
    background: #fff;
    color: #7386D5;
}

a.article,
a.article:hover {
    background: #6d7fcc !important;
    color: #fff !important;
}

/* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */

#content {
    width: 100%;
    padding: 20px;
    min-height: 100vh;
    transition: all 0.3s;
}

/* ---------------------------------------------------
    MEDIAQUERIES
----------------------------------------------------- */

@media (max-width: 768px) {
    #sidebar {
        margin-left: -250px;
    }
    #sidebar.active {
        margin-left: 0;
    }
    #sidebarCollapse span {
        display: none;
    }
}
</style>

<script scope="this api replaced by slot-scope in 2.5.0+">
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
                'legend':'left',
                title: 'Expenses Categories'
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