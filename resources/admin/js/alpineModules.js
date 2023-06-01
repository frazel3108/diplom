const req = require.context('./alpineModules', true, /[^_].*\.(js)$/);
req.keys().forEach(key => req(key));

const req2 = require.context('./modules', true, /^[^_].*\.(js)$/);
req2.keys().forEach(key => req2(key));
