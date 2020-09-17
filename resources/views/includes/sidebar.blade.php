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
                        <a class="{{ $route === 'web.people.create' ? 's-active' : ''}}"
                           href="{{route('web.people.create')}}">Создать</a>
                    </li>
                    <li class="s-submenu__item">
                        <a class="{{ $route === 'web.people.index' ? 's-active' : '' }}"
                           href="{{route('web.people.index')}}">Просмотреть</a>
                    </li>
                </ul>
            </li>
            <li class="s-vertical-list__item">
                <a type="button" href="{{route('web.groups.index')}}" class="s-vertical-list__title s-with-icon-left {{ $route === 'web.groups.index' ? 's-active' : '' }}">
                    <span class="s-icon s-left">
                         <i class="mdi mdi-group"></i>
                    </span>

                    <span class="s-vertical-list__text">Группы</span>
                </a>

            </li>
            <li class="s-vertical-list__item">
                <a type="button" href="{{route('web.courses.index')}}" class="s-vertical-list__title s-with-icon-left {{ $route === 'web.courses.index' ? 's-active' : '' }}">
                    <span class="s-icon s-left">
                         <i class="mdi mdi-book-multiple"></i>
                    </span>
                    <span class="s-vertical-list__text">Курсы</span>
                </a>
            </li>
            <li class="s-vertical-list__item">
                <a type="button" href="{{route('web.testing.index')}}" class="s-vertical-list__title s-with-icon-left {{ $route === 'web.testing.index' ? 's-active' : '' }}">
                    <span class="s-icon s-left">
                         <i class="mdi mdi-pencil-box"></i>
                    </span>
                    <span class="s-vertical-list__text">Тесты</span>
                </a>
            </li>
            <li class="s-vertical-list__item">
                <a type="button" href="{{route('web.calendar.index')}}" class="s-vertical-list__title s-with-icon-left {{ $route === 'web.calendar.index' ? 's-active' : '' }}">
                    <span class="s-icon s-left">
                         <i class="mdi mdi-calendar"></i>
                    </span>
                    <span class="s-vertical-list__text">Календарь</span>
                </a>
            </li>
            <li class="s-vertical-list__item">
                <a type="button" href="{{route('web.filemanager.index')}}" class="s-vertical-list__title s-with-icon-left {{ $route === 'web.filemanager.index' ? 's-active' : '' }}">
                    <span class="s-icon s-left">
                         <i class="mdi mdi-file-cloud"></i>
                    </span>
                    <span class="s-vertical-list__text">Файловый менеджер</span>
                </a>
            </li>
            <li class="s-vertical-list__item">
                <a type="button" href="{{route('web.courses.index')}}" class="s-vertical-list__title s-with-icon-left {{ $route === 'web.courses.index' ? 's-active' : '' }}">
                    <span class="s-icon s-left">
                         <i class="mdi mdi-chart-arc"></i>
                    </span>
                    <span class="s-vertical-list__text">Статистика</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- End content -->
    <!-- Footer -->
    <footer class="s-sidebar__footer">
        <a class="s-btn s-btn--primary" href="{{ route('logout')  }}">
            Logout
        </a>
    </footer>
    <!-- End footer -->
</aside>
