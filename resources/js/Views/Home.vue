<template>
  <div>

    <div>
      <dl>
        <dt>Sender</dt>
        <dd>
          <input v-model="filter.sender" @keydown.enter="fetchMails()" type="text">
        </dd>
        <dt>Recipient</dt>
        <dd>
          <input v-model="filter.recipient" @keydown.enter="fetchMails()" type="text">
        </dd>
        <dt>Subject</dt>
        <dd>
          <input v-model="filter.subject" @keydown.enter="fetchMails()" type="text">
        </dd>
        <dt>Status</dt>
        <dd>
          <select v-model="filter.status" @keydown.enter="fetchMails()">
            <option value="0">All</option>
            <option value="1">Posted</option>
            <option value="2">Sent</option>
            <option value="3">Failed</option>
          </select>
        </dd>
      </dl>
      <button @click="fetchMails()">Search</button>
    </div>

    <div>

      <template v-if="mails.length > 0">
        <table>
          <tr>
            <th>To</th>
            <th>From</th>
            <th>Subject</th>
            <th>Status</th>
            <th></th>
          </tr>

          <tr v-for="mail in mails">
            <td>
              {{ mail.recipient }}
            </td>
            <td>
              {{ mail.sender }}
            </td>
            <td>
              {{ mail.subject }}
            </td>
            <td>
              {{ mail.status.label }}
            </td>
            <td>
              <router-link :to="{ name: 'mail', params: { id: mail.id } }">View</router-link>
            </td>
          </tr>

        </table>
      </template>

      <template v-else>
        NO DATA FOUND.
      </template>

    </div>

    <div v-if="links">
      <button v-if="links.prev" @click="fetchMails(links.prev)">Previous</button>
      <button v-if="links.next" @click="fetchMails(links.next)">Next</button>
    </div>

  </div>
</template>

<script>
export default {
  name: "Home",
  data: () => ({
    mails: [],
    links: null,
    meta: null,
    filter: {
      sender: null,
      recipient: null,
      subject: null,
      status: 0
    }
  }),
  mounted() {
    this.fetchMails()
  },
  methods: {
    fetchMails(link) {
      axios.get(link || '/mails', { params : this.filter })
          .then(response => {
            response = response.data
            this.mails = response.data
            this.links = response.links
            this.meta = response.meta
          })
    }
  }
}
</script>

<style scoped>

input, select, button, table, td, tr, th {
  border: 1px black solid;
}

</style>