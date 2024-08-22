@if (Session::has('message'))
    <div class="sticky-top">
        <div class="position-absolute top-0 start-50 translate-middle-x">
            <div class="alert alert-{{ Session::get('type') }} alert-dismissible fade show" role="alert"
                style="width: max-content;">
                {{ Session::get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="sticky-top">
        <div class="position-absolute top-0 start-50 translate-middle-x">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        </div>
    </div>
@endif
