<template>
    <label class="cover">
        <span>Cover image</span>
        <input type="file" accept="image/*" @change="upload('cover', $event.target.files)">
    </label>

    <progress v-if="uploads.cover?.uploading" max="100" :value="uploads.cover.progress"></progress>
    <p v-if="errors.cover" class="error">{{ errors.cover[0] }}</p>

    <figure v-if="cover">
        <img :src="cover.temporaryUrl()" alt="">
        <figcaption>{{ cover.getClientOriginalName() }}, {{ Math.round(cover.getSize() / 1024) }} KB</figcaption>
    </figure>
</template>
