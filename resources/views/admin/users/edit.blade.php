@extends('layouts.admin')

@section('content')

    <h1>Edit User</h1>
    <div class="col-sm-3" >
        <img class="img-responsive img-rounded" src="{{$user->photo ? $user->photo->getPhotoUrl($user->photo->file):$user->photo->getPhotoUrl('') }}" alt="User photo">
    </div>


<div class="col-sm-9">
    {!! Form::model($user,['method'=>'PATCH','action'=>['AdminUsersController@update', $user->id],'files'=>true]) !!}
    <div class="form-group">
        {!! Form::label('name','Name:') !!}
        {!! Form::text('name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('email','Email:') !!}
        {!! Form::text('email',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('role_id','Role:') !!}
        {!! Form::select('role_id',[""=>'Choose option'] + $roles, null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('is_active','Status:') !!}
        {!! Form::select('is_active',array(1 =>'Active', 0=>'Not Active'), null,['class'=>'form-control'] )!!}
    </div>
    <div class="form-group">
        {!! Form::label('photo','Picture:') !!}
        {!! Form::file('photo',['class'=>'form-control-file']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password','Password:') !!}
        {!! Form::Password('password',['class'=>'form-control']) !!}
    </div>
    <div class="form-group">

        {!! Form::submit('Edit User',['class'=>'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@stop