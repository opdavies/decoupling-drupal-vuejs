<template>
  <div class="max-w-5xl mx-auto">
    <h1 class="text-4xl font-semibold mb-2">Sessions</h1>

    <div v-if="!sessions.length == 0" class="bg-white p-6 rounded-lg border">
      <ul class="-mb-3">
        <li v-for="session in sessions" :key="session.attributes.drupal_internal__nid" class="mb-3">
          {{ session.attributes.title }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    sessions: {
      type: Array,
      required: true
    }
  }
}
</script>
