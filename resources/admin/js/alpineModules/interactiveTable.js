document.addEventListener('alpine:init', () => {
  Alpine.data('interactiveTable', config => ({
    onAddClick() {
      this.addRow();
    },

    addRow() {
      const row = this.$refs.templateRow.cloneNode(true);
      row.classList.remove('hidden');
      row.removeAttribute('x-ref');
      this.$root.querySelector('tbody').appendChild(row);
    },

    onDeleteClick(e) {
      let elem = e.target.parentNode;
      while (elem.tagName.toLowerCase() != 'tr') {
        elem = elem.parentNode;
      }
      const bounding = elem.getBoundingClientRect();

      const row = this.$refs.templateDelete.cloneNode(true);
      row.classList.remove('hidden');
      row.removeAttribute('x-ref');
      row.querySelector('td').style.width = `${bounding.width}px`;
      row.querySelector('td').style.height = `${bounding.height}px`;

      elem.classList.add('hidden');
      elem.before(row);

      setTimeout(() => {
        elem.classList.remove('hidden');
        row.remove();
      }, 5000);

      setTimeout(() => {
        this.updateCountdown(row);
      }, 1000);
    },

    updateCountdown(row) {
      const countdown = row.querySelector('[countdown]');
      if (!countdown) {
        return;
      }
      const value = countdown.innerHTML - 1;
      countdown.innerHTML = value;

      if (value > 1) {
        setTimeout(() => {
          this.updateCountdown(row);
        }, 1000);
      }
    },

    onDeleteConfirmationClick(e) {
      let elem = e.target.parentNode;
      while (elem.tagName.toLowerCase() != 'tr') {
        elem = elem.parentNode;
      }

      elem.nextSibling.remove();
      elem.remove();
    },
  }));
});
