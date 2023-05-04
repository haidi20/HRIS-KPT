import Vue from 'vue';
import Vuex from 'vuex';
import axios from "axios";
import moment from "moment";

import Roster from "./Roster";
import JobOrder from "./JobOrder";
import Employee from "./Employee";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        roster: Roster,
        jobOrder: JobOrder,
        employee: Employee,
    },
    state: {
        user: {},
        permissions: [],
        base_url: null,
        name_menu: null,
        permission: {
            is_edit: true,
            is_delete: true,
        },
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
        INSERT_USER(state, payload) {
            state.user = payload.user;
        },
        INSERT_NAME_MENU(state, payload) {
            state.name_menu = payload.name_menu;
        },
        UPDATE_PERMISSION_IS_EDIT(state, payload) {
            state.permission.is_edit = payload.value;
        },
        UPDATE_PERMISSION_IS_DELETE(state, payload) {
            state.permission.is_delete = payload.value;
        },
        INSERT_PERMISSIONS(state, payload) {
            state.permissions = payload.permissions;
        },
    },
    actions: {
        //
    },
    getters: {
        //
    }
})

export default store;
