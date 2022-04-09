<template>
  <div class="clock"></div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.clock {
  position: absolute;
  top: 580px;
  right: 0;
  background: url(/images/clock.svg) no-repeat 0 0 / contain;
  width: 35%;
  height: 600px;
  z-index: -1;
}
</style>
