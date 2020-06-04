<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/clientpage.css') }}">
</head>
<body>
     <!-- ------------------------------------------------------------------------------- -->    
     <header >
        <div class="wrapper">
            <div class="logo">
                <img src="/images/logo.svg" alt="">
                <span>Be-in-top</span>
            </div>
            <ul class="menu">
                <li><i class="fas fa-star"></i> <a href="#">Наши преимущества</a></li>
                <li><i class="fas fa-th"></i> <a href="#">Выбрать тариф</a></li>
                <li><i class="fas fa-home"></i> <a href="/">На главную</a></li>
                <li><i class="fas fa-user"></i> <a href="/client">Личный кабинет</a></li>
            </ul>

            <div id="menuBtn" class="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div id="menuMob" class="wrapper-mobile hide">
            <div class="mobile-menu">
                <div><a href="#">На главную</a></div>
                <div><a href="#">Личный кабинет</a></div>
                <div><a href="#">Наши преимущества</a></div>
                <div><a href="#">Выбрать тариф</a></div>
            </div>
        </div>
    </header>
   
    
    <!-- ------------------------------------------------------------------------------- -->    
    
   
    <div class="main-block">
    <div class="main-arrow">
      <img src=".//assets/images/background-client1.png" alt="">
    </div>
    <div class="container-top">        
        <div class="wrapper-content">
            <div class="row1">
                <b>Аккаунт:</b> {{ $user->email }}
            </div>
            <div class="row2">
                <a href="/logout">Сменить аккаунт</a>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------- -->    
    <div id="app" class="container-table">
        <div class="wrapper-content">
            <div class="wrapper-table">
                <div class="tabs">
                    <div class="tab" style="z-index: -300">
                        <a style="text-decoration: none; color:#FD565D; " href="/client">Активные</a>
                    </div>
                    <div class="tab">
                        Архивные
                    </div>
                    <div class="tab" style="z-index: -150">
                        Добавить
                    </div>
                </div>
                <table>
                    <thead>
                        <tr class="table-title">
                            <th>Услуга</th>
                            <th>Цена</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @foreach ($services as $service)
                    <tr>
                        <td>
                            {{ str_replace('Тарифы','Тариф',$service->category->name) }} <br>
                            <b>{{ $service->name }}</b>
                        </td>
                        <td>
                            <b>{{ $service->price }}</b>
                        </td>
                        <td class="table-action">
                            <button-activation user="{{ $user }}" service="{{ $service }}"></button-activation>
                        </td>
                    </tr>
                    @endforeach 
                 
                </table>
            </div>
        </div>
    </div>
    </div>
    <footer>
        <a href="#">
            <img src="./assets/images/contacts1.svg" alt="">be_in_top@gmail.com</a>
        <a href="#">
            <img src="./assets/images/contacts2.svg" alt="">be_in_top
        </a>
    </footer>
    <!-- ------------------------------------------------------------------------------- -->  
    <script src="/js/main.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>