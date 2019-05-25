<template>
  <div id="app" class="antialiased min-h-screen font-sans bg-gray-100 text-black p-12">
    <div class="w-full max-w-2xl mx-auto">
      <accepted-sessions-list :sessions="sortedSessions" />
    </div>
  </div>
</template>

<style src="./css/app.css"></style>

<script>
import _ from 'lodash'
import AcceptedSessionsList from '@/components/AcceptedSessionsList'

const axios = require('axios')

export default {
  components: {
    AcceptedSessionsList
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
      return _(this.sessions).sortBy(session => {
        return session.attributes.title
      })
    }
  }
}
</script>
