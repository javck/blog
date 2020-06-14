@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Auth::user())
                        你已經完成登入

                    @else
                        你尚未登入
                    @endif
                </div>
                <div>
                    Name:{!! $name !!}
                    Age: {{ $age }}
                </div>
            </div>
        </div>
    </div>
    @include('flash::message')
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Flash Message Overlay會用到，需保留 -->
    <script>
        $('#flash-overlay-modal').modal();

        <
        !--Flash Message 3 秒之後消失， 非必須-- >
        $('div.alert').delay(3000).fadeOut(350);
    </script>
</div>
@endsection
