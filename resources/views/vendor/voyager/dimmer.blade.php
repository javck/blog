<div class="panel widget center bgimage" style="margin-bottom:0;overflow:hidden;background-image:url('{{ $image }}');">
    <div class="dimmer"></div>
    <div class="panel-content">
        客製化內容
        @if (isset($icon))<i class='{{ $icon }}'></i>@endif
        <p>{!! $text !!}</p>
        <h4>{!! $title !!}</h4>
        <a href="{{ $button['link'] }}" class="btn btn-primary">{!! $button['text'] !!}</a>
    </div>
</div>
