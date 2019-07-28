import axios from 'axios'

export const MODULE_NAME   = 'reports';
export const GET_REPORTS   = `${MODULE_NAME}/GET_REPORTS`;
export const ADD_REPORT    = `${MODULE_NAME}/ADD_REPORT`;
export const UPDATE_REPORT = `${MODULE_NAME}/UPDATE_REPORT`;
export const DELETE_REPORT = `${MODULE_NAME}/DELETE_REPORT`;
export const UPDATE_FORM   = `${MODULE_NAME}/UPDATE_FORM`;

const defaultFormState = {
    id: '',
    title: '',
    date: '',
    text: ''
};

const InitialState = {
    items: [],
    form: {...defaultFormState}
};

export default function reportsReducer(state = InitialState, action) {
    const { type, payload } = action;
    const newState = { ...state };

    switch(type) {

		case GET_REPORTS:
            newState.items = payload;
            return newState;

        case UPDATE_FORM:
            newState.form[payload.name] = payload.value;
            return newState;

        case ADD_REPORT:
            newState.items.push(payload);
            newState.form = { ...defaultFormState };
            return newState;

        case DELETE_REPORT:
            let reports = newState.items.filter(item => item.id !== payload);
            newState.items = reports;
            return newState;

		default:
			return state;
	}
}

export const getReports = () => {
    return (dispatch) => {
        axios.get('/backend/api/reports')
            .then(response => {
                dispatch({ type: GET_REPORTS, payload: response.data.data });
            })
    }
};

export const addReport = (data) => ({
    type: ADD_REPORT,
    payload: data
});

export const updateReport = () => ({
    // TO DO
});

export const updateForm = (data) => ({
    type: UPDATE_FORM,
    payload: data
});

export const sendReport = (formData) => {
    return (dispatch) => {
            axios({ method: 'post', url: '/backend/api/reports', data: formData,
                config: { headers: {'Content-Type': 'multipart/form-data' }}})
                .then(function (response) {
                    dispatch(addReport(response.data.data));     
                })
                .catch(function (response) {
                    console.log(response);
                });
    };
}

export const deleteReport = (id) => {
    let formData = new FormData();
    formData.append('id', id);
    formData.append('type', 'delete');

    return (dispatch) => {
        axios({ method: 'post', url: '/backend/api/reports', data: formData, 
                config: { headers: {'Content-Type': 'multipart/form-data' }} })
                .then(function (response) {
                   if (response.data.result === 'ok') {
                        dispatch(deleteReportSync(id));
                   }      
                })
                .catch(function (response) {
                    console.log(response);
                });
    };
}

export const deleteReportSync = (id) => ({
    type: DELETE_REPORT,
    payload: id
});