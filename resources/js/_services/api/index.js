/**
 *
 * Services that connect directly to SOLO API
 * Only API Endpoints that are public or those that
 * do not need an authentication to call should be used here
 *
 */

import TodoService from './todo.service'
import ActivityService from './activity.service'

let Todo = new TodoService();
let Activity = new ActivityService();

export {
    Todo,
    Activity
}
