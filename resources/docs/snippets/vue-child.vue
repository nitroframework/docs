<!-- resources/views/vue/post-editor.vue -->
<script setup>
import TagList from '../../js/components/TagList.vue';
</script>

<template>
    <TagList />
</template>

<!-- resources/js/components/TagList.vue: an ordinary Vue component, inside the view -->
<script setup>
import { useNitro } from 'nitro/vue';

const { tags, removeTag } = useNitro();
</script>

<template>
    <ul>
        <li v-for="(tag, index) in tags" :key="tag">{{ tag }} <button @click="removeTag(index)">×</button></li>
    </ul>
</template>
