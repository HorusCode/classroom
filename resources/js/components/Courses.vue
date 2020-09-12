<template>
    <section>
        <div class="controls-field">
            <div class="s-field s-field--grouped">
                <div class="s-control">
                    <button class="s-btn s-btn--info" @click="isCardModalActive = true">
                        Добавить
                    </button>
                </div>

            </div>

        </div>
        <hr>
        <div class="s-row">
            <div class="s-col-desk-3" v-for="(item, i) in data" :key="item.id">
                <a href="">
                    <div class="s-card">
                        <div class="s-card__media">
                            <figure class="s-image">
                                <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                            </figure>
                        </div>
                        <div class="s-card__content">
                            <h2 class="s-card__title s-text--center">{{item.course}}</h2>
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
                            <a class="s-card-footer__item" @click="editData(item)">
                                  <span class="s-icon">
                                    <i class="mdi mdi-rename-box"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </a>

            </div>
        </div>
        <modal v-model="createDataModal" :width="320">
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
                            @select="option => field = option"
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
                            <button class="s-btn s-rounded s-btn--primary w-1" :disabled="$v.$invalid" @click="sendData">Создать</button>
                        </div>
                    </div>
                </footer>
            </div>

        </modal>
        <modal v-model="editDataModal" :width="320">
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
                            <button class="s-btn s-rounded s-btn--primary w-1" :disabled="$v.$invalid" @click="updateData">Обновить</button>
                        </div>
                    </div>
                </footer>
            </div>

        </modal>
    </section>
</template>

<script>
    import Modal from "./Helpers/Modal";
    import {required, minLength} from "vuelidate/lib/validators";

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
            }
        },
        validations() {
            return {
                courseName: {
                    required,
                    minLength: minLength(5)
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
                }
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            removeData: function(obj, idx) {
              axios.delete(`/courses/${obj.id}`).then(({data}) => {
                  this.data.splice(idx, 1);
                  // TODO: Create open status message
              })
            },
            getData: function () {
                axios.get('/courses').then(({data}) => {
                    this.data = data.data;
                }).catch(({response}) => {
                    console.log(response);
                })
            },
            editData: function(obj){
                this.editDataModal = true;
                this.courseName = obj.course;
            },
            sendData: function()
            {
              axios.post('/courses', {
                  course: this.courseName,
                  groups: this.fields.map(obj => obj.id)
              }).then(({data}) => {
                  this.courseName = '';
                  this.fields = [{id: ''}];
                  this.data.push(data.data);
              }).finally(() => {
                  this.createDataModal = false;
              });
            },
            updateData: function() {

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


