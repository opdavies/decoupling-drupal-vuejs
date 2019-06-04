<template>
  <section class="mt-8">
    <h3 class="text-2xl font-semibold mb-4">Submit a Session</h3>

    <div v-if="errors.length" class="bg-red-100 border border-red-300 p-4 mb-6">
      <ul class="list-disc list-inside ml-3">
        <li v-for="error, i in errors" :key="i">{{ error.detail }}</li>
      </ul>
    </div>

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
      errors: [],
      form: {
        body: '',
        field_session_status: 'accepted',
        field_session_type: 'full',
        title: ''
      }
    }
  },

  methods: {
    submit () {
      const uuid = '11dad4c2-baa8-4fb2-97c6-12e1ce925806' // User 1

      const data = {
        type: 'node--session',
        attributes: this.form,
        relationships: {
          "field_speakers": {
            "data": {
              "type": "user--user",
              "id": uuid
            }
          },
        }
      }

      const baseUrl = 'http://drupaltestcamp.docksal';

      axios({
        method: 'post',
        url: `${baseUrl}/jsonapi/node/session`,
        data: { data },
        headers: {
          'Accept': 'application/vnd.api+json',
          'Content-Type': 'application/vnd.api+json',
        }
      })
        .then(({ data }) => {
          this.form.body = ''
          this.form.title = ''
        .catch(error => {
          this.errors = error.response.data.errors || []
        })
    }
  }
}
</script>
