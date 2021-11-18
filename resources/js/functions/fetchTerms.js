import { contentAPI } from "./contentAPI"

export const fetchTerms = async (HANDLE) => {
    let res;

    try {
        let req = await contentAPI.get(`/taxonomies${HANDLE}`)
        res = await req.data
    } catch (err) {
        if (err.request) {
            let errors = JSON.parse(err.request.response)
            res = errors
        }
    }

    return res
}
