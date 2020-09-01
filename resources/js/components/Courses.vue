<template>
    <section>
        <div class="controls-field">
           <div class="s-field s-field--grouped">
                <div class="s-control">
                    <button class="s-btn s-btn--info">
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

    </section>
</template>

<script>
    export default {
        name: "Courses",
        data() {
            return {
                data: []
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


