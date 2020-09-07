<template>
  <div></div>
</template>

<script>
export default {
  name: "LoginCode",
  auth: 'guest',

  async asyncData({ params, $auth, error, redirect }) {
    try {
      await $auth.loginWith('local', { data: { code: params.code } })
      redirect('/userpanel');
    } catch (err) {
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {

    };
  },
}
</script>
