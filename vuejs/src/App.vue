<template>
  <div id="app" class="antialiased min-h-screen font-sans bg-gray-100 text-black p-12">
    <div class="w-full max-w-2xl mx-auto">
      <accepted-sessions-list :sessions="sessions" />
      <session-form @submitted="addSession($event)" />
    </div>
  </div>
</template>

<script>
import AcceptedSessionsList from '@/components/AcceptedSessionsList'
import qs from 'qs'
import saveState from 'vue-save-state'
import SessionForm from '@/components/SessionForm'

const axios = require('axios')

export default {
  mixins: [saveState],

  components: {
    AcceptedSessionsList,
    SessionForm
  },

  data () {
    return {
      loaded: false,
      sessions: []
    }
  },

  mounted () {
    const baseUrl = process.env.VUE_APP_DRUPAL_URL

    const params = qs.stringify({
      'fields[node--session]': 'title',
      'filter[field_session_status]': 'accepted'
    })

    axios.get(`${baseUrl}/jsonapi/node/session?${params}`)
      .then(({ data }) => {
        this.loaded = true
        this.sessions = data.data
      })
  },

  methods: {
    addSession (session) {
      this.sessions.push(session)
    },

    getSaveStateConfig () {
      return {
        cacheKey: 'app'
      }
    }
  }
}
</script>

<style src="./assets/css/tailwind.css"></style>
