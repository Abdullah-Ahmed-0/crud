@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success d-flex" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @else
        <div class="alert alert-success d-flex" role="alert">
            <i class="fa fa-check"></i>
            {{ $data }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endif
