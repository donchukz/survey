@extends('layouts.app')

@section('title')
    {{$survey->title}} - Survey
@endsection

@section('css')
    <style>
        .tx-danger{
            color: red
        }
    </style>
@endsection

@section('content')

    <section class="vbox">

        <section class="scrollable padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Survey</li>
                <li><a href="javascript:void(0)" onclick="window.history.back();">Go Back</a></li>
            </ul>


            <div class="card-body">

                <form method="POST" action="{{route('survey.app.submit')}}">
                    @csrf
                    @method('POST')
                    <input autocomplete="off" type="hidden" name="survey_id" value="{{request()->segment(count(request()->segments()))}}">
                    <h3>{{$survey->title}}</h3>
                    <section>

                        <label class="form-control-label">Participant Name <span class="tx-danger">*</span> </label><br>
                        <input autocomplete="off" class="form-control" name="user" id="user" required placeholder="" type="text">

                        @foreach($survey->questions as $key => $question)
                            <div class="row row-sm" style="padding-top: 15px;">

                                <div class="col-md-12">

                                    @if($question->input_type == 'input')
                                        <input autocomplete="off" type="hidden" name="label[]" value="{{$question->label}}">
                                        <input autocomplete="off" type="hidden" name="question[]" value="{{$question->id}}">
                                        <label class="form-control-label">{{$question->label}}: @if($question->mandatory) <span class="tx-danger">*</span> @endif </label><br>
                                        <input autocomplete="off" class="form-control" name="{{\App\Helper\Helper::clean($question->label)}}" id="{{\App\Helper\Helper::clean($question->label)}}" @if($question->mandatory) required @endif placeholder="" type="text">

                                    @elseif($question->input_type == 'select')
                                        <input autocomplete="off" type="hidden" name="label[]" value="{{$question->label}}">
                                        <input autocomplete="off" type="hidden" name="question[]" value="{{$question->id}}">
                                        <label for="{{\App\Helper\Helper::clean($question->label)}}" class="form-control-label">{{$question->label}}: @if($question->mandatory) <span class="tx-danger">*</span> @endif </label><br>
                                        <select style="width: 100%;" class="form-control create_select" name="{{\App\Helper\Helper::clean($question->label)}}@if($question->multi_select_option)[]@endif" id="{{\App\Helper\Helper::clean($question->label)}}" @if($question->multi_select_option) multiple @endif @if($question->mandatory) required @endif>
                                            @foreach($survey->questions[$key]->options as $option)
                                                <option value="{{$option->option}}">{{$option->option}}</option>
                                            @endforeach
                                        </select>

                                    @elseif($question->input_type == 'textarea')
                                        <input autocomplete="off" type="hidden" name="question[]" value="{{$question->id}}">
                                        <input autocomplete="off" type="hidden" name="label[]" value="{{$question->label}}">
                                        <label for="{{\App\Helper\Helper::clean($question->label)}}" class="form-control-label">{{$question->label}}: @if($question->mandatory) <span class="tx-danger">*</span> @endif </label><br>
                                        <textarea class="form-control" name="{{\App\Helper\Helper::clean($question->label)}}" id="{{\App\Helper\Helper::clean($question->label)}}" placeholder="" rows="3" @if($question->mandatory) required @endif></textarea>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    </section>

                    <span style="padding-top: 20px; float: left">
                        <button type="submit" class="btn ripple btn-info">Submit</button>
                        <button style="margin-left: 5px;" onclick="window.history.back();" class="btn ripple btn-secondary" type="button">Cancel</button>
                    </span>
                </form>

            </div>

        </section>
    </section>

@endsection

@section('scripts')

@endsection
