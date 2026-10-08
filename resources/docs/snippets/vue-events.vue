<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { useFusion } from 'nitro-fusion/vue';

const { dispatch } = useFusion();
const lastSaved = ref(null);

/** An event another component dispatched (without ->to()), heard in the view's own code: its values in order. */
const heard = (event) => (lastSaved.value = event.detail.params[0]);
onMounted(() => window.addEventListener('post-saved', heard));
onBeforeUnmount(() => window.removeEventListener('post-saved', heard));
</script>

<template>
    <button @click="dispatch('preview-requested', 42)">Preview</button>
    <p v-if="lastSaved">Post {{ lastSaved }} was just saved.</p>
</template>
