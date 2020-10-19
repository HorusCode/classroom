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
                <autocomplete
                    v-model="groupName"
                    :data="groups"
                    :loading="loading"
                    placeholder="Группа..."
                    field="group"
                    @input="searchDebounce"
                    @select="option => {selected = option; groupName = option.group}"
                ></autocomplete>
            </div>
            <div class="s-field s-field--grouped">
                <div class="composed-label">
                    <label class="s-label">Добавить:</label>
                    <h2 class="subtitle" :class="{'s-text--danger': !$v.data.maxLength}">{{ data.length }} / {{
                        actualCount }}</h2>
                </div>
                <div class="s-control s-mgr-2">
                    <input type="text"
                           v-model.number="count"
                           @keypress="validateCount"
                           placeholder="Кол-во людей..."
                           class="s-input">
                </div>
                <div class="s-control">
                    <div class="s-btn-group">
                        <button class="s-btn" @click="generatePeople"
                                :disabled="$v.count.$invalid || statusData.status === 200">
                            <span class="s-icon">
                                <i class="mdi mdi-plus"></i>
                            </span>
                        </button>
                        <button class="s-btn" @click="data = []">
                            <span class="s-icon">
                                <i class="mdi mdi-delete-forever"></i>
                            </span>
                        </button>
                        <button v-if="statusData.status !== 200" class="s-btn" @click="sendData"
                                :disabled="isDisableSend">
                            <span class="s-icon">
                                <i class="mdi mdi-account-edit-outline"></i>
                            </span>
                        </button>
                        <button v-else class="s-btn" @click="refreshData">
                            <span class="s-icon">
                                <i class="mdi mdi-refresh"></i>
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
                <th>Телефон</th>
                <th>E-mail</th>
                <th>Ключ</th>
                <th v-if="!statusData.status">Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(s, i) in data" :key="i">
                <td>{{ i + 1 }}</td>
                <td>
                    <input
                        v-model="s.phone"
                        v-if="statusData.status !== 200"
                        type="text"
                        class="s-input"
                        :class="{'s-border--danger': $v.data.$each[i].phone.$invalid}"
                    />
                    <span v-else>{{ s.phone }}</span>
                </td>
                <td>
                    <input
                        v-model="s.email"
                        v-if="statusData.status !== 200"
                        type="text"
                        class="s-input"
                        :class="{'s-border--danger': $v.data.$each[i].email.$invalid}"
                    />
                    <span v-else>{{ s.email }}</span>
                </td>
                <td>{{ s.login_code }}</td>
                <td v-if="statusData.status !== 200">
                    <button
                        type="button"
                        class="s-btn s-rounded s-outlined"
                        @click="removePeople(i)"
                    >
                        <span class="s-icon">
                            <i class="mdi mdi-delete-forever"></i>
                        </span>
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
    import {maxValue, numeric, email, maxLength, minLength} from "vuelidate/lib/validators";


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
                statusData: {},
            }
        },
        validations() {
            return {
                count: {
                    maxValue: maxValue(this.actualCount - this.data.length),
                    minValue: (val) => val !== ("" && 0),
                    numeric,
                },

                data: {
                    maxLength: maxLength(this.actualCount),
                    empty: (arr) => arr.length > 0,
                    $each: {
                        email: {
                            email,
                            isDuplicate(email) {
                                return this.data.filter(v => v.email === email).length === 1;
                            },
                            empty: val => val.length > 0,
                        },
                        phone: {
                            isPhone(value) {
                                return /^((\+7|7|8)+([0-9]){10})$/.test(value);
                            },
                            isDuplicate(phone) {
                                return this.data.filter(v => v.phone === phone).length === 1;
                            },
                        }
                    },
                },
            };
        },
        computed: {
            isDisableSend: function () {
                return this.selected === null || this.selected.group !== this.groupName || this.$v.$invalid;
            },
            actualCount: function () {
                if (this.selected !== null) {
                    return this.maxCount - this.selected.users_count;
                } else {
                    return this.maxCount;
                }

            }
        },
        methods: {
            validateCount: function (ev) {
                if (!/\d/.test(ev.key) || !this.$v.count.maxValue) {
                    return ev.preventDefault();
                }
            },
            generatePeople: function () {
                if ((this.data.length + this.count) <= this.actualCount) {
                    for (let i = 0; i < this.count; i ++) {
                        this.data.push({
                            email: `test${i}@mail.ru`,
                            phone: "+79061220846",
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
            refreshData: function () {
                Object.assign(this.$data, this.$options.data.apply(this))
            },
            sendData: function () {
                this.openAlert = false;
                this.statusData = {};
                axios.post("/students", {
                    group: this.selected.id,
                    data: this.data
                })
                    .then(data => {
                        console.log(data);
                        this.statusData = data;
                        this.openAlert = true;
                        delay(() => {
                            this.openAlert = false;
                        }, 10000)
                    })
                    .catch(data => {
                        this.statusData = data;
                        this.openAlert = true;
                    });
            }
        }
    }
</script>

<style scoped lang="scss">
    .composed-label {
        margin-right: 1rem;
        line-height: normal;

        .s-label {
            margin: 0;
        }
    }
</style>
