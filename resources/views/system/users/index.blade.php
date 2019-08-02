@extends('navbarerp')

@section('main')
    @can('system_user_view')
    <div class="panel-heading">
        @if (Auth::user()->can('system_user_maintain'))
            <a href="users/create" class="btn btn-sm btn-success">新建</a>
        @endif
        <div class="pull-right" style="padding-top: 4px;">
            <a href="{{ URL::to('system/roles') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{'角色管理', [], 'layouts'}}</a>
        </div> 
    </div>

    <div class="panel-body">
        {!! Form::open(['url' => '/system/users/search', 'class' => 'pull-right form-inline']) !!}
        <div class="form-group-sm">
            {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => '姓名']) !!}
            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

@if (Auth::user()->email == "admin@admin.com")
        {{--{!! Form::button('与钉钉取消绑定', ['class' => 'btn btn-default btn-sm pull-right', 'id' => 'btnCancelBindDT']) !!}--}}
            {{--{!! Form::button('聊天2', ['class' => 'btn btn-default btn-sm pull-right', 'id' => 'btnPickConversation']) !!}--}}
        {{--<a href="{{ URL::to('dingtalk/delete_call_back') }}">与钉钉取消绑定</a>--}}

        {{--{!! Form::open(['url' => '/system/users/bingdingtalk', 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('与钉钉强绑定', ['class' => 'btn btn-default btn-sm']) !!}            --}}
        {{--{!! Form::close() !!}--}}

        {{--{!! Form::open(['url' => '/dingtalk/receive', 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('与钉钉强绑定222', ['class' => 'btn btn-default btn-sm']) !!}            --}}
        {{--{!! Form::close() !!}--}}

        {{--{!! Form::open(['url' => '/faceplusplus/detect', 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('人脸监测', ['class' => 'btn btn-default btn-sm']) !!}            --}}
        {{--{!! Form::close() !!}--}}

        {{--{!! Form::open(['url' => '/faceplusplus/faceset_create', 'class' => 'pull-right', 'files' => true]) !!}--}}
            {{--{!! Form::submit('人脸集合', ['class' => 'btn btn-default btn-sm']) !!}            --}}
        {{--{!! Form::close() !!}--}}

        {{--{!! Form::open(['url' => '/faceplusplus/compare', 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::hidden('api_key', 'eLObusplEGW0dCfBDYceyhoAdvcEaQtk', []) !!}--}}
            {{--{!! Form::hidden('api_secret', 'bWJAjmtylVZ6A8Ik4_vC1xBO3X3cyKJT', []) !!}--}}
            {{--{!! Form::hidden('image_url1', 'http://static.dingtalk.com/media/lADOlob6ns0CgM0CgA_640_640.jpg', []) !!}--}}
            {{--{!! Form::hidden('image_url2', 'http://static.dingtalk.com/media/lADOlob7MM0CgM0CgA_640_640.jpg', []) !!}--}}
            {{--{!! Form::submit('人脸对比测试', ['class' => 'btn btn-default btn-sm']) !!}            --}}
        {{--{!! Form::close() !!}--}}



        {{--{!! Form::open(['url' => url('/dingtalk/chat_create'), 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('聊天', ['class' => 'btn btn-default btn-sm']) !!}--}}
        {{--{!! Form::close() !!}--}}

            {{--{!! Form::open(['url' => url('/system/users/updateuseroldall'), 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('设置与老系统的对应关系', ['class' => 'btn btn-default btn-sm']) !!}--}}
            {{--{!! Form::close() !!}--}}

            {{--{!! Form::open(['url' => url('/dingtalk/synchronizeusers'), 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('同步钉钉人员到本地用户', ['class' => 'btn btn-default btn-sm']) !!}--}}
            {{--{!! Form::close() !!}--}}

@endif
    </div>    

    @if ($users->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>姓名</th>
                <th>邮箱</th>
                {{--<th>部门</th>--}}
                {{--<th>职位</th>--}}
                <th>角色</th>
                {{--<th>Google Authentication</th>--}}
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    {{--<td>--}}
                        {{--@if (isset($user->dept->name)) {{ $user->dept->name }} @endif--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--{{ $user->position }}--}}
                    {{--</td>--}}
                    <td>
                        <a href="{{ URL::to('/system/users/'.$user->id.'/roles') }}">明细</a>
                    </td>
                    {{--<td>--}}
                        {{--<a href="{{ url('/system/users/' . $user->id . '/google2fa') }}" class="btn btn-default btn-sm">设置</a>--}}
                    {{--</td>--}}
                    <td>
                        <a href="{{ URL::to('/system/users/'.$user->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        <a href="{{ URL::to('/system/users/'.$user->id.'/editpass') }}" class="btn btn-success btn-sm pull-left">修改密码</a>
                        {!! Form::open(array('route' => array('users.destroy', $user->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    @if (isset($key))
        {!! $users->setPath('/system/users')->appends([
            'key' => $inputs['key']
        ])->links() !!}
    @else
        {!! $users->setPath('/system/users')->links() !!}
    @endif

    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif
@else
        无权限。
@endcan
@endsection

