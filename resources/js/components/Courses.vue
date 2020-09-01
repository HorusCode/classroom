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
        <div class="s-row">
            <div class="s-col-desk-3" v-for="item in data" :key="item.id">
                <a href="">
                    <div class="s-card">
                        <div class="s-card__media">
                            <figure class="s-image">
                                <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                            </figure>
                        </div>
                        <div class="s-card__content">
                            <h2 class="s-text--center s-text--bold">{{item.course}}</h2>
                        </div>
                        <div class="s-card__footer">
                            <a class="s-card-footer__item">
                                <span class="s-icon">
                                    <i class="mdi mdi-delete-forever"></i>
                                </span>
                            </a>
                            <a class="s-card-footer__item">
                                <span class="s-icon">
                                    <i class="mdi mdi-stop"></i>
                                </span>
                            </a>
                            <a class="s-card-footer__item">
                                  <span class="s-icon">
                                    <i class="mdi mdi-rename-box"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </a>

            </div>
        </div>
        <modal v-model="isCardModalActive" :width="640">
            <div class="s-card">
                <div class="s-card__media">
                    <figure class="s-image">
                        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Image">
                    </figure>
                </div>
                <div class="s-card__content">

                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Phasellus nec iaculis mauris. <a>@bulmaio</a>.
                    <a>#css</a> <a>#responsive</a>
                    <br>
                    <small>11:09 PM - 1 Jan 2016</small>

                </div>
            </div>
        </modal>
    </section>
</template>

<script>
    import Modal from "./Helpers/Modal";

    export default {
        name: "Courses",
        components: {Modal},
        data() {
            return {
                data: [],
                isCardModalActive: false
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData: function () {
                axios.get('/courses').then(({data}) => {
                    this.data = data.data;
                }).catch(({response}) => {
                    console.log(response);
                })
            }
        }
    }
</script>


