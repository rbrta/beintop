<header>
    <div class="main-menu">
        <div class="logo">
            <img src="/images/logo.svg" alt="">
            <span>Be-in-top</span>
        </div>
        <ul class="menu">
            @if(isset($type) && $type == 'userpanel')
                <li><i class="fas fa-home"></i> <a href="/">На главную</a></li>
                <li><i class="fas fa-list"></i> <a href="/userpanel">Услуги</a></li>
                <li><i class="fas fa-user"></i> <a href="/userpanel/profile">Профиль</a></li>
                <li><i class="fas fa-sign-out-alt"></i> <a href="/logout">Выход</a></li>

            @elseif(isset($type) && $type == 'auth')
                <li><i class="fas fa-home"></i> <a href="/">На главную</a></li>
                <li><i class="fas fa-user"></i> <a href="/userpanel">Личный кабинет</a></li>

            @elseif(isset($type) && $type == 'adminpanel')
                <li><i class="fas fa-home"></i> <a href="/">На главную</a></li>
                <li><i class="fas fa-list"></i> <a href="/admin">Редактор услуг</a></li>
                <li><i class="fas fa-sign-out-alt"></i> <a href="/logout">Выход</a></li>
            @else
                <li><i class="fas fa-star"></i> <a class="scrollTo" data-scroll="#advantage" href="#">Наши преимущества</a></li>
                <li><i class="fas fa-th"></i> <a class="scrollTo" data-scroll="#tariffs" href="#">Выбрать тариф</a></li>
                <li><i class="fas fa-user"></i> <a href="/userpanel">Личный кабинет</a></li>
            @endif

        </ul>

        <div id="menuBtn" class="mobile-menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </div>

    <div id="menuMob" class="wrapper-mobile hide">
        <div class="mobile-menu">
            

            @if(isset($type) && $type == 'userpanel')
                <div><a href="/">На главную</a></div>
                <div><a href="/userpanel">Услуги</a></div>
                <div><a href="/userpanel/profile">Профиль</a></div>
                <div><a href="/logout">Выход</a></div>

            @elseif(isset($type) && $type == 'auth')
                <div><a href="/userpanel">Личный кабинет</a></div>
                <div><a href="/">На главную</a></div>

            @elseif(isset($type) && $type == 'adminpanel')
                <div><a href="/">На главную</a></div>
                <div><a href="/admin">Редактор услуг</a></div>
                <div><a href="/logout">Выход</a></div>
            @else
                <div><a href="#" class="scrollTo" data-scroll="#tariffs">Наши преимущества</a></div>
                <div><a href="#" class="scrollTo" data-scroll="#tariffs">Выбрать тариф</a></div>
                <div><a href="/userpanel">Личный кабинет</a></div>
            @endif
        </div>
    </div>

</header>