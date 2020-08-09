<template>
    <div class="s-card">
        <div class="s-card__content">
            <header class="s-card__header">
                <h3 class="text--center s-mgy-3">
                    Write your
                    <span class="text--primary">email</span>
                    for pass
                </h3>
            </header>
            <form @submit.prevent="login">
                <fieldset>
                    <div class="s-field">
                        <label class="s-label">Email</label>
                        <div class="s-control">
                            <input type="email" class="s-input s-rounded" placeholder="Write email...">
                        </div>
                    </div>
                    <div class="s-field">
                        <label class="s-label">Password</label>
                        <div class="s-control">
                            <input type="password" class="s-input s-rounded" placeholder="Write password...">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between s-mgb-3">
                        <span class="s-label-link" @click="$emit('showform', 'LoginForm')">
                            ← Back
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
        name: "RepairForm"
    }
</script>

<style scoped>

</style>
