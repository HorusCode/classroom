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
                    @select="option => {selected = option; groupName = option.group}"
                ></autocomplete>
            </div>
            <div class="s-field">
                <fieldset :disabled="data.length === 0">

                    <label v-for="category in categories" :key="category.field" class="s-checkbox">
                        <input type="checkbox" :value="category" v-model="selectCategory">
                        {{ category.label }}
                    </label>

                </fieldset>
            </div>
        </div>
        <div class="s-table-wrapper">
            <table class="s-table s-fullwidth">
                <thead>
                <tr>
                    <th>№</th>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>E-mail</th>
                    <th v-if="!statusData.status">Действия</th>
                </tr>
                </thead>
                <tbody >
                <tr v-for="(s, i) in filteredItems" :key="i">
                    <td>{{ i + 1 }}</td>
                    <td>
                        <span>{{ s.id }}</span>
                    </td>
                    <td>
                        <span :class="{'s-text--danger': !s.activate}">{{ getFullName(s) }}</span>
                    </td>
                    <td>
                        <span :class="{'s-text--danger': !s.email_verified_at}">{{ s.email }}</span>
                    </td>
                    <td v-if="statusData.status !== 200">
                        <button
                            type="button"
                            class="s-btn s-rounded s-outlined"
                            @click="removePeople(s.id, i)"
                        >
                            <span class="mdi mdi-delete-forever"/>
                        </button>
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
    import debounce from "lodash/debounce";
    import delay from "lodash/delay";
    import {fullName} from "../utils/mixins";

    export default {
        name: "ShowPeople",
        mixins: [fullName],
        data() {
            return {
                categories: [{
                    field: 'activate',
                    value: false,
                    label: 'Не активные'
                }, {
                    field: 'email_verified_at',
                    value: null,
                    label: 'Не подтвержденные'
                }],
                selectCategory: [],
                data: [],
                groupName: '',
                selected: null,
                groups: [],
                loading: false,
                statusData: {},
            }
        },
        watch: {
            selected: function (newState) {
                if (newState !== null) {
                    this.getData();
                }
            }
        },
        computed: {
            filteredItems: function () {
                return this.selectedItems;
            },
            selectedItems: function () {
                if (this.selectCategory.length !== 0) {
                    return this.data.filter(item => {
                        return this.selectCategory.every(category => category.value == item[category.field]);
                    });
                }
                return this.data;
            }
        },
        methods: {
            removePeople: function (id, idx) {
                axios.delete(`/students/${id}?group=${this.selected.id}`).then(() => {
                    this.data.splice(idx, 1);
                }).catch(({response}) => {
                    this.statusData = response;
                })
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
            getData: function () {
                this.statusData = {};
                this.loading = true;
                axios.get(`/groups/students/${this.selected.id}`)
                    .then(({data}) => {
                        this.data = data.data;
                    })
                    .catch(data => {
                        console.log(data.response);
                    }).finally(() => this.loading = false);
            }
        }
    }
</script>

