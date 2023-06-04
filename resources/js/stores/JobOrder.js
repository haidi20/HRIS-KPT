import axios from "axios";
import moment from "moment";

import { checkNull } from '../utils';

export const listStatus = {
    finish: {
        status: "finish",
        status_last: "active",
    },
    pending_finish: {
        status: "active",
        status_last: "pending",
    },
    overtime_finish: {
        status: "active",
        status_last: "overtime",
    },
    correction_finish: {
        status: "finish",
        status_last: "correction",
    },
};

/**
Status values
@typedef {
'active' | 'finish'
| 'pending' | 'pending_finish'
| 'overtime' | 'overtime_finish'
| 'correction' | 'correction_finish'
| 'assessment' | 'assessment_finish'
} Status
*/

/**
*Default form object
@typedef {Object} DefaultForm
@property {null|string} code - The code value.
@property {null|number} project_id - The project ID.
@property {null|string} category - The category value.
@property {null|number} job_id - The job ID.
@property {null|string} job_note - The job note.
@property {Status} status - The status value.
@property {null|string} image - The image value.
@property {null|date} date - The date value.
@property {null|time} hour - The hour end value.
@property {null|string} form_kind - The form kind.
@property {string} form_title - The form title.
@property {null|string} hour_start - The hour start value.
@property {null|string} date_time_start - The start date and time.
@property {null|string} date_time_end - The end date and time.
@property {null|string} date_time_end_readable - The end date and time in a readable format.
@property {null|string} estimation - The estimation value.
@property {string} time_type - The time type.
@property {null|string} note - The note value.
@property {string} form_type - The form type.
*/

const defaultForm = {
    code: null,
    project_id: null,
    category: null,
    job_id: null,
    job_note: null,
    status: null,
    status_last: null,
    status_finish: null,
    image: null,
    // start form action
    date: new Date(),
    hour: moment().format("HH:mm"),
    // hour: null,
    status_note: null,
    // end form action
    form_kind: 'create',
    form_title: "Job Order",
    hour_start: null,
    datetime_start: null,
    datetime_end: null,
    datetime_end_readable: null,
    datetime_estimation_end: null,
    datetime_estimation_end_readable: null,
    estimation: null,
    time_type: "hours",
    note: null,
    form_type: "create",
}

const JobOrder = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
        params: {
            month: new Date(),
            type: "all",
            type_by: "creator",
            project_id: null,
        },
        form: { ...defaultForm },
        is_active_form: false,
        options: {
            time_types: [
                {
                    id: "minutes",
                    name: "Menit",
                },
                {
                    id: "hours",
                    name: "Jam",
                },
                {
                    id: "days",
                    name: "Hari",
                },
            ],
            job_levels: [
                {
                    id: "easy",
                    name: "Mudah / Ringan",
                },
                {
                    id: "middle",
                    name: "Sedang / Menengah",
                },
                {
                    id: "hard",
                    name: "Sulit / Berat",
                },
            ],
            categories: [
                {
                    id: 'reguler',
                    name: "Reguler",
                },
                {
                    id: 'daily',
                    name: "Harian",
                },
                {
                    id: 'fixed_price',
                    name: "Borongan",
                },
            ],
            types: [
                {
                    id: "all",
                    name: "semua",
                },
                {
                    id: "pause",
                    name: "tunda",
                },
                {
                    id: "active",
                    name: "aktif",
                },
                // jangan ini hanya untuk pengawas
                {
                    id: "done_assessment_qc",
                    name: "sudah dinilai oleh QC",
                },
            ],
            type_bys: [
                {
                    id: "creator",
                    name: "anda",
                },
                {
                    id: "other_foreman",
                    name: "pengawas lain",
                },
            ],
        },
        loading: {
            data: false,
        },
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA(state, payload) {
            state.data = payload.job_orders;
        },
        INSERT_FORM(state, payload) {
            state.form.form_kind = payload?.form_kind;
            state.form = {
                ...state.form,
                ...payload.form,
            };

            // if (payload.form_kind == 'edit') {
            //     state.form.note = payload.note;
            // }
        },
        INSERT_FORM_JOB_ID(state, payload) {
            state.form.job_id = payload.job_id;
        },
        INSERT_FORM_CODE(state, payload) {
            state.form.code = payload.code;
        },
        INSERT_FORM_HOUR_START(state, payload) {
            state.form.hour_start = payload.hour_start;
        },
        INSERT_FORM_ESTIMATION(state, payload) {
            state.form.estimation = payload.estimation;
        },
        INSERT_FORM_TIME_TYPE(state, payload) {
            state.form.time_type = payload.time_type;
        },
        INSERT_FORM_DATETIME_ESTIMATION_END(state, payload) {
            // console.info(state.form);
            // console.info(checkNull(state.form.estimation));
            if (
                checkNull(state.form.hour_start) != null
                && checkNull(state.form.estimation) != null
            ) {
                const hourStart = state.form.hour_start;
                const momentHourStart = moment().set({
                    hour: parseInt(hourStart.split(":")[0]),
                    minute: parseInt(hourStart.split(":")[1])
                });
                const getDateEstimation = momentHourStart
                    .add(
                        state.form.estimation,
                        state.form.time_type
                    );

                let addFormat = "";
                if (state.form.time_type != "days") {
                    addFormat = " HH:mm";
                }

                state.form.datetime_estimation_end = getDateEstimation.format("YYYY-MM-DD HH:mm");
                state.form.datetime_estimation_end_readable = getDateEstimation
                    // .locale("id")
                    .format(`dddd, D MMMM YYYY${addFormat}`);
            } else {
                state.form.datetime_estimation_end = null;
                state.form.datetime_estimation_end_readable = null;
            }
        },
        INSERT_FORM_KIND(state, payload) {
            state.form.form_title = payload.form_title;
            state.form.form_kind = payload.form_kind;
        },
        // JANGAN DI HAPUS, UNTUK BACKUP
        // INSERT_FORM_STATUS(state, payload) {
        //     let status = payload.status;
        //     const listStatusFinish = ["overtime_finish", "correction_finish"];

        //     if (listStatusFinish.some((item) => item == payload.status)) {
        //         // status = "finish";
        //         // status_finish = this.form.status;
        //         state.form.status = "active";
        //         state.form.status_finish = payload.status;
        //     } else {
        //         state.form.status = status;
        //         state.form.status_finish = null;
        //     }
        // },
        INSERT_FORM_STATUS(state, payload) {
            let getStatus = payload.status;

            if (listStatus[getStatus]) {
                state.form.status = listStatus[getStatus].status;
                state.form.status_last = listStatus[getStatus].status_last;
                state.form.status_finish = payload.status;
                state.form.status_note = null;
            } else {
                state.form.status = getStatus;
                state.form.status_note = null;
                state.form.status_last = null;
                state.form.status_finish = null;
            }
        },
        INSERT_PARAM(state, payload) {
            state.params = {
                ...state.params,
                ...payload,
            }
        },
        UPDATE_IS_ACTIVE_FORM(state, payload) {
            state.is_active_form = payload.value;
        },
        UPDATE_LOADING_DATA(state, payload) {
            state.loading.data = payload.value;
        },
        CLEAR_FORM(state, payload) {
            state.form = {
                ...defaultForm,
                is_active_form: true,
            };
        },
        CLEAR_FORM_ACTION(state, payload) {
            state.form = {
                ...state.form,
                // date_end: null,
                status_note: null,
            };
        },
    },
    actions: {
        fetchData: async (context, payload) => {
            context.commit("INSERT_DATA", {
                job_orders: [],
            });
            context.commit("UPDATE_LOADING_DATA", { value: true });

            const params = {
                ...context.state.params,
                month: moment(context.state.params.month).format("Y-MM"),
            }

            await axios
                .get(
                    `${context.state.base_url}/api/v1/job-order/fetch-data`, {
                    params: { ...params },
                })
                .then((responses) => {
                    console.info(responses);
                    const data = responses.data;

                    context.commit("INSERT_DATA", {
                        job_orders: data.jobOrders,
                    });
                    context.commit("UPDATE_LOADING_DATA", { value: false });
                })
                .catch((err) => {
                    context.commit("UPDATE_LOADING_DATA", { value: false });
                    console.info(err);
                });
        },
    }
}

export default JobOrder;
