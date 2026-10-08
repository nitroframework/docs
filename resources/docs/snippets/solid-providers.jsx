import { I18nProvider } from '../../js/solid/i18n.jsx';
import { ThemeProvider } from '../../js/solid/theme.jsx';
import Toolbar from '../../js/solid/components/Toolbar.jsx';

export default function PostEditor(props) {
    /** The view is the root of its tree: its providers go around what it renders. */
    return (
        <I18nProvider>
            <ThemeProvider>
                <Toolbar />
                <input value={props.title} onInput={(e) => props.set('title', e.currentTarget.value)} />
            </ThemeProvider>
        </I18nProvider>
    );
}
