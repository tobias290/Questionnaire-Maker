const ADDRESS = "http://localhost:8000/api";

const USER = `${ADDRESS}/user`;
const QUESTIONNAIRE = `${ADDRESS}/questionnaire`;

export const URLS = {
    USER: {
        signUp: `${USER}/sign-up`,
        login: `${USER}/login`,
        signOut: `${USER}/sign-out`,
        details: `${USER}/details`,
    },
    QUESTIONNAIRE: {
        create: `${QUESTIONNAIRE}/create`,
    }
};
