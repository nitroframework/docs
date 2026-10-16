<template>
    <article>
        <h1>{{ post.title }}</h1>
        <p>{{ post.body }}</p>

        <form @submit.prevent="addComment()">
            <textarea v-model="comment"></textarea>
            <p v-if="errors.comment" class="error">{{ errors.comment[0] }}</p>
            <button :disabled="addComment.processing">Comment</button>
        </form>
    </article>
</template>
