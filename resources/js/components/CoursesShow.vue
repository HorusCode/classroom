<template>
    <div class="s-row">
        <div class="s-col-desk-6">
            <div class="controls-field justify-content-end">
                <div class="s-field s-field--grouped">
                    <div class="s-control">
                        <button class="s-btn" :class="{'s-btn--warning': groupsEditing}"
                                @click="groupsEditing = !groupsEditing">
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
                                @input="searchDebounce"
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
                                       :data="addingGroups" field="group" :send-disabled="$v.addingGroups.$invalid"></table-useless-row>
                    </tbody>
                </table>
                <div class="s-loader-mask" :class="{'s-active': loading}">
                    <div class="s-loader"></div>
                </div>
            </div>
        </div>
        <div class="s-col-desk-6">
            <div class="s-field">
                Название курса: <strong>Математика</strong>
            </div>
            <div class="s-btn-group">
                <button class="s-btn">
                    <span class="s-icon">
                        <i class="mdi mdi-pencil-box"></i>
                    </span>
                    <span>Просмотреть задания</span>
                </button>
                <button class="s-btn">
                    <span class="s-icon">
                        <i class="mdi mdi-chart-bar"></i>
                    </span>
                    <span>Статистика</span>
                </button>
                <button class="s-btn">
                    <span class="s-icon">
                        <i class="mdi mdi-calendar"></i>
                    </span>
                    <span>Календарь</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    // TODO: Create show course data
    import TableUselessRow from "./Helpers/TableUselessRow";
    import Autocomplete from "./Helpers/Autocomplete";
    import debounce from "lodash/debounce";
    import unionBy from "lodash/unionBy";
    import {maxLength, required} from "vuelidate/lib/validators";

    export default {
        name: "CoursesShow",
        components: {Autocomplete, TableUselessRow},
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
                addingGroups: [],
                groups: []
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
            };
        },
        methods: {
            getData: function () {
                this.loading = true;
                axios.get(`/courses/${this.dataId}`).then(({data}) => {
                    this.data = data.data;
                }).finally(() => this.loading = false);
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
            searchDebounce: debounce(function (value) {
                this.search(value);
            }, 800),
            search: function (value) {
                axios.get('/search/groups', {
                    params: {
                        group: value,
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
            }
        }
    }
</script>

<style scoped>

</style>
