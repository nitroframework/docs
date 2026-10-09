import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { IntlProvider } from 'react-intl';
import { nitroReact } from 'nitro/react';
import messages from './lang/messages.js';

/** One client for every view on the page, so their caches are shared. */
const queryClient = new QueryClient();
const locale = document.documentElement.lang;

nitroReact(import.meta.glob(['../views/react/**/*.{jsx,tsx}', './react/**/*.{jsx,tsx}']), {
    /** Called for each view: the providers around it. */
    wrap: (view) => (
        <QueryClientProvider client={queryClient}>
            <IntlProvider locale={locale} messages={messages[locale]}>{view}</IntlProvider>
        </QueryClientProvider>
    ),
});
