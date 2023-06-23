<div class="card">
    <h5 class="card-header">Import</h5>
    <div class="card-body demo-vertical-spacing demo-only-element">
        <form
                x-data="{ importDisabled: true, isUploading: false }"
                wire:submit.prevent="import"
        >
            <div class="input-group">
                <input x-on:change="importDisabled = false" type="file" wire:model="excelFile" class="form-control"
                               aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                <button @click="isUploading = true" disabled class="btn btn-primary" type="submit"
                        x-bind:disabled="importDisabled" {{ $status == 'progress' ? 'disabled' : '' }}>
                        <span x-show="isUploading" class="spinner-border me-1" role="status" aria-hidden="true"></span>
                        <span x-show="isUploading">Loading</span>
                        <span x-show="!isUploading">Import</span>
                </button>
            </div>
        </form>
    </div>
</div>