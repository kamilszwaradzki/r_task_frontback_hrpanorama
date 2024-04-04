<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width: 400px">
      <q-form v-if="token == null"
        @submit="onSubmit"
        @reset="onReset"
        class="q-gutter-md"
      >
        <q-input
          filled
          v-model="login"
          label="Your login *"
          hint="Login"
          lazy-rules
          :rules="[ val => val && val.length > 0 || 'Please type your login']"
        />
        <q-input
          filled
          type="password"
          v-model="password"
          label="Your password"
          lazy-rules
          :rules="[
            val => val !== null && val !== '' || 'Please type your password',
          ]"
        />
        <div>
          <q-btn label="Submit" type="submit" color="primary"/>
          <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
        </div>
      </q-form>
      <codeForm :token="token" />
    </div>
  </q-page>
</template>

<script>
import { ref } from 'vue';
import { md5 } from 'js-md5';

export default {
  setup () {

    const login = ref(null);
    const password = ref(null);
    const token = ref(null);

    return {
      login,
      password,
      token,

      onSubmit () {
        token.value = md5(login + password);
      },

      onReset () {
        login.value = null;
        password.value = null;
      },
    }
  }
}
</script>

<style lang="sass" scoped>
.directive-target
  width: 50px
  height: 50px
</style>
