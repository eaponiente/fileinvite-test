<template>
    <b-container>
        <b-row>
            <b-col md="12">
                <button v-b-modal.modal-1 class="btn btn-primary float-right" style="margin: 10px 0;">Create a task todo</button>

                <table class="table table-striped" v-if="todos.length">
                    <tr>
                        <th>Task Name</th>
                        <th>Mark if completed</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="todo in todos">
                        <td :class="todo.completed == 1 ? 'completed' : ''">{{todo.task}}</td>
                        <td><input type="checkbox" :checked="todo.completed == 1" @change="markComplete($event, todo)"></td>
                        <td><button class="btn btn-sm btn-danger" @click="deleteTodo(todo)">Delete</button></td>
                    </tr>
                </table>
            </b-col>
        </b-row>

        <b-modal id="modal-1" title="Add todo" hide-footer>
            <b-form @submit.prevent="addTodo" method="POST">
                <b-form-group
                        id="input-group-1"
                        label="Enter your todo here"
                        label-for="input-1"
                >
                    <b-form-textarea
                            id="textarea"
                            v-model="text"
                            rows="3"
                            max-rows="6"
                    ></b-form-textarea>
                </b-form-group>

                <b-button type="submit" variant="primary">Submit</b-button>
                <b-button type="reset" variant="danger">Reset</b-button>
            </b-form>
        </b-modal>
    </b-container>
</template>

<script>
    import {Todo} from '@/_services/api'

    export default {
        name: 'Home',
        data() {
            return {
                todos: [],
                text: ''
            }
        },
        mounted() {
            this.getTodos();
        },
        methods: {
            getTodos(){
                Todo.all().then((response) => {
                    this.todos = [];

                    response.data.forEach((item) => {
                        this.todos.push({
                            id: item.id,
                            task: item.name,
                            completed: item.completed
                        });
                    })
                });
            },

            addTodo() {
                Todo.store({name: this.text}).then((response) => {
                    this.$bvModal.hide('modal-1')
                    this.text = ''

                    this.getTodos()
                });
            },

            deleteTodo(item) {
                Todo.delete(item.id).then((response) => {
                    this.getTodos()
                })
            },

            markComplete(event, todo) {
                if(event.target.checked) {
                    Todo.update(todo.id, {completed: 1}).then((response) => {
                        this.getTodos()
                    })
                } else {
                    Todo.update(todo.id, {completed: 0}).then((response) => {
                        this.getTodos()
                    })
                }
            }
        }
    }
</script>