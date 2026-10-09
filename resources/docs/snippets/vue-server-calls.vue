<script setup>
import { ref } from 'vue';
import { useNitro } from 'nitro/vue';

const { save } = useNitro();
const notice = ref('');

async function submit() {
    try {
        /** The method's return value; null when a rule failed (errors has the messages). */
        const said = await save();
        notice.value = said ?? 'Please fix the highlighted fields.';
    } catch {
        /** The request itself failed: the server's error, or no connection. save.error says why. */
        notice.value = `Not saved: ${save.error}`;
    }
}
</script>

<template>
    <button :disabled="save.processing" @click="submit">
        <span v-if="save.slow">Still saving…</span>
        <span v-else-if="save.processing">Saving</span>
        <span v-else>Save</span>
    </button>
    <p v-if="save.failed" class="error">{{ save.error }}</p>
    <p>{{ notice }}</p>
</template>
