import axios from "axios";
import moment from "moment";

import { checkNull, listStatus } from '../utils';

const defaultForm = {
    // id: null,
    employee_id: null,
    position_id: null,
    job_order_id: null,
    employee_base: "all",
    form_type: "create",
    form_type_parent: "create",
    // start job order
    data_index: null, // untuk hapus data yang sudah di pilih
    status: null,
    is_hide_status: false,
    hour: moment().format("HH:mm"),
    date: new Date(),
}

const EmployeeHasParent = {
    namespaced: true,
    state: {
        base_url: null,
        data: {
            options: [],
            table: [],
            selecteds: [],
            foremans: [],
        },
        params: {
            search: null,
            date: new Date(),
        },
        form: { ...defaultForm },
        options: {
            employee_bases: [
                {
                    id: 'all',
                    name: "Semua Karyawan",
                },
                {
                    id: 'choose_employee',
                    name: "Pilih Karyawan",
                },
                {
                    id: 'position',
                    name: "Jabatan",
                },
                {
                    id: 'job_order',
                    name: "Job Order",
                },
                // {
                //     id: 'project',
                //     name: "Proyek",
                // },
            ],
            statuses: {},
        },
        loading: {
            table: false,
        },
        is_mobile: false,
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA_OPTION(state, payload) {
            state.data.options = payload.employees;
        },
        INSERT_DATA_TABLE(state, payload) {
            state.data.table = payload.employees;
        },
        INSERT_DATA_FOREMAN(state, payload) {
            state.data.foremans = payload.foremans;
        },
        INSERT_DATA_SELECTED(state, payload) {
            state.data.selecteds = [
                { ...payload.employee, status_last: null },
                ...state.data.selecteds,
            ];
        },
        INSERT_DATA_ALL_SELECTED(state, payload) {
            // console.info(payload);
            state.data.selecteds = [...payload.selecteds];
        },
        INSERT_OPTION_STATUS(state, payload) {
            state.options.statuses = { ...payload.statuses };
        },
        INSERT_FORM(state, payload) {
            state.form = {
                ...state.form,
                ...payload.form,
            };

            if (payload.form_type != null) {
                // form_type: payload.form_type,
                state.form.form_type = payload.form_type;
            }
        },
        INSERT_FORM_FORM_TYPE(state, payload) {
            state.form.form_type = payload.form_type;
            state.form.form_type_parent = payload.form_type_parent;
        },
        UPDATE_IS_MOBILE(state, payload) {
            state.is_mobile = payload.value;
        },
        // kebutuhan di job order file data.js
        UPDATE_DATA_ALL_SELECTED_STATUS_OVERTIME(state, payload) {
            const getSelecteds = state.data.selecteds.map(item => item.status == 'active' ? ({
                ...item,
                status: 'overtime',
                status_readable: state.options.statuses['overtime'].short_readable,
                status_color: state.options.statuses['overtime'].color,
            }) : ({ ...item }));

            state.data.selecteds = [...getSelecteds];
        },
        UPDATE_DATA_SELECTED_STATUS(state, payload) {
            let statusLast = null;
            let getFormType = null;

            if (listStatus[payload.form_type]) {
                getFormType = listStatus[payload.form_type].status;
                statusLast = listStatus[payload.form_type].status_last;
            } else {
                getFormType = payload.form_type;
            }

            const getSelecteds = state.data.selecteds.map(item => {
                if (payload.hasOwnProperty('list_employee_id')) {
                    // console.info(payload.list_employee_id);
                    const getStatus = state.options.statuses[getFormType];
                    if (payload.list_employee_id.some(value => value.employee_id == item.employee_id)) {
                        let status_added = {};
                        if (getStatus) {
                            status_added = {
                                status_readable: getStatus.short_readable,
                                status_color: getStatus.color,
                            };
                        }

                        return {
                            ...item,
                            status: getFormType,
                            status_last: statusLast,
                            ...status_added,
                        }
                    }
                } else if (item.employee_id == state.form.employee_id) {
                    const getStatus = state.options.statuses[getFormType];

                    return {
                        ...item,
                        status: getFormType,
                        status_last: statusLast,
                        status_readable: getStatus.short_readable,
                        status_color: getStatus.color,
                    }
                }

                // jangan tambahkan status_last
                return { ...item };
            });

            state.data.selecteds = [...getSelecteds];

            // console.info(state.options.statuses[payload.form_type]);
            // console.info(state.form.employee_id, payload.form_type);
            // console.info(state.data.selecteds);
        },
        DELETE_FORM_EMPLOYEE_ID(state, payload) {
            state.form.employee_id = null;
        },
        DELETE_DATA_SELECTED(state, payload) {
            state.data.selecteds.splice(payload.index, 1);
        },
        CLEAR_FORM(state, payload) {
            state.form = { ...defaultForm };
        },
        CLEAR_DATA_SELECTED(state, payload) {
            state.data.selecteds = [];
        },
    },
    actions: {
        fetchData: async (context, payload) => {
            await axios
                .get(
                    `${context.state.base_url}/api/v1/employee/fetch-data`, {
                    params: {},
                })
                .then((responses) => {
                    // console.info(responses);
                    let data = responses.data;

                    context.commit("INSERT_DATA_TABLE", {
                        employees: data.employees,
                    });
                })
                .catch((err) => {
                    console.info(err);
                });
        },
        fetchOption: async (context, payload) => {
            await axios
                .get(
                    `${context.state.base_url}/api/v1/employee/fetch-option`, {
                    params: {},
                })
                .then((responses) => {
                    // console.info(responses);
                    let data = responses.data;

                    context.commit("INSERT_DATA_OPTION", {
                        employees: data.employees,
                    });

                })
                .catch((err) => {
                    console.info(err);
                });
        },
        fetchForeman: async (context, payload) => {
            await axios
                .get(
                    `${context.state.base_url}/api/v1/employee/fetch-foreman`, {
                    params: {},
                })
                .then((responses) => {
                    // console.info(responses);
                    let data = responses.data;

                    context.commit("INSERT_DATA_FOREMAN", {
                        foremans: data.foremans,
                    });
                })
                .catch((err) => {
                    console.info(err);
                });
        },
        onUpdateStatusDataSelected: (context, payload) => {
            let getStatus = null;
            // console.info(listStatus[payload.form_type].status);
            if (payload.form_type == 'correction') {
                getStatus = 'finish';
            }
            else if (
                payload.form_type == 'pending'
                || payload.form_type == 'overtime'
                || payload.form_type == 'assessment'
            ) {
                getStatus = 'active';
            } else if (listStatus[payload.form_type]) {
                getStatus = listStatus[payload.form_type].status_last;
            } else {
                getStatus = payload.form_type;
            }

            // console.info(getStatus, payload);

            const getDataSelectedOvertime = context.state.data.selecteds
                .filter(item => item.status == getStatus)
                .map(item => ({ employee_id: item.employee_id }));

            // console.info(getDataSelectedOvertime);

            context.commit("UPDATE_DATA_SELECTED_STATUS", {
                list_employee_id: [...getDataSelectedOvertime],
                form_type: payload.form_type,
            });

            // console.info(context.state.data.selecteds);
        },
    },
    getters: {
        getReadOnly: (state) => {
            let result = false;

            // console.info(state.form.form_type);

            if (state.form.form_type == "read") {
                result = true;
            }

            return result;
        },
    },
}

export default EmployeeHasParent;
