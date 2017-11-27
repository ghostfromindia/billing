@extends('layouts.base')
@section('title','DashBoard')
@section('content')

        <div class="card pd-20 pd-sm-40">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>

@endsection
