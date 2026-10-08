<script setup>
import { computed, ref } from 'vue';
import { useFusion } from 'nitro-fusion/vue';

const { title, tags, words, addTag, save, errors } = useFusion();
const tag = ref('');
const said = ref('');

/** Refs, as anything reactive in Vue: .value in the script, bare in the template. */
const tooLong = computed(() => title.value.length > 100);
const readingTime = computed(() => Math.max(1, Math.round(words.value / 200)));

function add() {
    addTag(tag.value);
    tag.value = '';
}

async function submit() {
    said.value = (await save()) ?? '';
}
</script>

<template>
    <form @submit.prevent="submit">
        <input v-model="title" :class="{ warn: tooLong }">
        <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>
        <p>{{ words }} words, about {{ readingTime }} min to read</p>

        <input v-model="tag" @keydown.enter.prevent="add">
        <span v-for="name in tags" :key="name" class="tag">{{ name }}</span>

        <button :disabled="save.processing">Save</button>
        <p>{{ said }}</p>
    </form>
</template>
