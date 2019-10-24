<template>
  <vue-numeric currency=""  decimal-separator="," separator="." v-model="currentValue" class="form-control"
       :precision="currentPrecision" output-type="text" :max="currentMax" :min="currentMin"></vue-numeric>
</template>

<script>
import VueNumeric from 'vue-numeric'

export default {
  name: 'App',

  components: {VueNumeric},

  props : ['value','precision','max','min'],

  computed: {
      valueProp: {
        get() {return this.currentValue},
        set(val) {
            this.value = val;
            this.$emit('vue-numeric', this.currentValue);
        }
      },
      precisionProp: {
        get() {return this.currentPrecision},
        set(val) {
            this.currentPrecision = val;
            his.$emit('vue-numeric', this.currentPrecision);
        }
      },
      maxProp: {
        get() {return this.currentMax},
        set(val) {
            this.currentMax = val;
            his.$emit('vue-numeric', this.currentMax);
        }
      },
      minProp: {
        get() {return this.currentMin},
        set(val) {
            this.currentMin = val;
            his.$emit('vue-numeric', this.currentMin);
        }
      },
  },

  data() {
      return {
          price: '',
          currentValue: this.value,
          currentPrecision: this.precision,
          currentMax: this.max,
          currentMin: this.min,
      };
  },
}
</script>
