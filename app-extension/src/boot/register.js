import { boot } from 'quasar/wrappers'
import VuePlugin from 'quasar-ui-r_task_frontback_hrpanorama'

export default boot(({ app }) => {
  app.use(VuePlugin)
})
