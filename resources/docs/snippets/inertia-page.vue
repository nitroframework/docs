<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ post: Object });
const form = useForm({ comment: '' });

function submit() {
    form.post(`/posts/${props.post.id}/comments`, { onSuccess: () => form.reset() });
}
</script>

<template>
    <article>
        <h1>{{ post.title }}</h1>
        <p>{{ post.body }}</p>

        <form @submit.prevent="submit">
            <textarea v-model="form.comment"></textarea>
            <p v-if="form.errors.comment" class="error">{{ form.errors.comment }}</p>
            <button :disabled="form.processing">Comment</button>
        </form>
    </article>
</template>
