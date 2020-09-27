<template>
</template>
<script>
    import MediaModal from '../../../assets/vendor/MediaManager/js/mixins/modal'

    export default {
        name: "Filemanager",
        mixins: [MediaModal],
        data() {
            return {
                cover: '',
                gallery: '',
                links: ''
            }
        }
    }
</script>



