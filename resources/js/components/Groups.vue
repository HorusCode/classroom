<template>
    <section>
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
                </tr>
                </thead>
                <tbody >
                <tr v-for="(s, i) in filtered" :key="s.id">
                    <td>{{ i + 1 }}</td>
                    <td>
                        <span>{{ s.group }}</span>
                    </td>
                    <td>
                        <span>{{ s.users_count }}</span>
                    </td>
                </tr>
                <tr v-for="(data, i) in addingData">
                    <td>
                        <button class="s-btn s-btn--danger s-outlined s-rounded s-small" @click="removeData(i)">
                            <span class="s-icon">
                                <i class="mdi mdi-delete"></i>
                            </span>
                        </button>
                    </td>
                    <td>
                        <input type="text" class="s-input s-rounded w-1" v-model="data.group">
                    </td>
                    <td>
                        <span>{{ data.users_count }}</span>
                    </td>
                </tr>
                <tr class="s-table__field">
                    <td colspan="3">
                        <div class="row-wrapper s-center">
                            <div class="s-btn-group">
                                <button class="s-btn s-btn--primary s-light" @click="addNew">Добавить</button>
                                <button class="s-btn s-btn--success" @click="saveData" v-if="addingData.length > 0">Сохранить</button>
                            </div>

                        </div>
                    </td>
                </tr>
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

    export default {
        name: "Groups",
        mixins: [search],
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
        methods: {
            getData: function () {
                this.statusData = {};
                this.loading = true;
                axios.get(`/groups`)
                    .then(({data}) => {
                        this.data = data.data;
                    })
                    .catch(data => {
                        console.log(data.response);
                    }).finally(() => this.loading = false);
            },
            addNew: function () {
                this.addingData.push({
                    group: '',
                    users_count: 0
                })
            },
            saveData: function () {
                axios.post('/groups', {

                })
            },
            removeData: function (i) {
                this.addingData.splice(i, 1);
            }
        }
    }
</script>

<style scoped>

</style>
