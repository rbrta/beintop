<template>
  <div class="login">
    <div class="wrapper">
      <client-only>
        <countdown :time="countdownTo" :interval="1000">
          <template slot-scope="props">

            <div class="expires">
              <div class="expires__label">Осталось</div>
              <div class="expires__days_count">{{ props.days }}</div>
              <div class="expires__days">{{ $plur(props.days, $plurString.days)}}</div>

              <div class="expires__timer">
                <div class="value">{{ props.hours }} <span>{{ $plur(props.hours, $plurString.hours) }} </span></div>
                <div class="delimeter">:</div>
                <div class="value">{{ props.minutes }} <span>{{ $plur(props.minutes, $plurString.minutes) }}</span></div>
                <div class="delimeter">:</div>
                <div class="value">{{ props.seconds }} <span>{{ $plur(props.seconds, $plurString.seconds) }}</span></div>
              </div>
            </div>
          </template>
        </countdown>
      </client-only>
      <hr>
      <client-only>
        <countdown :time="countdownTo" :interval="1000">
          <template slot-scope="props">
            {{ props.days }} {{ $plur(props.days, $plurString.days)}},
            {{ props.hours }} {{ $plur(props.hours, $plurString.hours) }},
            {{ props.minutes }} {{ $plur(props.minutes, $plurString.minutes) }},
            {{ props.seconds }} {{ $plur(props.seconds, $plurString.seconds) }}
          </template>
        </countdown>
      </client-only>
      <div id="exp-date"></div>
      <div id="now-date"></div>
      <div id="diff"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TestPage",

  computed: {
    countdownTo() {
      let expDate = new Date('09-24-2020 18:00:00').getTime();
      let nowDate = new Date().getTime();
      const diff = Math.abs(nowDate - expDate);

      if(process.client) {
        document.getElementById('exp-date').innerText = expDate;
        document.getElementById('now-date').innerText = nowDate;
        document.getElementById('diff').innerText = diff;
      }

      return diff
    }
  }
}
</script>
