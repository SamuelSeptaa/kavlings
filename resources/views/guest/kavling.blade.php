@extends('layout.index')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>We sale fresh fruits</p>
                    <h1>List Kavling</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- contact form -->
<div class="mt-150 mb-150">
    <div class="container-fluid">
        <div class="h6">Keterangan :</div>
        <div class="mb-3">
            <div class="d-flex align-items-center mb-2">
                <div class="kavling-keterangan mr-3"></div>
                <p>Kavling Tersedia</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="kavling nonactive mr-3"></div>
                <p>Kavling Tidak Tersedia</p>
            </div>
        </div>

        <div class="kavling-list">
            <div class="street">
                <h5>Jalan Yusuf Arimatea</h5>
            </div>
            <div class="denah-scrollable">
                <div class="block-a">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($row1->blocks as $b)
                    @php
                    $i++;
                    @endphp
                    <div class="text-center mt-2">
                        <h5>{{$b->block_name}}</h5>
                    </div>
                    <div class="block-ai p-1 my-2">
                        @if($i==1)
                        <div class="parking-area">
                            <div class="parking-text">
                                PARKING AREA
                            </div>
                        </div>
                        @endif
                        @foreach ($b->kavlings as $a)
                        <div class="kavling @if ($a->status=='UNAVAILABLE') nonactive @endif" data-id="{{$a->id}}">
                        </div>
                        @endforeach
                        @if($i==1)
                        <div class="toilets">
                            <div class="toilet-text">
                                WC
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="block-b">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($row2->blocks as $b)
                    @php
                    $i++;
                    @endphp
                    <div class="text-center mt-2">
                        <h5>{{$b->block_name}}</h5>
                    </div>
                    <div class="block-bi p-1 my-2">
                        @if($i==1)
                        <div class="parking-area">
                            <div class="parking-text">
                                PARKING AREA
                            </div>
                        </div>
                        @endif
                        @foreach ($b->kavlings as $a)
                        <div class="kavling @if ($a->status=='UNAVAILABLE') nonactive @endif" data-id="{{$a->id}}">
                        </div>
                        @endforeach
                        @if($i==2)
                        <div class="toilets">
                            <div class="toilet-text">
                                WC
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="block-c">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($row3->blocks as $b)
                    @php
                    $i++;
                    @endphp
                    <div class="text-center mt-2">
                        <h5>{{$b->block_name}}</h5>
                    </div>
                    <div class="block-ci p-1 my-2">
                        @if($i==1)
                        <div class="parking-area">
                            <div class="parking-text">
                                PARKING AREA
                            </div>
                        </div>
                        @endif
                        @foreach ($b->kavlings as $a)
                        <div class="kavling @if ($a->status=='UNAVAILABLE') nonactive @endif" data-id="{{$a->id}}">
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <div class="block-c">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($row4->blocks as $b)
                    @php
                    $i++;
                    @endphp
                    <div class="text-center mt-2">
                        <h5>{{$b->block_name}}</h5>
                    </div>
                    <div class="block-ci p-1 my-2">
                        @if($i==1)
                        <div class="parking-area">
                            <div class="parking-text">
                                PARKING AREA
                            </div>
                        </div>
                        @endif
                        @foreach ($b->kavlings as $a)
                        <div class="kavling @if ($a->status=='UNAVAILABLE') nonactive @endif" data-id="{{$a->id}}">
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <div class="block-a">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($row5->blocks as $b)
                    @php
                    $i++;
                    @endphp
                    <div class="text-center mt-2">
                        <h5>{{$b->block_name}}</h5>
                    </div>
                    <div class="block-ai p-1 my-2">
                        @if($i==1)
                        <div class="parking-area">
                            <div class="parking-text">
                                PARKING AREA
                            </div>
                        </div>
                        @endif
                        @foreach ($b->kavlings as $a)
                        <div class="kavling @if ($a->status=='UNAVAILABLE') nonactive @endif" data-id="{{$a->id}}">
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end contact form -->
<!-- end featured section -->
@endsection