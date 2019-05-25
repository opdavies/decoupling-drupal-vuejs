<template>
  <div id="app" class="antialiased min-h-screen font-sans bg-gray-100 text-black p-12">
    <div class="max-w-5xl mx-auto">
      <h1 class="text-4xl font-semibold mb-2">Sessions</h1>

      <div v-if="sessions" class="bg-white p-6 rounded-lg border">
        <ul class="-mb-3">
          <li v-for="session in sessions" :key="session.attributes.drupal_internal__nid" class="mb-3">
            {{ session.attributes.title }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<style src="./css/app.css"></style>

<script>
const axios = require('axios')

module.exports = {
  data () {
    return {
      sessions: []
    }
  },

  created () {
    const baseUrl = 'http://drupaltestcamp.docksal'

    axios.get(`${baseUrl}/jsonapi/node/session`)
      .then(({ data }) => {
        this.sessions = data.data
      })
  }
}
</script>
