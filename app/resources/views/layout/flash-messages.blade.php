@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="border border-danger text-danger h5 p-1 mt-1 lead mb-1" align="center">
            {{ $error }}
        </div>
    @endforeach
@endif

@if (Session::has('danger'))
    <div class="clearfix"></div>
    <div class="alert alert-danger alert-block mt-1 text-center">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="lead">{!! Session::get('danger') !!}</span>
    </div>
@endif

@if (Session::has('warning'))
    <div class="clearfix"></div>
    <div class="alert alert-warning alert-block mt-1 text-center">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="lead">{!! Session::get('warning') !!}</span>
    </div>
@endif

@if (Session::has('info'))
    <div class="clearfix"></div>
    <div class="alert alert-info alert-block mt-1 text-center">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="lead">{!! Session::get('info') !!}</span>
    </div>
@endif

@if (Session::has('success'))
    <div class="clearfix"></div>
    <div class="alert alert-success alert-block mt-1 text-center">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="lead">{!! Session::get('success') !!}</span>
    </div>
@endif


