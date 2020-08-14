<template>
    <div class="s-card">
        <div class="s-card__content">
            <header class="s-card__header">
                <h3 class="text--center s-mgy-3">
                    <span class="text--primary">Login</span> your account
                </h3>
            </header>
            <form @submit.prevent="login">
                <input type="hidden" name="_token" :value="csrf"/>
                <fieldset>
                    <div class="s-field">
                        <label class="s-label">Email</label>
                        <div class="s-control s-control__icons-right">
                            <input type="email" v-model="email" class="s-input s-rounded" placeholder="Write email...">
                            <span class="s-icon s-right">
                              <i class="mdi mdi-email-outline"></i>
                            </span>
                        </div>
                    </div>
                    <div class="s-field">
                        <label class="s-label">Password</label>
                        <div class="s-control s-control__icons-right">
                            <input :type="checkPassword ? 'text' : 'password'" v-model="password" class="s-input s-rounded"
                                   placeholder="Write password...">
                            <span class="s-icon s-right">
                                <i class="mdi mdi-form-textbox-password" v-if="password.trim() === ''"></i>
                                <i v-else :class="{'mdi-eye-outline text--primary': checkPassword, 'mdi-eye-off-outline': !checkPassword}" class="mdi" @click="checkPassword = !checkPassword"></i>
                            </span>

                        </div>
                    </div>
                    <div class="d-flex justify-content-between s-mgb-3">
                        <span class="s-label-link" @click="$emit('showform', 'CodeForm')">
                            Is this your first time?
                        </span>
                        <span class="s-label-link" @click="$emit('showform', 'RepairForm')">
                            Forget password?
                        </span>
                    </div>
                    <div class="s-field">
                        <div class="s-control">
                            <button type="submit" class="s-btn s-rounded s-btn--primary w-1 mg-auto-x">Login</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LoginForm",
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                email: '',
                password: '',
                checkPassword: false
            }
        },
        methods: {
            login() {
                this.errors = {};
                this.loading = true;
                axios
                    .post("/login", {
                        email: this.email,
                        password: this.password,
                        _token: this.csrf,
                    })
                    .then(response => {
                        window.location.href = response.data.redirect;
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
        }
    }
</script>

<style scoped>
    .mdi-eye-outline, .mdi-eye-off-outline {
        pointer-events: all;
        cursor: pointer;
    }
</style>
