import { createApp } from 'vue';
import components from './components';

try {
  const app = createApp({
      components,
      mounted() {
          import('../loadModules');
      },
  });

  app.mount('#app');
} catch (error) {
  console.log(error);
}
