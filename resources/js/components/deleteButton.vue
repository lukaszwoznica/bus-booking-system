<template>
    <button class="btn btn-danger btn-sm" @click="showAlert">
        <i class="fas fa-fw fa-trash-alt"></i>
        Delete
    </button>
</template>

<script>
export default {
    props: {
        form_id: {
            type: String,
            default: null
        },
        item_name: {
            type: String,
            default: 'item'
        }
    },

    methods: {
        showAlert(e) {
            e.preventDefault()
            this.$swal({
                title: 'Are you sure?',
                text: `This ${this.item_name} will be permanently deleted.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#212529',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector(`#${this.form_id}`).submit()
                }
            })
        },
    },
}
</script>
