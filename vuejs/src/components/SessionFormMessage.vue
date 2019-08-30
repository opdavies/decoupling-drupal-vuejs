<template>
  <div v-if="messages.length" class="mb-6 p-4 border">
    <ul class="ml-3 list-disc list-inside">
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
