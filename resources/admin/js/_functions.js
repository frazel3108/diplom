if (!Array.prototype.hasOwnProperty('chunk')) {
    Object.defineProperty(Array.prototype, 'chunk', {
        value: function (chunkSize) {
            let result = [];
            for (var i = 0; i < this.length; i += chunkSize) {
                result.push(this.slice(i, i + chunkSize));
            }
            return result;
        },
    });
}
