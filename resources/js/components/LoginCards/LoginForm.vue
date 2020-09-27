<template>
    <div class="s-card">
        <div class="s-card__content">
            <header class="s-card__header justify-content-center">
                <h3 class="s-text--center s-mgy-3">
                    <span class="s-text--primary">Login</span> your account
                </h3>
            </header>
            <span v-if="'message' in data" :class="[data.success ? 's-bg--success' : 's-bg--danger']"
                  class="form-message">{{ data.message }}</span>
            <form @submit.prevent="login">
                <input type="hidden" name="_token" :value="csrf"/>
                <fieldset v-bind:disabled="loading">
                    <div class="s-field">
                        <label class="s-label">Email</label>
                        <div class="s-control s-with-icon-right">
                            <input type="email" v-model="email" class="s-input s-rounded" placeholder="Write email...">
                            <span class="s-icon s-right">
                              <i class="mdi mdi-email-outline"></i>
                            </span>
                        </div>
                        <span v-if="has(data, 'errors.email')" class="s-field--message s-text--danger">{{ data.errors.email[0] }}</span>
                    </div>
                    <div class="s-field">
                        <label class="s-label">Password</label>
                        <div class="s-control s-with-icon-right">
                            <input :type="checkPassword ? 'text' : 'password'" v-model="password"
                                   class="s-input s-rounded"
                                   placeholder="Write password...">
                            <span class="s-icon s-right">
                                <i class="mdi mdi-form-textbox-password" v-if="password.trim() === ''"></i>
                                <i v-else
                                   :class="{'mdi-eye-outline s-text--primary': checkPassword, 'mdi-eye-off-outline': !checkPassword}"
                                   class="mdi" @click="checkPassword = !checkPassword"></i>
                            </span>
                        </div>
                        <span v-if="has(data, 'errors.password')" class="s-field--message s-text--danger">{{ data.errors.password[0] }}</span>
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
                            <button type="submit" class="s-btn s-rounded s-btn--primary w-1 mg-auto-x"
                                    :class="{'s-loading': loading}">Login
                            </button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</template>

<script>

    import has from 'lodash/has';

    export default {
        name: "LoginForm",
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                email: '',
                password: '',
                checkPassword: false,
                loading: false,
                data: {},
                has: has
            }
        },
        methods: {
            login() {
                this.data = {};
                this.loading = true;
                axios
                    .post(window.location.origin + "/auth/login", {
                        email: this.email,
                        password: this.password,
                        _token: this.csrf,
                    })
                    .then(({data}) => {
                        this.data = data;
                        window.location.href = '/';
                    })
                    .catch(data => {
                        this.data = data.data;
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
