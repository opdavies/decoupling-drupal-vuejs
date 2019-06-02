<template>
  <section class="mt-8">
    <h3 class="text-2xl font-semibold mb-4">Submit a Session</h3>

    <form action="" @submit.prevent="submit">
      <label class="block mb-4">
        Title
        <input name="title" type="text" class="w-full border border-gray-400 p-2 mt-1" v-model="form.title" required/>
      </label>

      <label class="block mb-4">
        Abstract
        <textarea name="title" rows="5" class="w-full border border-gray-400 p-2 mt-1" v-model="form.body" required/>
      </label>

      <input class="cursor-pointer bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 text-gray-100 px-4 py-2 rounded" type="submit" value="Submit session">
    </form>
  </section>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      form: {
        body: '',
        title: '',
        field_session_status: 'accepted'
      }
    }
  },

  methods: {
    submit () {
    }
  }
}
</script>
