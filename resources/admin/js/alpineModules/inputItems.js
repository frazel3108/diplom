document.addEventListener('alpine:init', () => {
    Alpine.data('inputItems', config => ({
        items: config.items,

        draggingIdx: null,
        draggingElem: null,
        draggingElemHeight: null,
        draggingShiftX: 0,
        draggingShiftY: 0,
        ghostIdx: null,

        breakpoints: [],
        newItemIdx: null,

        init() {
            document.addEventListener('mousemove', e => this.onMousemove(e));
            document.addEventListener('mouseup', e => this.onMouseup(e));
        },

        onKeyup(idx, e) {
            this.items[idx] = e.target.value;
        },

        onBlur(idx) {
            if (this.items[idx] == '') {
                this.items.splice(idx, 1);
            }
        },

        onNewItemKeyup(e) {
            if (e.target.value != '' && this.newItemIdx === null) {
                this.items.push(e.target.value);
                this.newItemIdx = this.items.length - 1;
                this.$nextTick(() => {
                    e.target.value = '';
                    this.$refs.items.getElementsByClassName(`input_${this.items.length - 1}`)[0].focus();
                    this.newItemIdx = null;
                });
            }
        },

        onMousedown(idx, e) {
            this.breakpoints = [];

            for (let idx in this.items) {
                let bounding = this.$refs.items.getElementsByClassName(`item_${idx}`)[0].parentNode.getBoundingClientRect();
                this.breakpoints.push(bounding.top + bounding.height / 2);
            }

            if (e.target.nodeName == 'DIV') {
                this.draggingElem = e.target.parentNode;
            } else if (e.target.nodeName == 'svg') {
                this.draggingElem = e.target.parentNode.parentNode;
            } else if (e.target.nodeName == 'path') {
                this.draggingElem = e.target.parentNode.parentNode.parentNode;
            }

            const bounding = this.draggingElem.getBoundingClientRect();

            this.draggingShiftX = e.pageX - bounding.x;
            this.draggingShiftY = e.pageY - bounding.y;
            this.draggingElemHeight = bounding.height;

            this.draggingElem.style.width = `${bounding.width}px`;
            this.draggingElem.style.height = `${bounding.height}px`;
            this.draggingElem.style.position = 'fixed';
            this.draggingElem.style.top = `${e.pageY - (this.draggingShiftY)}px`;
            this.draggingElem.style.left = `${e.pageX - (this.draggingShiftX)}px`;

            this.ghostIdx = idx + 1;
            this.draggingIdx = idx;
        },

        onMouseup(e) {
            if (this.draggingIdx !== null) {
                this.items.splice(
                    this.draggingIdx >= this.ghostIdx ? this.ghostIdx : (this.ghostIdx - 1),
                    0,
                    this.items.splice(this.draggingIdx, 1)
                );

                this.draggingIdx = null;
                this.draggingElem.style = null;
                this.draggingElem = null;
                this.ghostIdx = null;
            }
        },

        onMousemove(e) {
            if (this.draggingIdx !== null) {
                this.draggingElem.style.top = `${e.pageY - (this.draggingShiftY)}px`;
                this.draggingElem.style.left = `${e.pageX - (this.draggingShiftX)}px`;

                let newIdx = null;
                for (let idx in this.breakpoints) {
                    if (e.pageY <= this.breakpoints[idx] && idx != this.draggingIdx) {
                        newIdx = idx;
                        break;
                    }
                }

                if (newIdx === null) {
                    newIdx = this.items.length;
                }

                this.ghostIdx = newIdx;
            }
        },
    }));
});
