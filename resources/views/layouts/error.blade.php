@if ($errors->any())
    <div class="container">
        <div class="alert alert-danger mt-5">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    </div>
@endif

@if(Session::has('error'))
<div class="container">
    <div class="row">
        <div class="col-md-12  mt-5">
            <div class="alert alert-danger" style="margin-bottom:10px;">{!! Session::get('error') !!}</div>
        </div>
    </div>
</div>
@endif

@if(Session::has('success'))
<div class="container">
    <div class="row">
        <div class="col-md-12  mt-5">
            <div class="alert alert-success" style="margin-bottom:10px;">{!! Session::get('success') !!}</div>
        </div>
    </div>
</div>
@endif