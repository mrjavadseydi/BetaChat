<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item ">
            <a href="{{route('panel')}}"
               class="nav-link {{ request()->is('panel') ? 'active':''   }} ">
                <i class="nav-icon fa fa-dashboard "></i>
                <p>داشبورد </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="#"
               class="nav-link  {{ request()->is('panel/plan') ? 'active':''   }} "
               >
                <i class="nav-icon fa fa-map "></i>
                <p>پرونده
                    <i class="fa fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" >
                <li class="nav-item">
                    <a href="{{route('plan.create')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد پرونده</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('plan.index')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>پرونده ها</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('plan.index')}}?my=true" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>پرونده های ارجاع شده</p>
                    </a>
                </li>
            </ul>

        </li>
        <li class="nav-item has-treeview">
            <a  href="#"
                class="nav-link {{ request()->is('panel/office') ? 'active':''   }} ">
                <i class="nav-icon fa fa-university "></i>
                <p>ادارات
                    <i class="fa fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" >
                <li class="nav-item">
                    <a href="{{route('office.create')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد اداره</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('office.index')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>لیست ادارات</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a  href="#"
                class="nav-link {{ request()->is('panel/bank') ? 'active':''   }} ">
                <i class="nav-icon fa fa-money "></i>
                <p>بانک ها
                    <i class="fa fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="{{route('bank.create')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد بانک</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('bank.index')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>لیست بانک ها</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item has-treeview">
            <a  class="nav-link" href="#"

                class="nav-link {{ request()->is('panel/users') ? 'active':''   }} ">
                <i class="nav-icon fa fa-user "></i>
                <p>کاربران
                    <i class="fa fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="{{route('users.create')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد کاربر</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>لیست کاربران</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a  href="{{route('report.index')}}"

                class="nav-link {{ request()->is('panel/report') ? 'active':''   }} ">
                <i class="nav-icon fa fa-bar-chart "></i>
                <p>گزارشات

                </p>
            </a>
        </li>
    </ul>

</nav>
