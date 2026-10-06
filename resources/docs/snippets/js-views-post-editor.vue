<script setup>
import { ref } from 'vue';
import { useFusion } from 'nitro-fusion/vue';

const { save } = useFusion();
const tag = ref('');
const said = ref('');

async function submit() {
    said.value = await save();
}
</script>

<template>
    <form class="post-editor" @submit.prevent="submit">
        <input v-model="title" placeholder="Title">
        <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>

        <textarea v-model="body"></textarea>
        <p>{{ words }} words</p>

        <span v-for="name in tags" :key="name" class="tag">{{ name }}</span>
        <input v-model="tag" @keydown.enter.prevent="addTag(tag); tag = ''">

        <button :disabled="save.processing">Save</button>
        <span v-if="save.slow">Saving…</span>
        <span v-if="unsaved.length">Unsaved changes</span>
        <p>{{ said }}</p>
    </form>
</template>
