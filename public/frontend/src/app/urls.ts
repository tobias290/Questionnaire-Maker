const ADDRESS = "http://localhost:8000/api";

const USER = `${ADDRESS}/user`;
const QUESTIONNAIRE = `${ADDRESS}/questionnaire`;
const QUESTION = `${ADDRESS}/question`;

export const URLS = {
    GET: {
        USER: {
            details: `${USER}/details`,
            signOut: `${USER}/sign-out`,
        },
        QUESTIONNAIRE: {
            categories: `${QUESTIONNAIRE}/categories`,
            all: `${QUESTIONNAIRE}/all`,
            get: `${QUESTIONNAIRE}`
        },
        QUESTION: {
            questionnaireQuestions: id => `${QUESTION}/questionnaire/${id}/questions`
        }
    },
    POST: {
        USER: {
            signUp: `${USER}/sign-up`,
            login: `${USER}/login`,
        },
        QUESTIONNAIRE: {
            create: `${QUESTIONNAIRE}/create`,
        },
        QUESTION: {
            addOpen: `${QUESTION}/add/open`,
            addClosed: `${QUESTION}/add/closed`,
            addScaled: `${QUESTION}/add/scaled`,
        }
    },
    PATCH: {
        QUESTIONNAIRE: {
            edit: `${QUESTIONNAIRE}/edit`,
        },
        QUESTION: {
            editOpen: `${QUESTION}/edit/open`,
            editClosed: `${QUESTION}/edit/closed`,
            editScaled: `${QUESTION}/edit/scaled`,
        }
    },
    DELETE: {
        QUESTIONNAIRE: {
            delete: `${QUESTIONNAIRE}/delete`,
        },
        QUESTION: {
            deleteOpen: `${QUESTION}/delete/open`,
            deleteClosed: `${QUESTION}/delete/closed`,
            deleteScaled: `${QUESTION}/delete/scaled`,
        }
    }
};
