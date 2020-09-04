<template>
  <header>
    <div class="main-menu">
      <div class="logo">
        <img alt="Be-in-top" src="/images/logo.svg">
        <span>Be-in-top</span>
      </div>

      <ul class="menu">
        <li><font-awesome-icon icon="star"/> <a href="#advantage">Наши преимущества</a></li>
        <li><font-awesome-icon icon="th"/> <a href="#tariffs">Выбрать тариф</a></li>
        <li><font-awesome-icon icon="user"/> <a href="/userpanel">Личный кабинет</a></li>
      </ul>

      <div class="mobile-menu-btn" id="menuBtn">
        <span></span>
        <span></span>
        <span></span>
      </div>

    </div>

    <div class="wrapper-mobile hide" id="menuMob">
      <div class="mobile-menu">
        <div><a class="scrollTo" data-scroll="#tariffs" href="#">Наши преимущества</a></div>
        <div><a class="scrollTo" data-scroll="#tariffs" href="#">Выбрать тариф</a></div>
        <div><a href="/userpanel">Личный кабинет</a></div>
      </div>
    </div>

  </header>
</template>

<script>
export default {
  name: 'Header'
}
</script>