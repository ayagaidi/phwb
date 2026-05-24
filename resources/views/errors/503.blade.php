@extends('errors::layout')

@section('title', '503 - ' . (app()->getLocale() === 'en' ? 'Service Unavailable' : 'الخدمة غير متاحة'))
@section('code', '503')
@section('message', app()->getLocale() === 'en' ? 'Service Unavailable' : 'الخدمة غير متاحة')
@section('description', app()->getLocale() === 'en' 
    ? 'Our service is temporarily unavailable. Please try again later.'
    : 'الخدمة غير متاحة مؤقتاً. يرجى المحاولة لاحقاً.')
