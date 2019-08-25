import Home from "@/pages/home/Home";
import Activity from "@/pages/activity/Activity";

export default [
    {
        path: '/' ,
        name: 'home',
        component: Home
    },
    {
        path: 'activities' ,
        name: 'activities',
        component: Activity
    }
]
