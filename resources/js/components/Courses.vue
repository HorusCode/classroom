<template>
    <section>
        <div class="controls-field">
            <div class="s-field s-field--grouped">
                <div class="s-control">
                    <button class="s-btn s-btn--info" @click="createDataModal = true">
                        Добавить
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <div class="s-row" v-if="loading">
            <div class="s-col-desk-12" style="position: relative">
                <div class="s-loader-mask s-active">
                    <div class="s-loader"></div>
                </div>
            </div>
        </div>
        <div class="s-row" v-else-if="data.length > 0">
            <div class="s-col-desk-3" v-for="(item, i) in data" :key="item.id">
                <a :href="`/courses/${item.id}`">
                    <div class="s-card">
                        <div class="s-card__media">
                            <figure class="s-image">
                                <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                            </figure>
                        </div>
                        <div class="s-card__content">
                            <h2 class="card-content-title">{{item.course}}</h2>
                        </div>
                        <div class="s-card__footer">
                            <a class="s-card-footer__item" @click.prevent="removeData(item, i)">
                                <span class="s-icon">
                                    <i class="mdi mdi-delete-forever"></i>
                                </span>
                            </a>
                            <a class="s-card-footer__item">
                                <span class="s-icon">
                                    <i class="mdi mdi-stop"></i>
                                </span>
                            </a>
                            <a class="s-card-footer__item" @click.prevent="editData(item, i)">
                                  <span class="s-icon">
                                    <i class="mdi mdi-rename-box"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </a>

            </div>
        </div>
        <div class="s-row" v-else>
            <div class="s-col-desk-12">
                <div class="d-flex centered-items">
                    <span class="s-text--title">Нет информации</span>
                </div>
            </div>
        </div>
        <modal v-model="createDataModal" :can-cancel="['escape', 'x']" :width="320">
            <div class="s-modal__card" style="width: auto">
                <header class="s-modal__card-header">
                    <div class="s-modal__card-title">
                        <span class="s-size--4">
                            Создание нового курса
                        </span>
                    </div>
                </header>
                <section class="s-modal__card-body">
                    <div class="s-field">
                        <label class="s-label">Название</label>
                        <div class="s-control">
                            <input type="text" v-model="courseName" class="s-input" placeholder="Название курса...">
                        </div>
                    </div>
                    <label class="s-label">Группы</label>
                    <div v-for="(field, i) in fields" :key="i" class="s-field s-field--grouped">
                        <autocomplete
                            :data="groups"
                            :loading="loading"
                            placeholder="Группы..."
                            :type="$v.fields.$each[i].id.$invalid ? 's-border--danger' : ''"
                            open-on-focus
                            field="group"
                            @focus="getGroups"
                            @select="option => field.id = option.id"
                        ></autocomplete>
                        <button class="s-btn" @click="fields.splice(i, 1)">
                            <span class="s-icon">
                                <i class="mdi mdi-delete-circle"></i>
                            </span>
                        </button>
                    </div>
                    <button class="s-btn s-expanded" @click="fields.push({id: ''})">Добавить</button>
                </section>
                <footer class="s-modal__card-footer">
                    <div class="s-field">
                        <div class="s-control">
                            <button class="s-btn s-rounded s-btn--primary w-1" :disabled="$v.$invalid"
                                    @click="sendData">Создать
                            </button>
                        </div>
                    </div>
                </footer>
            </div>

        </modal>
        <modal v-model="editDataModal" :can-cancel="['escape', 'x']" :width="320">
            <div class="s-modal__card" style="width: auto">
                <header class="s-modal__card-header">
                    <div class="s-modal__card-title">
                        <span class="s-size--4">
                            Изменить название курса
                        </span>
                    </div>
                </header>
                <section class="s-modal__card-body">
                    <div class="s-field">
                        <label class="s-label">Название</label>
                        <div class="s-control">
                            <input type="text" v-model="courseName" class="s-input" placeholder="Название курса...">
                        </div>
                    </div>
                </section>
                <footer class="s-modal__card-footer">
                    <div class="s-field">
                        <div class="s-control">
                            <button class="s-btn s-rounded s-btn--primary w-1" :disabled="$v.courseName.$invalid"
                                    @click="updateData">Обновить
                            </button>
                        </div>
                    </div>
                </footer>
            </div>

        </modal>
    </section>
</template>

<script>
    import Modal from "./Helpers/Modal";
    import {required,minLength} from "vuelidate/lib/validators";

    export default {
        name: "Courses",
        components: {Modal},
        data() {
            return {
                data: [],
                createDataModal: false,
                editDataModal: false,
                groups: [],
                loading: false,
                fields: [{id: ''}],
                courseName: '',
                editableDataId: null,
            }
        },
        validations() {
            return {
                courseName: {
                    minLength: minLength(5),
                    required
                },
                fields: {
                    $each: {
                        id: {
                            isDuplicate(id) {
                                return this.fields.filter(v => v.id === id).length === 1;
                            },
                            required
                        }
                    },
                    required
                }
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            removeData: function (obj, idx) {
                axios.delete(`/courses/${obj.id}`).then(({data}) => {
                    this.data.splice(idx, 1);
                    // TODO: Create open status message
                })
            },
            getData: function () {
                this.loading = true;
                axios.get('/courses').then(({data}) => {
                    this.data = data.data;
                }).catch(({response}) => {
                    console.log(response);
                }).finally(() => this.loading = false)
            },
            editData: function (obj, idx) {
                this.editDataModal = true;
                this.courseName = obj.course;
                this.editableDataId = obj.id;
            },
            sendData: function () {
                axios.post('/courses', {
                    course: this.courseName,
                    groups: this.fields.map(obj => obj.id)
                }).then(({data}) => {
                    this.courseName = '';
                    this.fields = [{id: ''}];
                    this.data.push(data.data);
                    // TODO: Create open status message
                }).finally(() => {
                    this.createDataModal = false;
                });
            },
            updateData: function () {
                axios.post(`/courses/${this.editableDataId}`, {
                    '_method': 'PUT',
                    'course': this.courseName
                }).then(({data}) => {
                    // TODO: Create open status message
                    const idx = this.data.findIndex(obj => obj.id === data.data.id);
                    this.data.splice(idx, 1, data.data);
                    this.editDataModal = false;
                });
            },
            selectGroup: function (obj, idx) {
                if (obj) {
                    this.fields[idx].id = obj.id;
                }
            },
            getGroups: function () {
                if (this.groups.length === 0) {
                    this.loading = true;
                    axios.get('/groups').then(({data}) => {
                        this.groups = data.data;
                    }).finally(() => {
                        this.loading = false;
                    })
                }
            },
        }
    }
</script>


