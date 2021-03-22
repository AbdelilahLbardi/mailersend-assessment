<template>
  <div>
    <template v-if="!fullScreen && this.mail">
      <router-link :to="{name: 'home'}">Go back home</router-link>
      <div>
        <h1>Details</h1>
        <dl>
          <dt>Sender</dt>
          <dd>{{ this.mail.sender }}</dd>
          <dt>Recipient</dt>
          <dd>{{ this.mail.recipient }}</dd>
          <dt>Subject</dt>
          <dd>{{ this.mail.subject }}</dd>
          <dt>Current Status</dt>
          <dd>{{ this.mail.status.label }}</dd>
        </dl>
      </div>
      <div v-if="this.mail.attachments.length">
        <h1>Attachments</h1>
        <ul>
          <li v-for="attachment in this.mail.attachments">
            <a :href="attachment.url" v-text="attachment.name" target="_blank"></a>
          </li>
        </ul>
      </div>
      <div>
        <h1>Text Content</h1>
        <div>
          {{ this.mail.text_content }}
        </div>
      </div>
      <div class="html-container">
        <h1>HTML Content</h1>
        <div v-html="this.mail.html_content" class="mail-html-content">
        </div>
        <button @click="toggleHtmlFullScreen">view in full screen</button>
      </div>
    </template>

    <template v-else-if="this.mail">
      <div class="html-full-screen">
        <div v-html="this.mail.html_content">

        </div>
        <button @click="toggleHtmlFullScreen">Exit full screen</button>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: "Mail",
  data: () => ({
    mail: null,
    fullScreen: false
  }),
  mounted() {
    this.fetchMail()
  },
  methods: {
    fetchMail() {
      axios.get(`/mails/${this.$route.params.id}`)
          .then(response => this.mail = response.data.data)
    },

    toggleHtmlFullScreen() {
      this.fullScreen = !this.fullScreen
    }
  }
}
</script>

<style scoped>

.mail-html-content {
  width: 500px;
  height: 500px;
  overflow: scroll;
  border: 1px black solid;
}

.html-container {
  padding-bottom: 200px;
}

.html-full-screen {
  width: 100vw;
  height: 100vh;
  position: absolute;
  top: 0;
  left: 0;
  margin: 0 auto;
}

</style>