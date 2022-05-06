<template>
    <defaultField :field="field" :errors="errors" :show-help-text="true">
        <template #field>
            <div
                :style="{ height: field.height ? field.height : 'auto' }"
                class="relative"
            >
                <div
                    v-if="false"
                    class="py-6 px-8 flex justify-center items-center absolute pin z-50 bg-white"
                >
                    <loader class="text-60" />
                </div>
                <div v-if="this.field.selectAll" class="mb-2">
                    <input
                        type="checkbox"
                        id="checkbox"
                        class="checkbox"
                        v-model="selectAll"
                    />
                    <label for="checkbox">{{ this.field.messageSelectAll }}</label>
                </div>
                <Multiselect
                    ref="multiselect"
                    v-model="value"
                    mode="tags"
                    :close-on-select="false"
                    :searchable="true"
                    :create-option="false"
                    :options="this.field.options"
                />
            </div>

        </template>
    </defaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import Multiselect from '@vueform/multiselect'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field', 'maxChars'],

    components: {
        Multiselect,
    },

    data() {
        return {
            value: null,
            options: [],
        };
    },

    mounted() {
        this.field.selectedOptions.forEach((item) => {
            this.$refs.multiselect.select(item.id);
        });
    },
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
<style>
.dark .multiselect {
    background-color: rgba(var(--colors-gray-900),var(--tw-bg-opacity));
    border-color: rgba(var(--colors-gray-700),var(--tw-border-opacity));
}
.dark .multiselect-dropdown {
    background-color: rgba(var(--colors-gray-900),var(--tw-bg-opacity));
    border-color: rgba(var(--colors-gray-700),var(--tw-border-opacity));
    color: rgba(var(--colors-gray-400),var(--tw-text-opacity));
}
.dark .multiselect-tags-search {
    color: rgba(var(--colors-gray-400),var(--tw-text-opacity));
    background-color: transparent;
}
</style>
