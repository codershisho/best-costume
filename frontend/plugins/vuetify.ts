import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

export default defineNuxtPlugin((nuxtApp) => {
  const vuetify = createVuetify({
    components,
    directives,
    theme: {
      themes: {
        light: {
          colors: {
            primary: '#2962FF',
            back: '#F5F8FA',
          },
        },
      },
    },
  });

  nuxtApp.vueApp.use(vuetify);
});
