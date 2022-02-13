import { createGettext } from 'vue3-gettext';
import translations from '../../../../language/translations.json';

const language = createGettext({
    availableLanguages: {
        en: 'English',
        hr: 'Croatian',
    },
    defaultLanguage: window.climbingcards.user_language,
    translations: translations,
    setGlobalProperties: true,
    provideDirective: true,
    provideComponent: true,
});

export default language;
