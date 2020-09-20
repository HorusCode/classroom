<template>
    <div class="s-modal__card">
        <div class="s-modal__card-header">
            <h2 class="s-text--title">Создание теста</h2>
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
                    <div class="s-card">
                        <header class="s-card__header s-with-tools">
                            <div class="s-card__title">
                                <span>Вопрос №{{ index + 1 }}</span>
                            </div>
                            <div class="s-icon">
                                <i class="mdi mdi-plus mdi-rotate-45 mdi-36px"/>
                            </div>
                        </header>
                        <div class="s-card__content">
                            <div class="answers">
                                <div class="s-row">
                                    <div class="s-col-desk-3" v-for="(answer, i) in questions.answers" :key="`answer-${i}`">
                                        <div class="s-field s-with-tools align-items-center">
                                            <div class="s-control">
                                                <button class="s-btn s-static">
                                                    <label class="s-checkbox">
                                                        <input type="checkbox" :id="`checkbox-${index}-${i}`" v-model="answer.answer">
                                                    </label>
                                                </button>
                                            </div>
                                            <div class="s-control">
                                                <input type="text" v-model="answer.text" class="s-input" placeholder="Ответ...">
                                            </div>
                                            <div class="s-control">
                                                <button class="s-btn">
                                            <span class="s-icon">
                                                <i class="mdi mdi-close"></i>
                                            </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="s-col-desk-3">
                                        <button class="s-btn s-btn--info"> Добавить ответ</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="s-col-desk-12">
                    <div class="s-card">
                        <div class="s-card__content">
                            <div class="s-btn-group s-centered">
                                <button class="s-btn s-btn--primary s-outlined s-rounded">Добавить вопрос</button>
                                <button class="s-btn s-btn--success s-rounded">Сохранить</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
    export default {
        name: "TestEditing",
        props: {
            data: Object
        },
        data() {
            return {
                test: {
                    title: "Название теста",
                    time: "00:15:00",
                    questions: [
                        {
                            name: "Вопрос",
                            answers: [
                                {
                                    text: "Answer Text1",
                                    answer: false,
                                },
                                {
                                    text: "Answer Text1",
                                    answer: false,
                                },
                                {
                                    text: "Answer Text1",
                                    answer: false,
                                },
                                {
                                    text: "Answer Text1",
                                    answer: false,
                                },
                                {
                                    text: "Answer Text1",
                                    answer: false,
                                },
                                {
                                    text: "Answer Text1",
                                    answer: false,
                                },
                            ],
                        },
                    ],
                }
            }
        }
    }
</script>

<style scoped>

</style>
