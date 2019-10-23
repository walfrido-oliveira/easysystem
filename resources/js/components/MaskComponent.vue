<template>
    <the-mask :mask="mask" :value="value" type="text" masked="true"
        :placeholder="placeholder" class="form-control" :name="name" :id="id"></the-mask>
</template>

<script>
    import {TheMask} from 'vue-the-mask'

    export default {
        components : {TheMask},
        props : ['name','id','mask','value','placeholder']
    }
</script>
