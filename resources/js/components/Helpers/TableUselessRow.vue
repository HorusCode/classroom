<template>
    <tr class="s-table__field">
        <td colspan="100%">
            <div class="row-wrapper s-center">
                <div class="s-btn-group">
                    <button class="s-btn s-btn--primary s-light" @click="$emit('add-new')">Добавить</button>
                    <button class="s-btn s-btn--success" @click="$emit('save')" v-if="data.length > 0" :disabled="sendDisabled">Сохранить</button>
                </div>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        name: "TableUselessRow",
        props: {
            data: {
                type: Array,
                default: []
            },

            sendDisabled: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped>

</style>
