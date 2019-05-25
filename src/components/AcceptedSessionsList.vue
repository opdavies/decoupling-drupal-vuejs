<template>
  <div>
    <h1 class="text-4xl font-semibold mb-2">Sessions</h1>

    <div v-if="!acceptedSessions.length == 0" class="bg-white p-6 rounded-lg border">
      <ul class="-mb-3">
        <li v-for="{ attributes } in acceptedSessions" :key="attributes.drupal_internal__nid" class="mb-3">
          {{ attributes.title }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    sessions: {
      type: Object,
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
