@extends('errors::layout')

@section('title', '500 - ' . (app()->getLocale() === 'en' ? 'Server Error' : 'خطأ في الخادم'))
@section('code', '500')
@section('message', app()->getLocale() === 'en' ? 'Internal Server Error' : 'خطأ داخلي في الخادم')
@section('description', app()->getLocale() === 'en' 
    ? 'Something went wrong on our servers. We are working to fix it.'
    : 'حدث خطأ في خوادمنا. نحن نعمل على إصلاحه.')
