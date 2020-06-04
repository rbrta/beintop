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
     @include('parts.header')
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
                    <div class="tab">
                        Активные
                    </div>
                    <div class="tab">
                        Архивные
                    </div>
                    <div class="tab">
                        <a style="text-decoration: none; color:#FD565D; " href="/new-order">Добавить</a>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr class="table-title">
                            <th>Услуга</th>
                            <th>Акаунт</th>
                            <th>Дата окончания</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                {{ str_replace('Тарифы','Тариф',$order->service->category->name) }}<br>
                                <b>{{ $order->service->name }}</b>
                            </td>
                            <td>{{ $order->user->account_name }}</td>
                            <td>
                                <b>{{ $order->expiration_date_format }}</b><br>
                                осталось {{ $order->days }} дней
                            </td>
                            <td class="table-action">
                                <button-details order="{{ $order }}"></button-details>
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