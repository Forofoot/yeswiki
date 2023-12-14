import { defaultMapping } from './commons/attributes.js'

export default {
  field: {
    label: 'Only office',
    name: 'onlyoffice',
    attrs: { type: 'onlyoffice' },
    icon: '<i class="fas fa-chalkboard"></i>'
  },
  disabledAttributes: [
    'required'
  ],
  attributesMapping: {
    ...defaultMapping,
    ...{
      1: 'DocumentType',
      2: '',
      3: '',
    }
  },
  renderInput(field) {
    return {
      field: '',
      onRender() {
      }
    }
  },
}