const ADDRESS = "http://localhost:8000/api";

const USER = `${ADDRESS}/user`;
const QUESTIONNAIRE = `${ADDRESS}/questionnaire`;

export const URLS = {
    GET: {
        USER: {
            details: `${USER}/details`,
            signOut: `${USER}/sign-out`,
        },
        QUESTIONNAIRE: {
            categories: `${QUESTIONNAIRE}/categories`,
            all: `${QUESTIONNAIRE}/all`
        },
    },
    POST: {
        USER: {
            signUp: `${USER}/sign-up`,
            login: `${USER}/login`,
        },
        QUESTIONNAIRE: {
            create: `${QUESTIONNAIRE}/create`,
        },
    },
    PUT: {},
    DELETE: {
        QUESTIONNAIRE: {
            delete: `${QUESTIONNAIRE}/delete`,
        },
    }
};
