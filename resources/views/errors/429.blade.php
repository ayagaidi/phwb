@extends('errors::layout')

@section('title', '429 - ' . (app()->getLocale() === 'en' ? 'Too Many Requests' : 'طلبات كثيرة جداً'))
@section('code', '429')
@section('message', app()->getLocale() === 'en' ? 'Too Many Requests' : 'طلبات كثيرة جداً')
@section('description', app()->getLocale() === 'en' 
    ? 'You have made too many requests. Please slow down and try again later.'
    : 'لقد أرسلت طلبات كثيرة جداً. يرجى الانتظار قليلاً والمحاولة مرة أخرى.')
