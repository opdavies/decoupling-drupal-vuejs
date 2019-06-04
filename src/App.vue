<template>
  <div id="app" class="antialiased min-h-screen font-sans bg-gray-100 text-black p-12">
    <div class="w-full max-w-2xl mx-auto">
      <accepted-sessions-list :sessions="sortedSessions" />
      <session-form></session-form>
    </div>
  </div>
</template>

<style src="./css/app.css"></style>

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
    const baseUrl = 'http://drupaltestcamp.docksal'

    axios.get(`${baseUrl}/jsonapi/node/session`)
      .then(({ data }) => {
        this.loaded = true
        this.sessions = data.data
      })
  },

  computed: {
    sortedSessions: function () {
      return _(this.sessions).sortBy(session => session.attributes.title)
    }
  }
}
</script>
