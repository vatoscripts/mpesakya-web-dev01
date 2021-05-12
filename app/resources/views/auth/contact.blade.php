@extends('layout.auth')

@section('content')
    <div id="app"> <!-- ID: 'app' -->
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h2>Contact me</h2>
                    </div>
                    <div class="card-body">
                        <!-- Our component: -->
                        <contact-form></contact-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
