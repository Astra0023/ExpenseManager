<template>
    <nav id="sidebar">
        <div class="sidebar-header">
            <img :src="'/userprofile.png'" class="rounded-circle ms-5" alt="Cinque Terre" width="100" height="100">
            <h6 class="ms-3">
                Jhon Carlos Tamba
            </h6> 
        </div>

        <ul class="list-unstyled components">
            <li>
                <router-link to="/">Dashboard</router-link>
            </li>
            <li class="active">
                <a href="#homeSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">User Management</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <router-link to="/roles">Role</router-link>
                    </li>
                    <li>
                        <router-link to="/user">Users</router-link>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#pageSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Expenses Management</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <router-link to="/expensecategory">Expense Category</router-link>
                    </li>
                    <li>
                        <router-link to="/expenses">Expenses</router-link>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
</template>

<style scoped>

</style>