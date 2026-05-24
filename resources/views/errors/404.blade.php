@extends('errors::layout')

@section('title', '404 - ' . (app()->getLocale() === 'en' ? 'Page Not Found' : 'الصفحة غير موجودة'))
@section('code', '404')
@section('message', app()->getLocale() === 'en' ? 'Page Not Found' : 'الصفحة غير موجودة')
@section('description', app()->getLocale() === 'en' 
    ? 'Sorry, the page you are looking for could not be found.'
    : 'عذراً، الصفحة التي تبحث عنها غير موجودة.')
