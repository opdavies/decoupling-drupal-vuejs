<template>
  <section class="mt-8">
    <h2 class="text-2xl mb-4">Submit a Session</h2>

    <SessionFormMessage :messages="messages" class="bg-green-100 border-green-300"/>
    <SessionFormMessage :messages="errors" class="bg-red-100 border-red-300"/>

    <form action="" @submit.prevent="submit">
      <label class="block mb-4">
        Title
        <input name="title" type="text" v-model="form.title" required/>
      </label>

      <label class="block mb-4">
        Abstract
        <textarea name="title" rows="5" v-model="form.body" required/>
      </label>

      <input class="cursor-pointer bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 text-gray-100 px-4 py-2 rounded" type="submit" value="Submit session">
    </form>
  </section>
</template>

<script>
import axios from 'axios'
import map from 'lodash/map'
import SessionFormMessage from '@/components/SessionFormMessage'

export default {
  components: {
    SessionFormMessage
  },

  data () {
    return {
      errors: [],
      form: {
        body: '',
        field_session_status: 'submitted',
        field_session_type: 'full',
        title: ''
      },
      messages: []
    }
  },

  methods: {
    submit () {
      const adminUuid = '11dad4c2-baa8-4fb2-97c6-12e1ce925806'
      const apiUuid = '63936126-87cd-4166-9cb4-63b61a210632'

      const data = {
        type: 'node--session',
        attributes: this.form,
        relationships: {
          'field_speakers': {
            'data': {
              'id': adminUuid,
              'type': 'user--user'
            }
          },
          'uid': {
            'data': {
              'id': apiUuid,
              'type': 'user--user'
            }
          }
        }
      }

      const baseUrl = process.env.VUE_APP_DRUPAL_URL

      axios({
        method: 'post',
        url: `${baseUrl}/jsonapi/node/session`,
        data: { data },
        headers: {
          'Accept': 'application/vnd.api+json',
          'Authorization': 'Basic YXBpOmFwaQ==',
          'Content-Type': 'application/vnd.api+json'
        }
      }).then(({ data }) => {
        this.errors = []
        this.messages = []

        const title = data.data.attributes.title
        this.messages.push(`Session ${title} has been created.`)

        this.form.body = ''
        this.form.title = ''
      }).catch(({ response: { data } }) => {
        this.errors = map(data.errors, 'detail')
      })
    }
  }
}
</script>
