@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div style="color:red">{{$error}}</div>
    @endforeach
@endif

<div class="form-group">
    {!! Form::label('name', '歌曲名稱', ['class'=>'awesome']) !!}
    {!! Form::text('name', null, []) !!}
</div>

<div class="form-group">
    {!! Form::label('url', '歌曲網址', ['class'=>'awesome']) !!}
    {!! Form::text('url', 'http://google.com', []) !!}
</div>

<div class="form-group">
    {!! Form::label('desc', '歌曲描述', []) !!}
    {!! Form::textarea('desc', null, ['cols'=>60,'rows'=>10,'class'=>'awesome']) !!}
</div>

<div class="form-group">
    {!! Form::label('isRecommend', '是否為推薦歌曲', []) !!}
    {!! Form::checkbox('isRecommend', 1, false,[]) !!}
</div>

<div class="form-group">
    {!! Form::label('style[]', '曲風', []) !!}
    {{--  Rock{!! Form::checkbox('style[]', 'rock', false,[]) !!}
    藍調{!! Form::checkbox('style[]
    ', 'blue', false,[]) !!}
    Fashion{!! Form::checkbox('style[]', 'fashion', false,[]) !!}  --}}
    {!! Form::select('style[]', $styles) !!}
</div>

<div class="form-group">
    {!! Form::label('people', '受眾', []) !!}
    男孩{!! Form::radio('people', 'boy', true,[]) !!}
    女孩{!! Form::radio('people', 'girl', false,[]) !!}
</div>

<div class="form-group">
    {!! Form::label('hit', '熱門數', []) !!}
    {!! Form::number('hit', 0, ['min' =>0,'max'=>50]) !!}
</div>
@if ($errors->has('hit'))
    <div style="color:red">{{ $errors->first('hit')}}</div>
@endif

<div class="form-group">
    {!! Form::label('cgy_id', '分類', []) !!}
    {!! Form::select('cgy_id', $cgies,array_key_first($cgies->toArray()),['placeholder' => '請選擇分類']) !!}
</div>

{{-- <div class="form-group">
    {!! Form::label('cgy_id', '詳細分類', []) !!}
    {!! Form::select('cgy_id',
    ['A分類'=>[1=>'推薦類',2=>'當季類',3=>'超值類'],'B分類'=>[4=>'不推薦類',5=>'不當季類',6=>'不超值類']],null,['placeholder' => '請選擇分類'])
    !!}
</div> --}}
<div class="form-group">
    {!! Form::label('month', '發行月份', []) !!}
    {!! Form::selectMonth('month', null,['placeholder'=>'請選擇月份']) !!}
</div>

<div class="form-group">
    {!! Form::label('album_id', '所屬專輯', []) !!}
    {!! Form::selectRange('album_id', 1, 20) !!}
</div>

<div class="form-group">
    {!! Form::label('password', '請輸入密碼', []) !!}
    {!! Form::password('password') !!}
</div>

<div class="form-group">
    {!! Form::label('email', '請輸入E-mail', []) !!}
    {!! Form::email('email','info@demo.com') !!}
</div>

<div class="form-group">
    {!! Form::label('pic', '歌曲圖片', []) !!}
    {!! Form::file('pic') !!}
</div>

<div class="form-group">
    {!! Form::label('sell_at', '上市日期', []) !!}
    {!! Form::date('sell_at',\Carbon\Carbon::now()) !!}
</div>

<div class="form-group">
    {!! Form::label('published_time', '發表日期', []) !!}
    {!! Form::date('published_time',\Carbon\Carbon::now()) !!}
</div>

{!! Form::hidden('secret', 'helloworld') !!}

{!! Form::submit('送出') !!}
{!! Form::reset('重置') !!}


