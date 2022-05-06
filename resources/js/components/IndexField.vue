<template>
    <a v-for="(val,key,) in field.selectedOptions" @click.stop :href="field.relationResourceName+'/'+val.id+'/edit'" class="font-bold">
        {{ val.value }}<span v-if="key != field.selectedOptions.length - 1">, </span>
    </a>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
