<template>
    <div :visible="showcustomModal" class="modal  modal-right scroll-out-negative" id="settings" data-bs-backdrop="true" tabindex="-1"
        role="dialog" aria-labelledby="settings" aria-hidden="true">
        <div  class="modal-dialog modal-dialog-scrollable full" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajustes de tema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="scroll-track-visible"></div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
export default {
    props: [
        "showcustomModal"

    ],
    data() {
        return {
        }

    }
}
</script>