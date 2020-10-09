<template>
    <tr v-for="(datum, idx) in addingWorks" :key="'add_task-'+idx">
        <td>
            <input
                v-model="datum.title"
                type="text"
                class="s-input"
                placeholder="Название"
            />
        </td>
        <td>
            <autocomplete
                :data="works"
                :loading="loading"
                placeholder="Тест..."
                class="w-1"
                field="title"
                :type="$v.addingWorks.$each[idx].task_id.$invalid ? 's-border--danger' : ''"
                @input="searchDebounce('works')"
                @select="option => {addingWorks[idx] = option; $v.addingWorks.$each[idx].task_id.$model = option.id }"
            ></autocomplete>
        </td>
        <td>
            <textarea class="s-textarea" v-model="datum.description" placeholder="Описание..."></textarea>
        </td>
        <td>
            {{ datum.created_at  }}
        </td>
        <td>
            <el-date-picker
                v-model="datum.complete_in"
                type="datetime"
                placeholder="Дата окончания..."
                :picker-options="pickerOptions">
            </el-date-picker>
        </td>
        <td>
            <button
                type="button"
                class="s-btn s-rounded s-outlined s-small"
                @click="addingWorks.splice(idx, 1)"
            >
                                <span class="s-icon">
                                    <i class="mdi mdi-delete-forever"></i>
                                </span>
            </button>
        </td>
    </tr>
</template>

<script>
    import unionBy from "lodash/unionBy";
    import {maxLength, required} from "vuelidate/lib/validators";

    let pickerOptions = {
        shortcuts: [
            {
                text: '2 дня',
                onClick(picker) {
                    const end = new Date();
                    end.setTime(end.getTime() + 3600 * 1000 * 24 * 2);
                    picker.$emit('pick',  end);
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
                    picker.$emit('pick',  end);
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
        data() {
            return {
                pickerOptions: pickerOptions,
                addingWorks: [],
            }
        },
        validations() {
            return {
                addingWorks: {
                    maxLength: maxLength(10),
                    required,
                    $each: {
                        task_id: {
                            isDuplicate(id) {
                                return this.data.works.filter(v => v.task_id === id).length === 0 && this.addingWorks.filter(v => v.task_id === id).length === 1;
                            },
                            required
                        },
                    },
                },
            };
        },
        methods: {
            addNewTask: function () {
                this.addingWorks.push({
                    complete_in: '',
                    created_at: new Date(),
                    description: '',
                    task_id: null,
                    title: ''
                })
            },

            attachWorks: function () {
                axios.post(`/courses/${this.dataId}/attach`, {
                    works: this.addingWorks.map(obj => obj.id)
                }).then(({data}) => {
                    this.data.groups = unionBy(this.data.groups, this.addingGroups, 'id');
                    this.addingGroups = [];
                    // TODO: Create open status message
                }).finally(() => {
                    this.groupsEditing = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>
