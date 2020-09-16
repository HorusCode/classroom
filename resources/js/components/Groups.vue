<template>
    <section>
        <transition>
            <div
                v-if="openAlert"
                class="s-notification"
                :class="[statusData.status === 200 ? 's-bg--success' : 's-bg--danger']"
            >
                <button class="s-delete" @click="openAlert = false"></button>
                <h2 class="s-text--title s-size--6">{{ statusData.data.message }}</h2>
                <ul v-if="statusData.data.hasOwnProperty('errors')">
                    <li v-for="(e, i) in statusData.data.errors" :key="i">{{e[0]}}</li>
                </ul>
            </div>
        </transition>
        <div class="controls-field">
            <div class="s-field">
                <div class="s-control s-with-icon-left">
                    <span class="s-icon s-left">
                        <i class="mdi mdi-search-web"></i>
                    </span>
                    <input type="text" class="s-input" placeholder="Поиск..." v-model="searchWord">
                </div>
            </div>
        </div>
        <div class="s-table-wrapper">
            <table class="s-table s-fullwidth">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Группа</th>
                    <th>Кол-во студентов</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody >
                <table-useless-row @add-new="addNew" @save="saveData" :data="addingData" :send-disabled="$v.addingData.$invalid"/>
                <tr v-for="(s, i) in filtered" :key="s.id">
                    <td>{{ i + 1 }}</td>
                    <td>
                        <span>{{ s.group }}</span>
                    </td>
                    <td>
                        <span>{{ s.users_count }}</span>
                    </td>
                    <td>
                        <button class="s-btn s-btn--danger s-outlined s-rounded s-small" @click="deleteData(s.id, i, $event)">
                            <span class="s-icon">
                                <i class="mdi mdi-delete"></i>
                            </span>
                        </button>
                    </td>
                </tr>
                <tr v-for="(data, i) in addingData">
                    <td></td>
                    <td>
                        <input type="text" class="s-input s-rounded w-1" :class="{'s-border--danger': $v.addingData.$each[i].$invalid}" v-model="data.group">
                    </td>
                    <td>
                        <span>{{ data.users_count }}</span>
                    </td>
                    <td>
                        <button class="s-btn s-btn--danger s-outlined s-rounded s-small" @click="removeData(i)">
                            <span class="s-icon">
                                <i class="mdi mdi-delete"></i>
                            </span>
                        </button>
                    </td>
                </tr>
                <table-useless-row @add-new="addNew" @save="saveData" :data="addingData" :send-disabled="$v.addingData.$invalid"/>
                </tbody>
            </table>
            <div class="s-loader-mask" :class="{'s-active': loading}">
                <div class="s-loader"></div>
            </div>
        </div>
    </section>
</template>

<script>

    import {search} from '../utils/mixins'
    import TableUselessRow from "./Helpers/TableUselessRow";
    import {required,minLength} from "vuelidate/lib/validators";


    export default {
        name: "Groups",
        mixins: [search],
        components: {
          TableUselessRow
        },
        data() {
            return {
                data: [],
                searchWord: '',
                loading: false,
                openAlert: false,
                statusData: {},
                addingData: [],
            }
        },
        mounted() {
            this.getData();
        },
        validations() {
            return {
                addingData: {
                    required,
                    $each: {
                        group: {
                            required,
                            minLength: minLength(3),
                            isDuplicate(str) {
                                return this.addingData.filter(v => v.group === str).length === 1;
                            },
                        }
                    }
                }
            }
        },
        methods: {
            getData: function () {
                this.openAlert = false;
                this.statusData = {};
                this.loading = true;
                axios.get(`/groups`)
                    .then(({data}) => {
                        this.data = data.data;
                    })
                    .catch(data => {
                        this.openAlert = true;
                        this.statusData = data;
                    }).finally(() => this.loading = false);
            },
            addNew: function () {
                this.addingData.push({
                    group: '',
                    users_count: 0
                })
            },
            saveData: function () {
                this.loading = true;
                this.openAlert = false;
                this.statusData = {};
                axios.post('/groups', {
                    groups: this.addingData
                }).then(({data}) => {
                    data.data.forEach(obj => this.data.push(obj));
                    this.addingData = [];
                }).catch(data => {
                    this.openAlert = true;
                    this.statusData = data;
                }).finally(() => this.loading = false);
            },
            removeData: function (i) {
                this.addingData.splice(i, 1);
            },
            deleteData: function (id, idx, event) {
                event.target.classList.add('s-loading');
                this.openAlert = false;
                this.statusData = {};
                axios.delete(`/groups/${id}`).then(() => {
                    this.data.splice(idx, 1);
                }).catch(data => {
                    this.openAlert = true;
                    this.statusData = data;
                }).finally(() => {
                    event.target.classList.remove('s-loading');
                })
            }
        }
    }
</script>


