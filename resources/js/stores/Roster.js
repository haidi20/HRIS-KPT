import axios from "axios";
import moment from "moment";

const defaultForm = {

}

const Roster = {
    namespaced: true,
    state: {
        base_url: null,
        data: [
            {
                id: "001-050523",
                name: "perbaikan mesin kapal",
            }
        ],
        params: {
            date_filter: new Date(),
        },
        form: { ...defaultForm },
        options: {
            //
        },
        loading: {
            table: false,
        },
    },
    mutations: {
        INSERT_BASE_URL(state, payload) {
            state.base_url = payload.base_url;
        },
    },
    actions: {
        // onIncrement: (context, payload) => {
        //     context.commit("INCREMENT");
        // },

    }
}

export default Roster;
