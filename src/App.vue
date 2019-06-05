<template>
  <div id="app" class="antialiased min-h-screen font-sans bg-gray-100 text-black p-12">
    <div class="w-full max-w-2xl mx-auto">
      <accepted-sessions-list :sessions="sortedSessions" />
      <session-form @submitted="addSession($event)"></session-form>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'
import AcceptedSessionsList from '@/components/AcceptedSessionsList'
import SessionForm from '@/components/SessionForm'

const axios = require('axios')

export default {
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

    axios.get(`${baseUrl}/jsonapi/node/session`)
      .then(({ data }) => {
        this.loaded = true
        this.sessions = data.data
      })
  },

  methods: {
    addSession: function (session) {
      this.sessions.push(session)
    }
  },

  computed: {
    sortedSessions: function () {
      return _(this.sessions).sortBy(({ attributes }) => attributes.title)
    }
  }
}
</script>

<style type="postcss">
@tailwind base;

@tailwind components;

@tailwind utilities;
</style>
