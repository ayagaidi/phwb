@extends('errors::layout')

@section('title', '403 - ' . (app()->getLocale() === 'en' ? 'Forbidden' : 'ممنوع الوصول'))
@section('code', '403')
@section('message', app()->getLocale() === 'en' ? 'Access Forbidden' : 'ممنوع الوصول')
@section('description', app()->getLocale() === 'en' 
    ? 'You do not have permission to access this page.'
    : 'ليس لديك الصلاحية للوصول إلى هذه الصفحة.')
