@php
    $action = $action ?? 'create';
@endphp
<div class="modal fade" id="{{$action ?? 'create'}}Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$action ?? 'create'}}Title">{{$title}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <form action="{{$url}}" method="POST">
                <div class="modal-body">
                    @if(isset($action) && $action == 'update')
                    @method('PUT')
                @endif
                @csrf
                @foreach($fields as $field)
                    @if($field['type'] == 'text')
                            <div class="row">
                                <div class="col mb-3">
                                    <input type="text" name="{{$field['name']}}" id="{{$field['name']}}-form-id" class="form-control"
                                           placeholder="Enter {{str_replace('_', ' ', ucfirst($field['name']))}}" required>
                                </div>
                            </div>
                    @elseif($field['type'] == "hidden")
                        <input type="hidden" name="{{$field['name']}}" value="{{$field['value']}}">
                    @endif
                @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($action === 'update')
    @once
        @push('scripts')
            <script>
                $(document).ready(function () {
                    console.log("updating");
                    setUpdateModal();
                })
            </script>
        @endpush
    @endonce
@endif
