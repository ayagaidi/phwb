@extends('errors::layout')

@section('title', '401 - ' . (app()->getLocale() === 'en' ? 'Unauthorized' : 'غير مصرح'))
@section('code', '401')
@section('message', app()->getLocale() === 'en' ? 'Unauthorized Access' : 'غير مصرح بالدخول')
@section('description', app()->getLocale() === 'en' 
    ? 'You must be logged in to access this page.'
    : 'يجب تسجيل الدخول للوصول إلى هذه الصفحة.')
