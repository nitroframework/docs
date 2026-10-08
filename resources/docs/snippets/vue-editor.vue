<template>
    <form class="editor" @submit.prevent="save">
        <input v-model="title" placeholder="Title">
        <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>

        <textarea v-model="body" rows="8"></textarea>
        <p class="muted">{{ words }} words</p>

        <ul class="tags">
            <li v-for="(tag, index) in tags" :key="tag">
                {{ tag }} <button type="button" @click="removeTag(index)">×</button>
            </li>
        </ul>
        <input placeholder="Add a tag" @keydown.enter.prevent="addTag($event.target.value); $event.target.value = ''">

        <button :disabled="save.processing">{{ save.slow ? 'Saving…' : 'Save' }}</button>
        <span v-if="unsaved.length" class="muted">Unsaved changes</span>
        <span v-if="savedAt" class="muted">Saved at {{ savedAt }}</span>
    </form>
</template>
