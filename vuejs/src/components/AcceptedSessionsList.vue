<template>
  <div>
    <h1 class="text-4xl">Sessions</h1>

    <div v-if="sessions.length" class="mt-2 p-6 bg-white rounded-lg border">
      <ul>
        <li v-for="{ attributes } in sortedSessions" :key="attributes.drupal_internal__nid" class="mt-3 first:mt-0">
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
