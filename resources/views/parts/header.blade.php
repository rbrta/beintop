<header>
    <div class="main-menu">
        <div class="logo">
            <img src="/images/logo.svg" alt="">
            <span>Be-in-top</span>
        </div>
        <ul class="menu">

            @if(isset($type) && $type == 'panel')

                <li><i class="fas fa-home"></i> <a href="/">На главную</a></li>

                @if(auth()->user()->usertype == 'user')
                    <li><i class="fas fa-list"></i> <a href="/userpanel">Услуги</a></li>
                @elseif(auth()->user()->usertype == 'manager')

                    <li><i class="fas fa-list"></i> <a href="/manager/">Услуги</a></li>
                    <li><i class="fas fa-user-secret"></i> <a href="/manager/clients">Клиенты</a></li>

                @elseif(auth()->user()->usertype == 'admin')
                    <li><i class="fas fa-list"></i> <a href="/admin">Редактор услуг</a></li>
                    <li><i class="fas fa-user-secret"></i> <a href="/admin/managers">Менеджеры</a></li>
                @endif

                <li><i class="fas fa-user"></i> <a href="/userpanel/profile">Профиль</a></li>
                <li><i class="fas fa-sign-out-alt"></i> <a href="/logout">Выход</a></li>
                
                

            @elseif(isset($type) && $type == 'auth')
                <li><i class="fas fa-home"></i> <a href="/">На главную</a></li>
                <li><i class="fas fa-user"></i> <a href="/userpanel">Личный кабинет</a></li>

 
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
            

            @if(isset($type) && $type == 'panel')

                <div><a href="/">На главную</a></div>

                @if(auth()->user()->usertype == 'user')
                    <div><a href="/userpanel">Услуги</a></div>

                @elseif(auth()->user()->usertype == 'manager')
                    <div><a href="/manager">Услуги</a></div>
                    <div><a href="/manager/clients">Клиенты</a></div>

                @elseif(auth()->user()->usertype == 'admin')
                    <div><a href="/admin">Редактор услуг</a></div>
                    <div><a href="/admin/managers">Менеджеры</a></div>

                @endif

                <div><a href="/userpanel/profile">Профиль</a></div>
                <div><a href="/logout">Выход</a></div>
                
                
                

            @elseif(isset($type) && $type == 'auth')
                <div><a href="/userpanel">Личный кабинет</a></div>
                <div><a href="/">На главную</a></div>

            @else
                <div><a href="#" class="scrollTo" data-scroll="#tariffs">Наши преимущества</a></div>
                <div><a href="#" class="scrollTo" data-scroll="#tariffs">Выбрать тариф</a></div>
                <div><a href="/userpanel">Личный кабинет</a></div>
            @endif
        </div>
    </div>

</header>