<template>
    <money v-model="value" v-bind="money" :value="value" :placeholder="placeholder" class="form-control" :name="name" :id="id"></money>
</template>

<script>
  import {Money} from 'v-money'

  export default {
    components: {Money},
    props : ['name','id','mask','value','placeholder'],

    data () {
      return {
        money: {
          decimal: ',',
          thousands: '.',
          prefix: '',
          suffix: '',
          precision: 2,
          masked: true
        }
      }
    }
  }
</script>
