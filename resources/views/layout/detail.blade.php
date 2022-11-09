@extends('layout.dashboard.index')
@section('dashboardcontent')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{$title}}
                </h4>
                <form class="edit-forms" id="form-detail" method="POST" action="{{route('update-'.$controller)}}">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="id" value="{{ $detail->id}}">
                        @foreach ($forms as $form)
                        @php
                        $rowname = $form[0];
                        $rowtype = $form[1];
                        $label = $form[2];
                        @endphp
                        @if ($rowtype == 'text')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{$rowname}}">
                                    {{$label}}
                                </label>
                                <input type="text" class="form-control @error($rowname) is-invalid @enderror"
                                    id="{{$rowname}}" name="{{$rowname}}" value="{{$detail->$rowname}}"
                                    placeholder="Insert {{$label}}">
                                @error($rowname)
                                <div class="invalid-feedback" for="{{$rowname}}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @elseif ($rowtype == 'number')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{$rowname}}">
                                    {{$label}}
                                </label>
                                <input type="number" class="form-control @error($rowname) is-invalid @enderror"
                                    id="{{$rowname}}" name="{{$rowname}}" value="{{$detail->$rowname}}"
                                    placeholder="Insert {{$label}}">
                                @error($rowname)
                                <div class="invalid-feedback" for="{{$rowname}}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @elseif ($rowtype == 'password')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{$rowname}}">
                                    {{$label}}
                                </label>
                                <input type="password" class="form-control @error($rowname) is-invalid @enderror"
                                    id="{{$rowname}}" name="{{$rowname}}" value="" placeholder="Insert {{$label}}">
                                @error($rowname)
                                <div class="invalid-feedback" for="{{$rowname}}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @elseif ($rowtype == 'textarea')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{$rowname}}">
                                    {{$label}}
                                </label>
                                <textarea class="form-control @error($rowname) is-invalid @enderror" id="{{$rowname}}"
                                    name="{{$rowname}}" rows="4"
                                    placeholder="Insert {{$label}}">{{$detail->$rowname}}</textarea>
                                @error($rowname)
                                <div class="invalid-feedback" for="{{$rowname}}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @elseif ($rowtype == 'date')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{$rowname}}">
                                    {{$label}}
                                </label>
                                <input type="text" class="form-control datepicker @error($rowname) is-invalid @enderror"
                                    id="{{$rowname}}" name="{{$rowname}}" value="{{$detail->$rowname}}"
                                    placeholder="Insert {{$label}}">
                                @error($rowname)
                                <div class="invalid-feedback" for="{{$rowname}}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @elseif ($rowtype == 'select')
                        @php
                        $value = $form[3];
                        @endphp
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{$rowname}}">
                                    {{$label}}
                                </label>
                                <select id="{{ $rowname}}" name="{{ $rowname}}"
                                    class="w-100 form-select select2 @error($rowname) is-invalid @enderror">
                                    <option></option>
                                    @foreach ($value as $v)
                                    <option {{($v->id == $detail->$rowname) ? 'selected' : ''}} value="{{$v->id}}">
                                        {{ $v->text}}
                                    </option>
                                    @endforeach
                                </select>
                                @error($rowname)
                                <div class="invalid-feedback" for="{{$rowname}}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection