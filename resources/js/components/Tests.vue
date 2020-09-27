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
            <div class="s-field s-field--grouped">
                <div class="s-control">
                    <div class="s-btn-group">
                        <button class="s-btn s-btn--primary s-outlined">
                            Создать
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="s-table-wrapper">
            <table class="s-table s-fullwidth">
                <thead>
                <tr>
                    <th>Название теста</th>
                    <th>Количество вопросов</th>
                    <th>Создан</th>
                    <th>Правлен</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(test, i) in filtered" :key="test.id">
                    <td>{{ test.title }}</td>
                    <td>
                        <span>{{ test.questions.length }}</span>
                    </td>
                    <td>
                        <span>{{moment.utc(test.created_at).local().format("HH:mm DD.MM.YY")}}</span>
                    </td>
                    <td>
                        <span>{{moment.utc(test.updated_at).local().format("HH:mm DD.MM.YY")}}</span>
                    </td>
                    <td>
                        <div class="s-field">
                            <div class="s-btn-group">
                                <button class="s-btn s-btn--info s-outlined s-rounded s-small"
                                        @click="updateModalTest(test)">
                                    <span class="s-icon">
                                        <i class="mdi mdi-pen"></i>
                                    </span>
                                </button>
                                <button class="s-btn s-btn--danger s-outlined s-rounded s-small"
                                        @click="deleteData(test.id, i, $event)">
                                    <span class="s-icon">
                                        <i class="mdi mdi-delete"></i>
                                    </span>
                                </button>
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
        <modal v-model="showModal"
               :destroy-on-hide="false"
               full-screen
               has-modal-card>
            <test-editing></test-editing>
        </modal>
    </section>
</template>

<script>
    import moment from "moment";
    import {search} from "../utils/mixins";
    import Modal from "./Helpers/Modal";
    import TestEditing from "./Includes/TestEditing";
    import Filemanager from "./Includes/Filemanager";


    export default {
        name: "Tests",
        components: {Filemanager, Modal, TestEditing},
        mixins: [search],
        data() {
            return {
                showModal: false,
                updatingTest: {},
                moment: moment,
                data: [],
                searchWord: '',
                loading: false,
                openAlert: false,
                statusData: {},
            };
        },
        mounted() {
            this.loadData();
        },
        methods: {
            updateModalTest(test) {
                this.updatingTest = test;
                this.showModal = true;
            },
            deleteData(id, idx, event) {
                this.loading = true;
                axios.delete(`/testing/${id}`).then(({data}) => {
                    this.data.splice(idx, 1);
                }).finally(() => this.loading = false);
            },
            loadData() {
                this.loading = true;
                axios.get('/testing').then(({data}) => {
                    this.data = data.data;
                }).finally(() => this.loading = false);
            },
        },
    }
</script>

