<template>
  <div>
    <h1 class="text-4xl mb-2">Sessions</h1>

    <div v-if="sessions.length" class="bg-white p-6 rounded-lg border">
      <ul class="-mb-3">
        <li v-for="{ attributes } in sortedSessions" :key="attributes.drupal_internal__nid" class="mb-3">
          {{ attributes.title }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import sortBy from 'lodash/sortBy'

export default {
  props: {
    sessions: {
      type: Array,
      required: true
    }
  },

  computed: {
    sortedSessions: function () {
      return sortBy(this.sessions, 'attributes.title')
    }
  }
}
</script>
