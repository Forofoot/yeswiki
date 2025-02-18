export default {
  props: ['wikiCode', 'height'],
  computed: {
    previewIframeUrl() {
      if (!this.wikiCode || this.wikiCode.includes('onlyoffice="true"')) return ''
      // if (!this.wikiCode) return ''
      if (this.wikiCode.indexOf('wiki/render') > -1) {
        return this.wikiCode
      }
      const result = wiki.url('wiki/render', { content: this.wikiCode })
      return result
    }
  },
  template: `
    <div class="widget-iframe-container" v-if="height != '0'">
      <h3>${wiki.lang.ACTION_BUILDER_PREVIEW}</h3>
      <iframe class="iframe-preview" width="100%" :height="height || '350px'" frameborder="0" :src="previewIframeUrl"></iframe>
      <div class="iframe-blocker"></div>
    </div>
  `
}
