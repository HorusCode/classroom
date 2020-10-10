<template>
    <section>
        <div class="s-text--title s-mgb-3">
            Название курса: <strong>{{data.course}}</strong>
        </div>
        <div>
            <span class="box-title">Группы</span>
            <div class="controls-field justify-content-end">
                <div class="s-field s-field--grouped">
                    <div class="s-control">
                        <button class="s-btn" :class="{'s-btn--warning': groupsEditing}"
                                @click="groupsEditing = !groupsEditing; addingGroups = []">
                            {{ groupsEditing ? 'Отмена' : 'Редактировать' }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="s-table-wrapper">
                <table class="s-table s-fullwidth">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Группа</th>
                        <th v-if="groupsEditing">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(group, i) in data.groups" :key="group.id">
                        <td>{{ i + 1 }}</td>
                        <td>
                            <span>{{ group.group }}</span>
                        </td>
                        <td v-if="groupsEditing">
                            <button class="s-btn s-btn--danger s-outlined s-rounded s-small"
                                    @click="deleteGroup(group.id, i, $event)">
                                        <span class="s-icon">
                                            <i class="mdi mdi-delete"></i>
                                        </span>
                            </button>
                        </td>
                    </tr>
                    <tr v-for="(datum, idx) in $v.addingGroups.$each.$iter" :key="'add_group-'+idx">
                        <td></td>
                        <td>
                            <autocomplete
                                v-model="datum.$model.group"
                                :data="groups"
                                :loading="loading"
                                placeholder="Группа..."
                                class="w-1"
                                field="group"
                                :type="datum.id.$invalid ? 's-border--danger' : ''"
                                @input="searchDebounce('groups')"
                                @select="option => {addingGroups[idx] = option; datum.id.$model = option.id }"
                            ></autocomplete>
                        </td>
                        <td>
                            <button
                                type="button"
                                class="s-btn s-rounded s-outlined s-small"
                                @click="addingGroups.splice(idx, 1)"
                            >
                                <span class="s-icon">
                                    <i class="mdi mdi-delete-forever"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <table-useless-row v-if="groupsEditing" @add-new="addNewGroup" @save="attachGroups"
                                       :data="addingGroups" field="group"
                                       :send-disabled="$v.addingGroups.$invalid"></table-useless-row>
                    </tbody>
                </table>
                <div class="s-loader-mask" :class="{'s-active': loading}">
                    <div class="s-loader"></div>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <span class="box-title">Задания</span>
            <div class="controls-field justify-content-end">
                <div class="s-field s-field--grouped">
                    <div class="s-control">
                        <button class="s-btn s-btn--warning" @click="worksEditing = !worksEditing">Редактировать
                        </button>
                    </div>
                    <div class="s-control">
                        <button class="s-btn s-btn--success" @click="createWorkModal = true">Добавить</button>
                    </div>
                </div>
            </div>
            <div class="s-table-wrapper">
                <table class="s-table s-fullwidth">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Задание</th>
                        <th>Тип</th>
                        <th>Дата назначения</th>
                        <th>Дата окончания</th>
                        <th v-if="worksEditing">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(task, i) in data.works" :key="task.id">
                        <td>{{ i + 1 }}</td>
                        <td>
                            <span class="s-text--dashed" :title="task.description" v-tippy>{{ task.title }}</span>
                        </td>
                        <td>
                            <span>Тестирование</span>
                        </td>
                        <td>
                            <span>{{ task.created_at }}</span>
                        </td>
                        <td>
                            <span>{{ task.complete_in }}</span>
                        </td>
                        <td v-if="worksEditing">
                            <button class="s-btn s-btn--danger s-outlined s-rounded s-small"
                                    @click="deleteTask(task.id, i, $event)">
                                        <span class="s-icon">
                                            <i class="mdi mdi-delete"></i>
                                        </span>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="s-loader-mask" :class="{'s-active': loading}">
                    <div class="s-loader"></div>
                </div>
            </div>
            <modal v-model="createWorkModal">
                <create-work :course-id="dataId"/>
            </modal>
        </div>
        <hr>
        <div>
            <span class="box-title">Расписание заданий</span>
            <calendar :events="[]"></calendar>
        </div>
    </section>
</template>

<script>
    // TODO: Create show course data
    import TableUselessRow from "./Helpers/TableUselessRow";
    import Autocomplete from "./Helpers/Autocomplete";
    import debounce from "lodash/debounce";
    import unionBy from "lodash/unionBy";
    import {maxLength, required} from "vuelidate/lib/validators";
    import Calendar from "./Calendar";
    import Modal from "./Helpers/Modal";
    import CreateWork from "./Includes/CreateWork";


    export default {
        name: "CoursesShow",
        components: {CreateWork, Modal, Calendar, Autocomplete, TableUselessRow},
        props: {
            dataId: {
                type: [Number, String],
                required: true
            }
        },
        data() {
            return {
                data: {},
                loading: false,
                groupsEditing: false,
                worksEditing: false,
                addingGroups: [],
                groups: [],
                createWorkModal: false
            }
        },
        mounted() {
            this.getData();
        },
        validations() {
            return {
                addingGroups: {
                    maxLength: maxLength(10),
                    required,
                    $each: {
                        id: {
                            isDuplicate(id) {
                                return this.data.groups.filter(v => v.id === id).length === 0 && this.addingGroups.filter(v => v.id === id).length === 1;
                            },
                            required
                        }
                    },
                },
                addingWorks: {
                    maxLength: maxLength(10),
                    required,
                    $each: {
                        task_id: {
                            isDuplicate(id) {
                                return this.data.works.filter(v => v.task_id === id).length === 0 && this.addingWorks.filter(v => v.task_id === id).length === 1;
                            },
                            required
                        },
                    },
                },
            };
        },
        methods: {
            getData: function () {
                this.loading = true;
                axios.get(`/courses/${this.dataId}?with=groups,works`).then(({data}) => {
                    this.data = data.data;
                }).finally(() => this.loading = false);
            },

            searchDebounce: debounce(function (value) {
                this.search(value);
            }, 800),
            search: function (value) {
                axios.get(`/search/groups`, {
                    params: {
                        group: value
                    }
                }).then(response => {
                    this.groups = response.data.data;
                });
            },
            addNewGroup: function () {
                this.addingGroups.push({
                    group: '',
                    id: null
                })
            },
            deleteGroup: function (id, idx, event) {
                event.target.classList.add('s-loading');
                axios.post(`/courses/${this.data.id}/detach`, {
                    groups: [id]
                }).then(() => {
                    this.data.groups.splice(idx, 1);
                }).finally(() => {
                    event.target.classList.remove('s-loading');
                })
            },

            attachGroups: function () {
                axios.post(`/courses/${this.dataId}/attach`, {
                    groups: this.addingGroups.map(obj => obj.id)
                }).then(({data}) => {
                    this.data.groups = unionBy(this.data.groups, this.addingGroups, 'id');
                    this.addingGroups = [];
                    // TODO: Create open status message
                }).finally(() => {
                    this.groupsEditing = false;
                });
            },

            deleteTask: function (id, idx, event) {
                event.target.classList.add('s-loading');
                axios.post(`/courses/${this.data.id}/detach`, {
                    works: [id]
                }).then(() => {
                    this.data.works.splice(idx, 1);
                }).finally(() => {
                    event.target.classList.remove('s-loading');
                })
            },
        }
    }
</script>


