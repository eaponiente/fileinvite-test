import axios from 'axios'

let baseService = class BaseService {

    constructor() {
        this.headers = {};
        this.$http = axios.create({
            timeout: 10000,
        });
    }

    /**
     * Returns default headers list which will be used with every request.
     *
     * @param additionalHeaders
     * @param multipart
     * @returns {{}}
     */
    getHeaders(additionalHeaders = {}, multipart = false) {
        let defaultHeaders = this.headers;

        if (multipart) {
            defaultHeaders = {}
        }

        return {
            ...defaultHeaders,
            ...additionalHeaders
        }
    }

    /**
     *
     * @param url string
     * @param params
     * @returns string
     */
    prepareUrl(url, params = {}){
        for( let index in params) {
            let identifier = ':' + index;
            url = url.replace(identifier, params[index]);
        }
        return url;
    }

    /**
     * Returns formatted query string from object
     *
     * @param params
     * @returns {string}
     */
    getQueryString(params) {
        return (
            Object
                .keys(params)
                .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
                .join('&')
        )
    }

    /**
     * Wraps axios and provides more convenient post method calls with payload data
     *
     * @param uri
     * @param data
     * @param additionalHeaders
     * @returns {AxiosPromise<any>}
     */
    post(uri, data, additionalHeaders = {}) {
        return this.$http.post(uri, data, {
            headers: this.getHeaders(additionalHeaders),
            // withCredentials: true
        })
    }


    /**
     * Wraps axios and provides more convenient put method calls with data
     *
     * @param uri
     * @param data
     * @param additionalHeaders
     * @returns {AxiosPromise<any>}
     */
    put(uri, data, additionalHeaders = {}) {
        return this.$http.put(uri, data, {
            headers: this.getHeaders(additionalHeaders),
            // withCredentials: true
        })
    }

    /**
     * Wraps axios and provides more convenient put method calls with data
     *
     * @param uri
     * @param data
     * @param additionalHeaders
     * @returns {AxiosPromise<any>}
     */
    patch(uri, data, additionalHeaders = {}) {
        return this.$http.patch(uri, data, {
            headers: this.getHeaders(additionalHeaders),
            // withCredentials: true
        })
    }

    /**
     * Wraps axios and provides
     * more convenient delete method
     *
     * @param uri
     * @param additionalHeaders
     * @returns {AxiosPromise}
     */
    remove(uri, additionalHeaders = {}) {
        return this.$http.delete(uri, {
            headers: this.getHeaders(additionalHeaders),
            // withCredentials: true
        })
    }

    /**
     * Wraps axios and provides
     * more convenient get method
     * calls with data.
     *
     * @param uri
     * @param data
     * @param additionalHeaders
     * @returns {AxiosPromise<any>}
     */
    get(uri, data = {}, additionalHeaders = {}) {
        if (Object.keys(data).length > 0) {
            uri = `${uri}?${this.getQueryString(data)}`
        }

        return this.$http.get(uri, {
            headers: this.getHeaders(additionalHeaders),
            // withCredentials: true
        })
    }

    /**
     * @param uri
     * @param data
     * @param additionalHeaders
     * @returns {Promise<Response>}
     */
    upload(uri, data, additionalHeaders = {}) {
        return fetch(uri, {
            headers: this.getHeaders(additionalHeaders, true),
            cors: true,
            method: 'POST',
            body: data
        })
    }
};

export default baseService
