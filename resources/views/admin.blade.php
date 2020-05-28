<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/backendpage.css') }}">
</head>
<body>
<div id="app" >
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
                <li><i class="fas fa-home"></i> <a href="#">На главную</a></li>
                <li><i class="fas fa-user"></i> <a href="#">Личный кабинет</a></li>
            </ul>

            <div id="menuBtn" class="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>
    <!-- ------------------------------------------------------------------------------- --> 
    <div class="container-table">
        <div class="wrapper-content">
            <div class="wrapper-table">
                <div class="tab">
                    Тарифы
                </div>
                <table>
                    <thead>
                        <tr class="table-title">
                            <td>Название</td>
                            <td>Период</td>
                            <td>Стоимость</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    @foreach($services as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->periodindays }} дней</td>
                            <td>{{ $item->price }} руб</td>
                            <td class="table-action">
                                <a class="btn" href="#">Изменить</a>
                                <a class="btn" href="#">Удалить</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="add-btn">
                    <a @click.prevent="addService" class="btn" href="#">Добавить</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------------- -->  
<!-- ------------------------------------------------------------------------------- -->  
<script src="/js/main.js"></script>
<script src="/js/app.js"></script>
</body>
</html>