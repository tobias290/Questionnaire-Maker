const ADDRESS = "http://localhost:8000/api";

const PUBLIC = `${ADDRESS}/public`;
const USER = `${ADDRESS}/user`;
const QUESTIONNAIRE = `${ADDRESS}/questionnaire`;
const QUESTION = `${ADDRESS}/question`;
const RESPONSES = `${ADDRESS}/responses`;

export const URLS = {
    GET: {
        PUBLIC: {
            questionnaires: `${PUBLIC}/questionnaires`,
            categories: `${PUBLIC}/questionnaire-categories`,
            answerQuestionnaire: id => `${PUBLIC}/questionnaire/${id}/answer`,
        },
        USER: {
            details: `${USER}/details`,
            signOut: `${USER}/sign-out`,
            settings: `${USER}/settings/all`,
            notifications: `${USER}/notifications/all`,
        },
        QUESTIONNAIRE: {
            all: `${QUESTIONNAIRE}/all`,
            get: `${QUESTIONNAIRE}`,
            preview: id => `${QUESTIONNAIRE}/${id}/preview`,
        },
        QUESTION: {
            questionnaireQuestions: id => `${QUESTION}/questionnaire/${id}/questions`
        },
        QUESTION_OPTION: {
            questionClosedOptions: id => `${QUESTION}/closed/${id}/options`
        },
        RESPONSES: {
            questionnaireResponses: id => `${RESPONSES}/questionnaire/${id}/responses`
        },
    },
    POST: {
        PUBLIC: {
            submitQuestionnaire: id => `${PUBLIC}/questionnaire/${id}/submit`,
        },
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

            duplicateOpen: `${QUESTION}/duplicate/open`,
            duplicateClosed: `${QUESTION}/duplicate/closed`,
            duplicateScaled: `${QUESTION}/duplicate/scaled`,
        },
        QUESTION_OPTION: {
            addOption: `${QUESTION}/add/closed/option`,
        }
    },
    PATCH: {
        PUBLIC: {
            report: id => `${PUBLIC}/questionnaire/${id}/report`
        },
        USER: {
            edit: `${USER}/edit`,
            editSettings: `${USER}/settings/edit`,
            readNotification: `${USER}/notifications/read`,
            readAllNotifications: `${USER}/notifications/read-all`,
        },
        QUESTIONNAIRE: {
            edit: `${QUESTIONNAIRE}/edit`,
        },
        QUESTION: {
            editOpen: `${QUESTION}/edit/open`,
            editClosed: `${QUESTION}/edit/closed`,
            editScaled: `${QUESTION}/edit/scaled`,
        },
        QUESTION_OPTION: {
            editOption: `${QUESTION}/edit/closed/option`
        }
    },
    DELETE: {
        USER: {
            delete: `${USER}/delete`,
            deleteNotification: `${USER}/notifications/delete`,
            deleteAllNotifications: `${USER}/notifications/delete-all`,
        },
        QUESTIONNAIRE: {
            delete: `${QUESTIONNAIRE}/delete`,
        },
        QUESTION: {
            deleteOpen: `${QUESTION}/delete/open`,
            deleteClosed: `${QUESTION}/delete/closed`,
            deleteScaled: `${QUESTION}/delete/scaled`,
        },
        QUESTION_OPTION: {
            deleteOption: `${QUESTION}/delete/closed/option`
        }
    }
};
