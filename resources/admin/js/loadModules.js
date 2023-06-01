const req = require.context('./modules', true, /[^_].*\.(js)$/);
req.keys().forEach(key => req(key));
