<!-- resources/views/vue/post-editor.vue -->
<script setup>
import TagList from '../../js/components/TagList.vue';
</script>

<template>
    <TagList />
</template>

<!-- resources/js/components/TagList.vue: an ordinary Vue component, inside the view -->
<script setup>
import { useFusion } from 'nitro-fusion/vue';

const { tags, removeTag } = useFusion();
</script>

<template>
    <ul>
        <li v-for="(tag, index) in tags" :key="tag">{{ tag }} <button @click="removeTag(index)">×</button></li>
    </ul>
</template>
