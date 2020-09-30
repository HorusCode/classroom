<template>
    <div class="s-modal__card">
        <div class="s-modal__card-header justify-content-between">
            <h2 class="s-text--title">Создание теста</h2>
            <div class="s-delete" @click="$parent.close()"></div>
        </div>
        <div class="s-modal__card-body">
            <div class="s-row">
                <div class="s-col-desk-12">
                    <div class="s-card">
                        <div class="s-card__title">
                            <span>{{test.title}}</span>
                        </div>
                        <div class="s-card__content">
                            <div class="s-field">
                                <label class="s-label">Название теста</label>
                                <input type="text" v-model="test.title" class="s-input" placeholder="Test name...">
                            </div>
                            <div class="s-field">
                                <label class="s-label">Время прохождения</label>
                                <input type="text" v-model="test.time" class="s-input" placeholder="Time">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="s-col-desk-12" v-for="(questions, index) in test.questions" :key="`question-${index}`">
                    <div class="s-row">
                        <div class="s-col-desk-3">
                            <div class="s-card">
                                <header class="s-card__header">
                                    <span class="s-card__title">Тип вопроса:</span>
                                </header>
                                <div class="s-card__content">
                                    <fieldset>
                                        <div class="s-field" v-for="(type, key) in types" :key="key">
                                            <label class="s-radio">
                                                <input type="radio" :name="`type-${index}`" :value="key"
                                                       v-model="questions.type" @click="setAnswersToBool(index)">
                                                {{ type.label }}
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="s-col-desk-9">
                            <div class="s-card">
                                <header class="s-card__header s-with-tools">
                                    <div class="s-card__title">
                                        <span>Вопрос №{{ index + 1 }}</span>
                                    </div>
                                    <button type="button" class="s-btn s-btn--text" @click="deleteQuestion(index)">
                                        <span class="s-icon">
                                            <i class="mdi mdi-close"></i>
                                        </span>
                                    </button>
                                </header>
                                <div class="s-card__content">
                                    <!--Editor-->
                                    <el-tiptap v-model="questions.name" :id="`editor-${index}`" :extensions="extensions"
                                               class="s-mgb-3" lang="ru"/>
                                    <!--End editor-->
                                    <fieldset>
                                        <div class="s-row">
                                            <div class="s-col-desk-3" v-for="(answer, i) in questions.answers"
                                                 :key="`answer-${i}`">
                                                <div class="s-field s-with-tools align-items-center">
                                                    <div class="s-control">
                                                        <button class="s-btn s-static">
                                                            <label :class="[`s-${types[questions.type].button}`]">
                                                                <input :type="types[questions.type].button"
                                                                       :id="`answer-field-${index}-${i}`"
                                                                       value="true"
                                                                       :name="`answer-${index}`"
                                                                       @click="$event.target.type === 'radio' && setAnswersToBool(index), answer.answer = !$event.target.checked"
                                                                       v-model="answer.answer">
                                                            </label>
                                                        </button>
                                                    </div>
                                                    <div class="s-control">
                                                        <input type="text" v-model="answer.text" class="s-input"
                                                               placeholder="Ответ...">
                                                    </div>
                                                    <div class="s-control">
                                                        <button class="s-btn" @click="deleteAnswer(index, i)">
                                                            <span class="s-icon">
                                                                <i class="mdi mdi-close"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="s-col-desk-3">
                                                <button class="s-btn s-btn--info" @click="addAnswer(index)">Добавить
                                                    ответ
                                                </button>
                                            </div>
                                        </div>
                                    </fieldset>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="s-col-desk-12">
                    <div class="s-card">
                        <div class="s-card__content">
                            <div class="s-btn-group s-centered">
                                <button class="s-btn s-btn--primary s-outlined s-rounded" @click="addQuestion">Добавить
                                    вопрос
                                </button>
                                <button class="s-btn s-btn--success s-rounded" @click="saveData">Сохранить</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
    import {
        // necessary extensions
        Doc,
        Text,
        Paragraph,
        Heading,
        Bold,
        Underline,
        Italic,
        Strike,
        ListItem,
        BulletList,
        OrderedList,
        Fullscreen,
        FontSize,
        Iframe,
        Link,
        Image,
        ElementTiptap,
    } from 'element-tiptap';

    import FilemanagerButton from "../../extensions/FilemanagerButton";

    const extensions = [
        new Doc(),
        new Text(),
        new Paragraph(),
        new Heading({level: 5}),
        new Bold({bubble: true}),
        new Underline({bubble: true, menubar: false}),
        new Italic(),
        new Strike(),
        new ListItem(),
        new BulletList(),
        new OrderedList(),
        new Iframe(),
        new Fullscreen(),
        new FontSize(),
        new Image(),
        new Link(),
        new FilemanagerButton(), // Кнопка файлового менеджера
    ];
    export default {
        name: "TestEditing",
        props: {
            data: Object
        },
        components: {
            'el-tiptap': ElementTiptap,
        },
        data() {
            return {
                extensions: extensions,
                types: {
                    multichoice: {
                        button: 'checkbox',
                        label: 'Множественный выбор',
                    },
                    singlechoice: {
                        button: 'radio',
                        label: 'Одиночный выбор',
                    }
                },
                test: {
                    title: "Название теста",
                    time: "00:15:00",
                    questions: [
                        {
                            name: "",
                            type: 'multichoice',
                            answers: [
                                {
                                    text: "",
                                    answer: false,
                                }
                            ],
                        },
                    ],
                },
                mode: 'create'
            }
        },
        mounted() {
            if (Object.keys(this.data).length !== 0) {
                this.$forceUpdate();
                this.test = JSON.parse(JSON.stringify(this.data));
                this.mode = 'update';
            } else {
                this.mode = 'create';
            }
        },
        methods: {
            addQuestion: function () {
                this.test.questions.push({
                    name: "Question Answer",
                    type: 'multichoice',
                    answers: [],
                });
                this.addAnswer(this.test.questions.length - 1);
            },
            addAnswer: function (questionIdx) {
                this.test.questions[questionIdx].answers.push({
                    text: '',
                    answer: false
                })
            },
            saveData: function () {
               if(this.mode === 'update') {
                   this.updateData();
                   return;
               }
               this.createData();
            },
            updateData: function() {
              axios.put(`/testing/${this.test.id}`, this.test).then(response => {
                  console.log(response);
              })
            },
            createData: function() {
              axios.post('/testing', this.test).then(response => {
                 console.log(response);
              });
            },
            deleteAnswer: function (questionIdx, answerInd) {
                this.test.questions[questionIdx].answers.splice(answerInd, 1);
            },
            deleteQuestion: function (questionIdx) {
                this.test.questions.splice(questionIdx, 1);
            },
            setAnswersToBool: function (questionIdx, boolVar = false) {
                this.test.questions[questionIdx].answers.forEach(el => el.answer = boolVar);
            }
        }
    }
</script>

<style scoped>

</style>
