import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-belongs-to-many-field', IndexField)
  app.component('detail-belongs-to-many-field', DetailField)
  app.component('form-belongs-to-many-field', FormField)
})
