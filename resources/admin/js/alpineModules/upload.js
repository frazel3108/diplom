document.addEventListener('alpine:init', () => {
    Alpine.data('upload', config => ({
        uploaded: config.uploaded || null,
        multiple: config.multiple || false,
        files: [],

        onChange(e) {
            this.files = e.target.files;
            this.$dispatch('uploaded', { files: this.files });
        },
    }));
});
