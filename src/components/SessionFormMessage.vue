<template>
  <div v-if="messages.length" class="border p-4 mb-6">
    <ul class="list-disc list-inside ml-3">
      <li v-for="message in messages" :key="message">{{ message }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    messages: {
      type: Array,
      required: true,
      default: () => []
    }
  }
}
</script>
