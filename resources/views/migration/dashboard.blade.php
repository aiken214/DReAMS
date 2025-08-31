@extends('layouts.user')

@section('content')
@can('iar_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <form action="{{ route('supply.iar_migration.execute') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    {{ 'Migrate' }} {{ trans('cruds.iar.title_singular') }}
                </button>
            </form>
        </div>
    </div><br>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <form action="{{ route('supply.iar_migration.execute') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    {{ 'Migrate' }} {{ trans('cruds.iar.title_singular') }}
                </button>
            </form>
        </div>
    </div><br>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <form action="{{ route('supply.iar_migration.execute') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    {{ 'Migrate' }} {{ trans('cruds.iar.title_singular') }}
                </button>
            </form>
        </div>
    </div>
@endcan
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        @if(session('details'))
            <br><small>{{ session('details') }}</small>
        @endif
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@endsection
