<aside class="s-sidebar">
    <!--Sidebar header -->
    <header class="s-sidebar__header">
        <div class="burger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>
    <!-- End sidebar header -->
    <!-- Content -->
    <div class="s-sidebar__content">
        <ul class="s-sidebar__drop-menu s-vertical-list">

            @php
                $route = Route::currentRouteName();
            @endphp

            <li class="s-vertical-list__heading">Меню</li>
            <li class="s-vertical-list__item">
                <a type="button" class="s-vertical-list__title s-trigger s-with-icon-double">
                    <span class="s-icon s-left">
                        <i class="mdi mdi-account-group"></i>
                    </span>
                    <span class="s-vertical-list__text">Студенты</span>
                    <span class="s-icon s-right">
                        <i class="mdi mdi-chevron-up"></i>
                    </span>
                </a>
                <ul class="s-submenu">
                    <li class="s-submenu__item">
                        <a class="{{ $route === 'add_people' ? 's-active' : ''}}"
                           href="{{route('add_people')}}">Создать</a>
                    </li>
                    <li class="s-submenu__item">
                        <a class="{{ $route === 'show_people' ? 's-active' : '' }}"
                           href="{{route('show_people')}}">Просмотреть</a>
                    </li>
                </ul>
            </li>
            <li class="s-vertical-list__item">
                <a type="button" class="s-vertical-list__title s-with-icon-left">
                    <span class="s-icon s-left">
                         <i class="mdi mdi-group"></i>
                    </span>

                    <span class="s-vertical-list__text">Группы</span>
                </a>

            </li>
            <li class="s-vertical-list__item">
                <a type="button" class="s-vertical-list__title s-trigger s-with-icon-double">
                    <span class="s-icon s-left">
                         <i class="mdi mdi-book-multiple"></i>
                    </span>
                    <span class="s-vertical-list__text">Курсы</span>
                    <span class="s-icon s-right">
                         <i class="mdi mdi-chevron-up"></i>
                    </span>
                </a>

                <ul class="s-submenu">
                    <li class="s-submenu__item"><a href="">Создать</a></li>
                    <li class="s-submenu__item"><a href="">Просмотреть</a></li>
                </ul>
            </li>


        </ul>
    </div>
    <!-- End content -->
    <!-- Footer -->
    <footer class="s-sidebar__footer">
        <a class="s-btn s-btn--primary">
            Logout
        </a>
    </footer>
    <!-- End footer -->
</aside>
