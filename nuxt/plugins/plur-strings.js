import Vue from 'vue'

Vue.prototype.$plur = function (n, titles) {
  return titles[(n % 10 === 1 && n % 100 !== 11) ? 0 : n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? 1 : 2]
};

Vue.prototype.$plurString = {
  days: ['день', 'дня', 'дней'],
  hours: ['час', 'часа', 'часов'],
  minutes: ['минута', 'минуты' , 'минут'],
  seconds: ['секунда', 'секунды', 'секунд']
}
