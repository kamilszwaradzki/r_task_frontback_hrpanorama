import CodeForm from './components/CodeForm.vue'

const version = __UI_VERSION__

function install (app) {
  app.component('codeForm', CodeForm);
}

export {
  version,

  install
}
