import axios from 'axios'

const tokenEl = document.querySelector('meta[name="csrf-token"]')
const TOKEN = tokenEl ? tokenEl.getAttribute('content') : null

const API = axios.create({
    headers: {
        'Content-Type': 'multipart/form-data',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': TOKEN || ''
    }
})

import { reactive } from 'vue';

export const response = reactive({})

export const { errors, success } = response.value ?? {}

export const useFormAPI = (METHOD, ACTION) => {
    const send = async (data) => {

        if (errors) {
            errors = {}
        }

        if (success) {
            success = {}
        }
        // let hasData = data.entries().next().done;
        try {
            let req = await API[METHOD.toLowerCase()](ACTION, data)
            let res = await req.data;
            response.success = res;
            return res
        } catch (err) {
            if (err.request) {
                let errors = JSON.parse(err.request.response)
                response.errors = errors.errors;
                return errors
            }
        }
    }

    return {
        send,
    }
}

