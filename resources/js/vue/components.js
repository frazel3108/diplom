const context = require.context('./components', true, /^[^_]((?!\/_).)*\.vue$/);

export default Object.fromEntries(
    context.keys().map(pathToModule => {
        let key = pathToModule
            .substr(2, pathToModule.length - 6)
            .split('/')
            .map(word => word[0].toUpperCase() + word.substr(1))
            .join('');

        return [key, context(pathToModule).default];
    })
);