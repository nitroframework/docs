// resources/js/ssr.jsx
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { serve } from 'nitro-fusion/ssr';
import { renderReact } from 'nitro-fusion/react/server';

serve({
    react: renderReact(import.meta.glob(['../views/react/**/*.{jsx,tsx}', './react/**/*.{jsx,tsx}'], { eager: true }), {
        /** Called for each render: the service renders for every visitor, so nothing is shared between them. */
        wrap: (view) => <QueryClientProvider client={new QueryClient()}>{view}</QueryClientProvider>,
    }),
});
