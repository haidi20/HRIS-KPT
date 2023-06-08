import axios from "axios";
import moment from "moment";

import { checkNull, listStatus } from '../utils';

/**
Status values
@typedef {
'active' | 'finish'
| 'pending'
| 'overtime' | 'overtime_finish'
| 'correction' | 'correction_finish'
| 'assessment' | 'assessment_finish'
} Status
*/

/**
 * Default form object.
 * @typedef {Object} DefaultForm
 * @property {?number} id - The ID of the form.
 * @property {?string} job_code - The job code.
 * @property {?number} project_id - The ID of the project.
 * @property {?string} category - The category of the job.
 * @property {?number} job_id - The ID of the job.
 * @property {?string} job_note - The note related to the job.
 * @property {?string} status - The status of the job.
 * @property {?string} status_last - The last status of the job.
 * @property {?string} status_finish - The finish status of the job.
 * @property {?string} image - The image related to the job.
 * @property {Date} date - The date of the form.
 * @property {string} hour - The hour in "HH:mm" format.
 * @property {?string} status_note - The note related to the status.
 * @property {?string} form_kind - The kind of form.
 * @property {?string} form_title - The title of the form.
 * @property {?string} hour_start - The start hour of the job.
 * @property {?string} datetime_start - The start date and time of the job.
 * @property {?string} datetime_end - The end date and time of the job.
 * @property {?string} datetime_end_readable - The readable format of the end date and time.
 * @property {?string} datetime_estimation_end - The estimated end date and time of the job.
 * @property {?string} datetime_estimation_end_readable - The readable format of the estimated end date and time.
 * @property {?number} estimation - The estimation value.
 * @property {?string} time_type - The type of time (minutes, hours, days).
 * @property {?string} note - The note related to the job.
 * @property {string} label_image - The label for the image field.
 */

/**
 * Default form object.
 * @type {DefaultForm}
 */
const defaultForm = {
    id: null,
    job_code: null,
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
    // form_kind: 'create',
    form_kind: null, // kebutuhan logika kirim data dari modal karyawan
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
    label_image: "Masukkan Gambar",
}

const JobOrder = {
    namespaced: true,
    state: {
        base_url: null,
        data: [],
        params: {
            month: new Date(),
            status: "all",
            created_by: "creator",
            project_id: null,
            search: null,
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
            statuses: [
                {
                    id: "all",
                    name: "semua",
                },
                {
                    id: "active",
                    name: "aktif",
                },
                {
                    id: "pending",
                    name: "tunda",
                },
                {
                    id: "overtime",
                    name: "lembur",
                },
                {
                    id: "assessment",
                    name: "penilaian",
                },
                {
                    id: "finish",
                    name: "selesai",
                },
                // ini hanya untuk pengawas
                // {
                //     id: "done_assessment_qc",
                //     name: "sudah dinilai oleh QC",
                // },
            ],
            create_byes: [
                {
                    id: "creator",
                    name: "anda",
                },
                {
                    id: "another_foreman",
                    name: "pengawas lain",
                },
            ],
        },
        loading: {
            data: false,
        },
        user_id: null,
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_DATA(state, payload) {
            state.data = payload.job_orders;
        },
        INSERT_FORM(state, payload) {
            state.form = {
                ...state.form,
                ...payload.form,
            };

            if (payload?.form_kind) {
                state.form.form_kind = payload?.form_kind;
            }

            // if (payload.form_kind == 'edit') {
            //     state.form.note = payload.note;
            // }
        },
        INSERT_FORM_JOB_ID(state, payload) {
            state.form.job_id = payload.job_id;
        },
        INSERT_FORM_JOB_CODE(state, payload) {
            state.form.job_code = payload.job_code;
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

            if (payload.form_kind == "edit") {
                state.form.label_image = "Ganti Gambar";
            } else {
                state.form.label_image = "Masukkan Gambar";
            }
        },
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
        INSERT_PARAM_CREATED_BY(state, payload) {
            state.params.created_by = payload.created_by;
        },
        INSERT_USER_ID(state, payload) {
            state.user_id = payload.user_id;
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
                hour: moment().format("HH:mm"),
                status_note: null,
            };
        },
    },
    actions: {
        fetchData: async (context, payload) => {

            if (payload?.user_id) {
                context.commit("INSERT_USER_ID", { user_id: payload.user_id });
            }

            context.commit("INSERT_DATA", {
                job_orders: [],
            });
            context.commit("UPDATE_LOADING_DATA", { value: true });

            const params = {
                ...context.state.params,
                month: moment(context.state.params.month).format("Y-MM"),
                user_id: context.state.user_id,
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
    },
    getters: {
        getReadOnly: (state) => {
            let result = false;

            // console.info(state.form.form_type);

            if (state.form.form_kind == "read") {
                result = true;
            }

            return result;
        },
    },
}

export default JobOrder;
