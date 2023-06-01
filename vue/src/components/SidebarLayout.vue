<template>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto px-0 col-md-3 col-xl-2 px-sm-2 bg-dark">
                <div class="px-3 pt-2 text-white d-flex flex-column align-items-center align-items-sm-start min-vh-100">
                    <ul class="mb-0 nav nav-pills flex-column mb-sm-auto align-items-center align-items-sm-start" id="menu">
                        <li class="text-center ">
                            <a href="#" class="px-0 align-middle nav-link">
                                <i class="fa fas fa-user-circle"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Dashboard'}" href="#" class="px-0 align-middle nav-link">
                                <i class="fa fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </router-link>
                        </li>
                        <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="px-0 align-middle nav-link">
                                <i class="fs-4 bi-speedometer2"></i> 
                                <span class="ms-1 d-none d-sm-inline">User Management</span>
                            </a>
                            <ul class="collapse show nav flex-column ms-3" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="px-0 nav-link"> 
                                        <span class="d-none d-sm-inline">Roles</span>
                                    </a>
                                </li>
                                <li>
                                    <router-link :to="{name: 'Login'}" class="px-0 nav-link"> 
                                        <span class="d-none d-sm-inline">User</span>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#submenu2" data-bs-toggle="collapse" class="px-0 align-middle nav-link ">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Expense Management</span>
                            </a>
                            <ul class="collapse nav flex-column ms-3" id="submenu2" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="px-0 nav-link"> 
                                        <span class="d-none d-sm-inline">Expense Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="px-0 nav-link"> 
                                        <span class="d-none d-sm-inline">Expenses</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <hr>
                    <div class="pb-4 dropdown">
                        <a href="#" class="text-white d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="mx-1 d-none d-sm-inline">loser</span>
                        </a>
                        <ul class="shadow dropdown-menu dropdown-menu-dark text-small">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="py-3 col">
                Content area...
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>