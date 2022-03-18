@if (Session::has('successMessage'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('successMessage') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('errorMessage'))
    <div class="alert alert-danger" role="alert">
    {{ Session::get('errorMessage') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
@endif