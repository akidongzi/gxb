@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
<div class="card-group mb-4" style="margin-top:10px;">
    <div class="card">
        <div class="card-body">
            <div class="text-value">{{ $articleNum }}</div>
            <a class="btn-block text-muted justify-content-between align-items-center" href="{{ route('admin.articles.index') }}">
                <small class="text-muted text-uppercase font-weight-bold">文章</small> 
            </a>      
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="text-value">{{ $atlasNum }}</div>
            <a class="btn-block text-muted justify-content-between align-items-center" href="{{ route('admin.article_atlas.index') }}">
                <small class="text-muted text-uppercase font-weight-bold">图文</small> 
            </a>      
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="text-value">{{ $videoNum }}</div>
            <a class="btn-block text-muted justify-content-between align-items-center" href="{{ route('admin.videos.index') }}">
                <small class="text-muted text-uppercase font-weight-bold">视频</small> 
            </a>      
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="text-value">{{ $labelNum }}</div>
            <a class="btn-block text-muted justify-content-between align-items-center" href="{{ route('admin.labels.index') }}">
                <small class="text-muted text-uppercase font-weight-bold">标签</small> 
            </a>      
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="text-value">{{ $positionNum }}</div>
            <a class="btn-block text-muted justify-content-between align-items-center" href="{{ route('admin.positions.index') }}">
                <small class="text-muted text-uppercase font-weight-bold">位置</small> 
            </a>      
        </div>
    </div>
</div>
@endsection
