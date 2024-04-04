<template>
    <div class="q-pa-md" style="max-width: 400px">
        <q-form @submit="onSubmitToQR" class="q-gutter-md">
            <q-input
            filled
            v-model="code"
            label="Your code *"
            hint="Code"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Please type your Code']"
            />
            <div>
                <q-btn label="Submit" type="submit" color="primary"/>
            </div>
        </q-form>
        <q-dialog v-model="show">
            <object :data="pdf" type="application/pdf" width="500" height="700">
                <div>{{ pdf }}</div>
            </object>
        </q-dialog>
    </div>
  </template>

  <script>
  import { useQuasar } from 'quasar';
  import { ref } from 'vue';
  import axios from "axios";

  export default {
    props: ['token'],

    setup (props) {
      const $q = useQuasar();

      const code = ref(null);
      const show = ref(null);
      const pdf = ref(false);

      return {
        code,
        show,
        pdf,

        onSubmitToQR() {
            axios.post('http://localhost:8090/createPdf', new URLSearchParams({
                code: code.value
            }), { headers: { Authorization: `Bearer ${props.token}` }})
            .then( response => {
                if (response.data.message.level === 'success') {
                    $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: response.data.message.text
                    });
                    show.value = true;
                    pdf.value = response.data.pdf;
                } else {
                $q.notify({
                    color: 'red-5',
                    textColor: 'white',
                    icon: 'warning',
                    message: response.data.message.text
                });
                }
            }).catch(error => {
                console.log(error);
            });
        },
        onReset () {
            code.value = null;
            show.value = null;
            pdf.value = false;
        }
      }
    }
  }
  </script>
  