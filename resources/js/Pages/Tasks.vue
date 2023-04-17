<template>
    <div class="container">
        <div class="block">
            <button class="btn add" @click="() => showModal('add')">
                Add Task
            </button>
        </div>
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col col-1">#</div>
                <div class="col col-2">Task Name</div>
                <div class="col col-3">Status</div>
                <div class="col col-4">Edit</div>
                <div class="col col-5">Remove</div>
            </li>
            <li class="table-row" v-for="task in tasks" :key="task.id">
                <div class="col col-1">{{ task.id }}</div>
                <div class="col col-2">{{ task.title }}</div>
                <div class="col col-3">
                    <span class="status">{{ task.status }}</span>
                </div>
                <div class="col col-4">
                    <span class="btn-edit" @click="() => { setCurrentTask(task), showModal('edit'), currentData() }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>

                    </span>
                </div>
                <div class="col col-5">
                    <span class="btn-delete" @click="() => destroy(task.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </li>
        </ul>
        <div v-if="currentModal == 'add'" class="modal">
            <div class="modal-header">
                <span @click="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="close-icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                </span>
            </div>
            <div class="modal-body">
                <div class="form-wrapper">
                    <h1 class="form-title">Create New Task</h1>
                    <form @submit.prevent="addTask">
                        <input v-model="form.title" type="text" name="title" placeholder="Title">
                        <textarea v-model="form.body" placeholder="Text" name="body"></textarea>
                        <div class="select-wrapper">
                            <select v-model="form.status" name="status">
                                <option value="todo">ToDo</option>
                                <option value="complete">Complete</option>
                                <option value="reject">Reject</option>
                            </select>
                        </div>
                        <div class="form-footer">
                            <button class="modal-btn cencel" @click="closeModal">Cencel</button>
                            <button class="modal-btn add" type="submit">Add Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="currentModal == 'edit'" class="modal">
            <div class="modal-header">
                <span @click="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="close-icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                </span>
            </div>
            <div class="modal-body">
                <div class="form-wrapper">
                    <h1 class="form-title">Edit Task</h1>
                    <form @submit.prevent="() => editTask(currentTask.id)">
                        <input v-model="form.title" type="text" name="title">

                        <textarea v-model="form.body" name="body"></textarea>
                        <div class="select-wrapper">
                            <select v-model="form.status" name="status">
                                <option value="todo">ToDo</option>
                                <option value="complete">Complete</option>
                                <option value="reject">Reject</option>
                            </select>
                        </div>
                        <div class="form-footer">
                            <button class="modal-btn cencel" @click="closeModal">Cencel</button>
                            <button class="modal-btn add" type="submit">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>
  
<script>
import { Head } from "@inertiajs/inertia-vue";

export default {
    components: {
        Head,
    },
    props: {
        title: String,
        'tasks': Array,
    },
    methods: {
        showModal(modal) {
            this.currentModal = modal;
        },
        closeModal() {
            this.currentModal = null;
        },

        async addTask() {
            try {
                await this.$inertia.post(this.route('tasks.store'), this.form);
                this.closeModal();
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.formErrors = error.response.data.errors;
                    console.log(this.formErrors)
                }
            }
        },
        async editTask(id) {
            try {
                await this.$inertia.put(this.route('tasks.update', id), this.form);
                this.closeModal();
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.formErrors = error.response.data.errors;
                    console.log(this.formErrors)
                }
            }
        },
        destroy(id) {
            if (confirm("Are you sure?")) {
                this.$inertia.delete(this.route('tasks.destroy', id))
            }

        },
        setCurrentTask(task) {
            this.currentTask = task;
        },
        currentData() {
            this.form.title = this.currentTask ? this.currentTask.title : null;
            this.form.body = this.currentTask ? this.currentTask.body : null;
            this.form.status = this.currentTask ? this.currentTask.status : null;
        }
    },
    data() {
        return {
            currentModal: null,
            currentTask: null,
            form: {
                title: null,
                body: null,
                status: null,
            },
        };
    },
}
</script>





