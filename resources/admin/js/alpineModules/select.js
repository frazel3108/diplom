document.addEventListener('alpine:init', () => {
    Alpine.data('select', config => ({
        options: config.options,
        value: config.value,
        multiple: config.multiple,

        navIdx: -1,

        selected: null,
        inFocus: false,
        search: null,

        init() {
            if (this.multiple) {
                this.selected = this.options.filter(option => this.value.includes(option.id))
                    .map(option => option.id);
            } else {
                this.selected = this.options.find(option => option.id == this.value);
            }

            this.$watch('search', () => {
                this.navIdx = -1;
            });

            this.$watch('inFocus', () => {
                if (this.inFocus && this.selected !== null) {
                    let idx = 0;
                    for (let optionIdx in this.filteredOptions()) {
                        if (this.filteredOptions()[optionIdx].id == this.selected?.id) {
                            idx = optionIdx;
                            break;
                        }
                    }

                    this.$nextTick(() => {
                        const option = this.$refs.dropdown.getElementsByClassName('option')[idx];
                        const optionOffset = option.offsetTop;
                        const optionHeight = option.clientHeight;

                        this.$refs.dropdown.scrollTop = optionOffset - optionHeight;
                    });
                }
            });
        },

        onContainerFocus() {
            if (!this.inFocus) {
                this.inFocus = true;
                this.$nextTick(() => {
                    this.$refs.search.focus();
                });
            }
        },

        onContainerBlur(e) {
            this.$nextTick(() => {
                if (
                    document.activeElement == this.$refs.search ||
                    document.activeElement.classList.contains('option') ||
                    e.relatedTarget == this.$refs.container
                ) {
                    return;
                }

                this.inFocus = false;
            });
        },

        onSearchBlur(e) {
            this.navIdx = -1;
            if (e.relatedTarget != this.$refs.container) {
                this.inFocus = false;
                this.search = null;
            }
        },

        onSearchKeydown(e) {
            if (e.keyCode === 32 && this.navIdx >= 0) {
                e.preventDefault();
                this.onOptionClick(this.filteredOptions()[this.navIdx]);
            }
            if (e.keyCode === 38) {
                e.preventDefault();
                if (this.navIdx >= 0) {
                    this.navIdx--;
                }

                this.scrollDropdown('up');
            }
            if (e.keyCode === 40) {
                e.preventDefault();
                if (this.navIdx < this.filteredOptions().length - 1) {
                    this.navIdx++;
                }

                this.scrollDropdown('down');
            }
        },

        scrollDropdown(dir) {
            if (this.navIdx === -1) {
                this.$refs.dropdown.scrollTop = 0;
                return;
            }

            const option = this.$refs.dropdown.getElementsByClassName('option')[this.navIdx];
            const optionOffset = option.offsetTop;
            const optionHeight = option.clientHeight;

            this.$refs.dropdown.scrollTop = optionOffset - optionHeight * (dir === 'down' ? 2 : 1);
        },

        label() {
            if (this.multiple) {
                if (this.selected.length === 0) {
                    return 'Выбрать';
                } else if (this.selected.length === 1) {
                    return this.options.find(option => option.id == this.selected[0]).name;
                } else {
                    return `${this.selected.length} выбрано`;
                }
            } else {
                return this.selected ? this.selected.name : 'Выбрать';
            }
        },

        isOptionSelected(option) {
            if (this.multiple) {
                return this.selected.includes(option.id);
            }
            return option.id === this.selected?.id;
        },

        isOptionNavigated(idx) {
            return idx === this.navIdx;
        },

        onOptionClick(option) {
            if (this.multiple) {
                if (this.selected.includes(option.id)) {
                    this.selected.splice(this.selected.indexOf(option.id), 1);
                } else {
                    this.selected.push(option.id);
                }
            } else {
                this.selected = this.selected?.id == option.id ? null : option;
            }
        },

        filteredOptions() {
            return this.search === '' || this.search === null ?
                this.options :
                this.options.filter(option => RegExp(this.search.toLowerCase()).test(option.name.toLowerCase()));
        },
    }));
});
