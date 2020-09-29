<template>
    <div>
        <el-tooltip
            :content="tooltip"
            :open-delay="350"
            :disabled="!enableTooltip || readonly"
            transition="el-zoom-in-bottom"
            effect="dark"
            placement="top"
        >
            <div
                :class="commandButtonClass"
                @mousedown.prevent
                @click="onClick"
            >
                <v-icon name="folder"/>
            </div>
        </el-tooltip>

    </div>
</template>
<script>
    import {Tooltip} from 'element-ui';
    import Icon from 'vue-awesome/components/Icon.vue';
    import 'vue-awesome/icons/folder';

    export default {
        name: "FilemanagerButton",
        props: {
            isActive: {
                type: Boolean,
                default: false,
            },
            enableTooltip: {
                type: Boolean,
                default: false,
            },
            readonly: {
                type: Boolean,
                default: false,
            },
            tooltip: {
                type: String,
                default: ''
            },
            editorContext: {
                type: Object,
                default: {},
                required: true,
            }
        },
        data() {
          return {
              images: '',
              activeButton: false
          }
        },
        components: {
            Tooltip,
            'v-icon': Icon
        },
        computed: {
            commandButtonClass() {
                return {
                    'el-tiptap-editor__command-button': true,
                    'el-tiptap-editor__command-button--active': this.isActive,
                    'el-tiptap-editor__command-button--readonly': this.readonly,
                };
            }
        },
        mounted() {
          this.listenEvents();
        },
        beforeDestroy() {
            EventHub.removeListenersFrom(['file_selected', 'modal-hide']);
        },
        methods: {
            listenEvents() {
                EventHub.listen('file_selected', (path) => {
                    this.images = path;
                });
                EventHub.listen('modal-hide', () => {
                    if(this.images !== '' && this.activeButton) {
                        //Добавляю фотку в редактор
                        this.editorContext.commands.image({src: this.images});
                    }
                    this.images = '';
                    this.activeButton = false;
                });
            },
            onClick() {
                // Открытие модального окна менеджера
                this.activeButton = true;
                document.getElementsByClassName('__Inmodal-editor')[0].click();
            }
        }
    }
</script>

<style scoped>

</style>
