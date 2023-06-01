document.addEventListener('alpine:init', () => {
    Alpine.data('wysiwyg', config => ({
        ref: config.ref || 'wysiwyg',
        // uploadUrl: config.uploadUrl,

        init() {
            if (typeof CKEDITOR != 'undefine') {
                if (this.$refs[this.ref]) {
                    CKEDITOR.replace(this.ref, {
                        filebrowserUploadUrl: this.uploadUrl,
                    });
                }
            }
        }
    }));
});
