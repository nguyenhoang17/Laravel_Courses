@extends('user.layouts.master')
@section ('title')

@endsection
@section ('content')
    <div class="main-slider" id="course-one">
        <div class="">
            <div class="row">
                <div class="col-3">
                    <h2>Danh sách bài học:</h2>
                    <ul>
                        @foreach($status_course->units as $item)
                            <li style="  padding: 20px;border-bottom: 1px solid #ccc;"><a href="{{route('purchased_courses.unit',['course_id'=>$status_course->id, 'id'=>$item->id])}}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-9" style="max-height: 90vh; overflow-y: scroll; text-align: center">
                    <h2>Nội dung bài học:</h2>
                    <h3 style="padding-top: 20px">{{$unit->name}}</h3>

                    @if($unit->video)
                    <div style="margin-top: 30px">
                        <iframe width="100%" height="600px" src="{{url(\Illuminate\Support\Facades\Storage::url($unit->video))}}#toolbar=0"></iframe>
                    </div>
                    @endif

                    @if($unit->file)
                        <div style="margin-top: 50px; padding-bottom: 50px; border-bottom: 1px solid" >
                            <iframe width="100%" height="600px" src="{{url(\Illuminate\Support\Facades\Storage::url($unit->file))}}#toolbar=0"></iframe>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
@section ('script')
    <script type="text/javascript" src="/user/assets/js/purchased_course/script.js"></script>
@endsection
