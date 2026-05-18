@extends('admin.layouts.app')

@section('title', __('changelog.title'))
@section('header', __('changelog.header'))
@section('breadcrumb')
    <span style="color:#dee2e6">/</span>
    <span style="color:#495057">{{ __('changelog.title') }}</span>
@endsection

@section('content')
@include('admin.partials.changelog_content')
@endsection
