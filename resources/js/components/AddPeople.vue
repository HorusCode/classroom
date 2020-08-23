<template>
    <section>
        <div class="controls-field">
            <div class="s-field">
                <autocomplete
                    v-model="groupName"
                    :data="groups"
                    :loading="loading"
                    placeholder="Группа..."
                    field="group"
                    @input="searchDebounce"
                    @select="option => selected = option"
                ></autocomplete>
            </div>
            <div class="s-field s-field--grouped">
                <label class="s-field--label s-label">Кол-во людей:</label>
                <div class="s-control s-mgr-2">
                    <input type="text" v-model="count" placeholder="Кол-во людей..." class="s-input">
                </div>
                <div class="s-control">
                    <div class="s-btn-group">
                        <button class="s-btn" @click="generatePeople">
                            <span class="s-icon">
                                <i class="mdi mdi-plus"></i>
                            </span>
                        </button>
                        <button class="s-btn" @click="data = []">
                            <span class="s-icon">
                                <i class="mdi mdi-delete-forever"></i>
                            </span>
                        </button>
                        <button class="s-btn">
                            <span class="s-icon">
                                <i class="mdi mdi-account-edit-outline"></i>
                            </span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <table class="s-table s-fullwidth">
            <thead>
            <tr>
                <th>№</th>
                <th>E-mail</th>
                <th>Ключ</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(s, i) in data" :key="i">
                <td>{{ i + 1 }}</td>
                <td>
                    <input
                        v-model="s.email"
                        type="text"
                        class="s-input"
                    />
                </td>
                <td>{{ s.login_code }}</td>
                <td>
                    <button
                        type="button"
                        class="s-btn s-rounded s-outlined"
                        @click="removePeople(i)"
                    >
                        <span class="mdi mdi-delete-forever"/>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
</template>

<script>

    import Autocomplete from "./Helpers/Autocomplete";
    import delay from 'lodash/delay';
    import debounce from 'lodash/debounce';

    export default {
        name: "AddPeople",
        components: {Autocomplete},
        data() {
            return {
                data: [],
                count: 1,
                groupName: '',
                selected: null,
                groups: [],
                loading: false,
                maxCount: 35,
                openAlert: false,
                statusData: {}
            }
        },
        methods: {
            generatePeople: function () {
                for (let i = 0; i < this.count; i ++) {
                    if (this.data.length < this.maxCount) {
                        this.data.push({
                            email: "",
                            login_code: Math.random()
                                .toString(36)
                                .substr(2, 10)
                                .toUpperCase()
                        });
                    }
                }
            },
            removePeople: function (idx) {
                this.data.splice(idx, 1);
            },
            searchDebounce: debounce(function (value) {
                this.search(value);
            }, 800),
            search: function (value) {
                this.loading = true;
                axios.get('/search/groups', {
                    params: {
                        group: value,
                    }
                }).then(response => {
                    this.groups = response.data.data;
                    this.loading = false;
                });
            },
            sendData: function () {
                this.statusData = {};
                axios.post("/students", {
                    group: this.selectedGroup.id,
                    data: this.data
                })
                    .then(({data}) => {
                        this.statusData = data;
                        this.openAlert = true;
                        delay(() => {
                            this.openAlert = false;
                        }, 10000)
                    })
                    .catch(data => {
                        this.statusData = data.response.data;
                        this.openAlert = true;
                        delay(() => {
                            this.openAlert = false;
                        }, 10000)
                    });
            }
        }
    }
</script>

<style scoped>

</style>
