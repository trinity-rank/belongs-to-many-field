<template>
    <div
        class="flex flex-col md:flex-row -mx-6 px-6 py-2 md:py-0 space-y-2 md:space-y-0"
        :class="{ 'border-t border-gray-100 dark:border-gray-700': index !== 0 }"
        :dusk="field.attribute"
    >
        <div class="md:w-1/4 md:py-3">
            <slot>
                <h4 class="font-bold md:font-normal">
                    <span>{{ this.field.name }}</span>
                </h4>
            </slot>
        </div>
        <div class="md:w-3/4 md:py-3 break-words">
            <slot name="value">
                <a v-for="(val,key,) in field.selectedOptions" @click.stop :href="'../'+field.relationResourceName+'/'+val.id+'/edit'" class="font-bold">
                    {{ val.value }}<span v-if="key != field.selectedOptions.length - 1">, </span>
                </a>
            </slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>
