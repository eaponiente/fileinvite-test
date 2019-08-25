import BaseService from '../base.service'

export default class ActivityService extends BaseService {

    constructor() {
        super();

        this.baseUrl = process.env.MIX_APP_URL + '/api/v1/activities';
    }

    /**
     * Get all the activities in this menu
     *
     * Endpoint: /activities
     *
     * @returns {AxiosPromise<any>}
     */
    all() {
        let url = this.baseUrl;

        return super.get(url);
    }

    /**
     * Fetch a certain activity
     *
     * Endpoint: /activities/{todoId}
     *
     * @returns {AxiosPromise<any>}
     * @param todoId
     */
    find(activityId) {
        let url = this.baseUrl + '/' + activityId;

        return super.get(url)
    }

    /**
     * Store activity
     *
     * @param params
     */
    store(params) {
        let url = this.baseUrl;

        return super.post(url, params);

    }
}
