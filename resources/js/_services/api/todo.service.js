import BaseService from '../base.service'

export default class TodoService extends BaseService {

    constructor() {
        super();

        this.baseUrl = process.env.MIX_APP_URL + '/api/v1/todos';
    }

    /**
     * Get all the todos in this menu
     *
     * Endpoint: /todos
     *
     * @returns {AxiosPromise<any>}
     */
    all() {
        let url = this.baseUrl;

        return super.get(url);
    }

    /**
     * Find todo by id
     *
     * @param todoId
     */
    find(todoId) {
        let url = this.baseUrl + '/' + todoId;

        return super.get(url)
    }

    /**
     * Store todo
     *
     * @param params
     */
    store(params) {
        let url = this.baseUrl;

        return super.post(url, params);
    }

    /**
     * Update todo
     *
     * @param todoId
     * @param params
     */
    update(todoId, params) {
        let url = this.baseUrl + '/' + todoId;

        return super.patch(url, params);
    }

    /**
     * Delete todo
     *
     * @param todoId
     * @returns {AxiosPromise<any>}
     */
    delete(todoId) {
        let url = this.baseUrl + '/' + todoId;

        return super.remove(url);
    }
}
