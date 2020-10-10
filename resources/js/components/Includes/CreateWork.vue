<template>
    <div class="s-modal__card" style="width: auto">
        <header class="s-modal__card-header">
            <div class="s-modal__card-title">
                <span class="s-size--4">
                    Добавление нового задания
                </span>
            </div>
        </header>
        <section class="s-modal__card-body">
            <div class="s-field">
                <label class="s-label">Заголовок задания</label>
                <div class="s-control">
                    <input type="text" v-model="workTitle" class="s-input"
                           :class="{'s-border--danger': $v.workTitle.$invalid}" placeholder="Заголовок задания...">
                </div>
                <span v-if="!$v.workTitle.minLength" class="s-field--message s-text--danger">5 символов минимум</span>
                <span v-if="!$v.workTitle.required" class="s-field--message s-text--danger">Это поле обязательно</span>
            </div>
            <div class="s-field">
                <label class="s-label">Описание</label>
                <div class="s-control">
                    <textarea v-model="workDescription" class="s-textarea"
                              :class="{'s-border--danger': $v.workDescription.$invalid}"
                              placeholder="Описание..."></textarea>
                </div>
                <span v-if="!$v.workDescription.minLength"
                      class="s-field--message s-text--danger">10 символов минимум</span>
                <span v-if="!$v.workDescription.required"
                      class="s-field--message s-text--danger">Это поле обязательно</span>
            </div>
            <div class="s-field">
                <label class="s-label">Тест</label>
                <div class="s-control">
                    <autocomplete
                        :data="tests"
                        :loading="loading"
                        placeholder="Тест..."
                        class="w-1"
                        field="title"
                        :type="$v.selectedTest.$invalid ? 's-border--danger' : ''"
                        @input="searchDebounce"
                        @select="option => selectedTest = option"
                    ></autocomplete>
                </div>
                <span v-if="!$v.selectedTest.required" class="s-field--message s-text--danger">Выберите тест</span>
            </div>
            <div class="s-field">
                <label class="s-label">Дата завершения задания</label>
                <div class="s-control">
                    <span>{{moment().format('DD.MM.YYYY HH:mm')}}</span>
                    <el-date-picker
                        v-model="workCompleteIn"
                        type="datetime"
                        placeholder="Дата завершения..."
                        format="dd.MM.yyyy HH:mm"
                        :class="{'s-border--danger': $v.workDescription.$invalid}"
                        :picker-options="pickerOptions">
                    </el-date-picker>
                </div>
                <span v-if="!$v.workCompleteIn.minValue"
                      class="s-field--message s-text--danger">Минимальное время: {{ moment().add(2, 'h').add(-1, 'm').format('DD.MM.YYYY HH:mm') }}</span>
                <span v-if="!$v.workCompleteIn.required"
                      class="s-field--message s-text--danger">Это поле обязательно</span>
            </div>

        </section>
        <footer class="s-modal__card-footer">
            <div class="s-field">
                <div class="s-control">
                    <button class="s-btn s-rounded s-btn--primary w-1"
                            @click="sendData" :disabled="$v.$invalid">Создать
                    </button>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    import debounce from "lodash/debounce";
    import {required, minLength} from 'vuelidate/lib/validators'

    let pickerOptions = {
        shortcuts: [
            {
                text: '2 дня',
                onClick(picker) {
                    const end = new Date();
                    end.setTime(end.getTime() + 3600 * 1000 * 24 * 2);
                    picker.$emit('pick', end);
                }
            },
            {
                text: 'Неделя',
                onClick(picker) {
                    const end = new Date();
                    end.setTime(end.getTime() + 3600 * 1000 * 24 * 7);
                    picker.$emit('pick', end);
                }
            },
            {
                text: '2 недели',
                onClick(picker) {
                    const end = new Date();
                    end.setTime(end.getTime() + 3600 * 1000 * 24 * 14);
                    picker.$emit('pick', end);
                }
            },
            {
                text: 'Месяц',
                onClick(picker) {
                    const end = new Date();
                    end.setTime(end.getTime() + 3600 * 1000 * 24 * 30);
                    picker.$emit('pick', end);
                }
            }],
        disabledDate(time) {
            return time.getTime() < Date.now() - 3600 * 1000 * 24;
        }
    };

    export default {
        name: "CreateWork",
        props: ['courseId'],
        data() {
            return {
                pickerOptions: pickerOptions,
                workTitle: '',
                workDescription: '',
                workCompleteIn: '',
                selectedTest: null,
                tests: [],
                loading: false,
                moment: moment
            }
        },
        validations: {
            workCompleteIn: {
                required,
                minValue: value => {
                    const date = new Date();
                    date.setTime(date.getTime() + 3600 * 1000 * 2);
                    return value > date;
                }
            },
            workDescription: {
                required,
                minLength: minLength(10)
            },
            workTitle: {
                required,
                minLength: minLength(5)
            },
            selectedTest: {
                required
            }

        },
        methods: {
            sendData: function () {
                axios.post(`courses/${this.courseId}/works`, {
                    title: this.workTitle,
                    description: this.workDescription,
                    test: this.selectedTest.id,
                    complete_in: this.workCompleteIn,
                }).then(data => {
                    console.log(data);
                })
            },
            searchDebounce: debounce(function (value) {
                this.search(value);
            }, 800),
            search: function (value) {
                this.loading = true;
                axios.get(`/search/tests`, {
                    params: {
                        test: value
                    }
                }).then(response => {
                    this.tests = response.data.data;
                    this.loading = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>
