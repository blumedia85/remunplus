@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit client
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- successful message --}}
        <?php $message = Session::get('message'); ?>
        @if( isset($message) )
        <div class="alert alert-success">{{$message}}</div>
        @endif
        @if($errors->has('model') )
            <div class="alert alert-danger">{{$errors->first('model')}}</div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin">{{isset($user->id) ? '<i class="fa fa-pencil"></i> Edit' : '<i class="fa fa-user"></i> Create'}} Client</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
<!--                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <a href="{{URL::action('Mentordeveloper\Authentication\Controllers\CompanyController@postEditProfile',["user_id" => $user->id])}}" class="btn btn-info pull-right" {{! isset($user->id) ? 'disabled="disabled"' : ''}}><i class="fa fa-user"></i> Edit profile</a>
                    </div>
                </div>-->
                <div class="col-md-12 col-xs-12">
                    <h4>Client data</h4>
                    {{Form::model($user, [ 'url' => URL::action('Mentordeveloper\Authentication\Controllers\CompanyController@postEditCompany')] ) }}
                    {{-- Field hidden to fix chrome and safari autocomplete bug --}}
                    {{Form::password('__to_hide_password_autocomplete', ['class' => 'hidden'])}}
                    <!-- email text field -->
                    <div class="form-group">
                        {{Form::label('email','Email: *')}}
                        {{Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'user email', 'autocomplete' => 'off'])}}
                        <input type="hidden" name="client_id" id="client_id" value="1" />
                    </div>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                    <!-- password text field -->
                    <div class="form-group">
                        {{Form::label('password',isset($user->id) ? "Change password: " : "Password: ")}}
                        {{Form::password('password', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => ''])}}
                    </div>
                    <span class="text-danger">{{$errors->first('password')}}</span>
                    <!-- password_confirmation text field -->
                    <div class="form-group">
                        {{Form::label('password_confirmation',isset($user->id) ? "Confirm change password: " : "Confirm password: ")}}
                        {{Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => '','autocomplete' => 'off'])}}
                    </div>
                    <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                    
                    <!-- Compnay Name text field -->
                    <div class="form-group">
                        {{Form::label('company_name','Company Name: *')}}
                        {{Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => 'Company name', 'autocomplete' => 'off'])}}
                    </div>
                    <span class="text-danger">{{$errors->first('company_name')}}</span>
                    
                    <!-- Employer Name text field -->
                    <div class="form-group">
                        {{Form::label('employer_name','Employer Name: *')}}
                        {{Form::text('employer_name', null, ['class' => 'form-control', 'placeholder' => 'Employer Name', 'autocomplete' => 'off'])}}
                    </div>
                    <span class="text-danger">{{$errors->first('employer_name')}}</span>
                    
                    <!-- Employer Number text field -->
                    <div class="form-group">
                        {{Form::label('employer_number','Employer Number: *')}}
                        {{Form::text('employer_number', null, ['class' => 'form-control', 'placeholder' => 'Employer Number', 'autocomplete' => 'off'])}}
                    </div>
                    <span class="text-danger">{{$errors->first('employer_number')}}</span>
                    
                    <!-- Address text field -->
                    <div class="form-group">
                        {{Form::label('address','Address: ')}}
                        {{Form::textarea ('address', null, ['class' => 'form-control', 'placeholder' => 'user email', 'autocomplete' => 'off'])}}
                    </div>
                    <span class="text-danger">{{$errors->first('address')}}</span>
                   
                    <div class="form-group">
                        {{Form::label("parish","Parish: ")}}
                        {{Form::select('parish', ["1" => "parish 1", "0" => "parish 2"], (isset($user->activated) && $user->activated) ? $user->activated : "0", ["class"=> "form-control"] )}}
                    </div>
                    <!-- Contact # text field -->
                    <div class="form-group">
                        {{Form::label('contact_number','Contact Number: *')}}
                        {{Form::text ('contact_number', null, ['class' => 'form-control', 'placeholder' => 'Contact #', 'autocomplete' => 'off'])}}
                    </div>
                    <span class="text-danger">{{$errors->first('contact_number')}}</span>
                    
                    <!-- Start Date text field -->
                    <div class="form-group">
                        {{Form::label('start_date','Start Date: *')}}
                        {{Form::text ('start_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'Subscription Start Date', 'autocomplete' => 'off'])}}
                    </div>
                    <span class="text-danger">{{$errors->first('start_date')}}</span>
                    <!-- End Date text field -->
                    <div class="form-group">
                        {{Form::label('end_date','End Date: *')}}
                        {{Form::text ('end_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'Subscription End Date', 'autocomplete' => 'off'])}}
                    </div>
                    <span class="text-danger">{{$errors->first('end_date')}}</span>
                    
                    <div class="form-group">
                        {{Form::label("activated","Client active: ")}}
                        {{Form::select('activated', ["1" => "Yes", "0" => "No"], (isset($user->activated) && $user->activated) ? $user->activated : "0", ["class"=> "form-control"] )}}
                    </div>
<!--                    <div class="form-group">
{{--                        {{Form::label("banned","Banned: ")}}
                        {{Form::select('banned', ["1" => "Yes", "0" => "No"], (isset($user->banned) && $user->banned) ? $user->banned : "0", ["class"=> "form-control"] )}}
    --}}                </div>-->
                    {{Form::hidden('id')}}
                    {{Form::hidden('form_name','client')}}
                    <a href="{{URL::action('Mentordeveloper\Authentication\Controllers\CompanyController@deleteCompany',['id' => $user->id, '_token' => csrf_token()])}}" class="btn btn-danger pull-right margin-left-5 delete">Delete Client</a>
                    {{Form::submit('Save', array("class"=>"btn btn-info pull-right "))}}
                    {{Form::close()}}
                    </div>
                </div>
            </div>
      </div>
</div>
@stop

@section('footer_scripts')
<script>
    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
</script>
@stop