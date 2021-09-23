<div class="modal fade bd-example-modal-lg" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="contractModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document" style="max-width: 860px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contractModalLabel">{{ __('item.contract') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contractContentModal" style="position: relative; margin:auto; padding:5px; width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                {{-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>