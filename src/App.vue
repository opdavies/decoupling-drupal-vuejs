<template>
  <div id="app" class="antialiased min-h-screen font-sans bg-gray-100 text-black p-12">
    <accepted-sessions-list :sessions="sessions" />
  </div>
</template>

<style src="./css/app.css"></style>

<script>
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
  }
}
</script>
