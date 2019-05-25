<template>
  <div class="max-w-5xl mx-auto">
    <h1 class="text-4xl font-semibold mb-2">Sessions</h1>

    <div v-if="!acceptedSessions.length == 0" class="bg-white p-6 rounded-lg border">
      <ul class="-mb-3">
        <li v-for="session in acceptedSessions" :key="session.attributes.drupal_internal__nid" class="mb-3">
          {{ session.attributes.title }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'

export default {
  props: {
    sessions: {
      type: Array,
      required: true
    }
  },

  computed: {
    acceptedSessions: function () {
      return this.sessions.filter(session => {
        return session.attributes.field_session_status === 'accepted'
      }).value()
    }
  }
}
</script>
