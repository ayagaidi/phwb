@extends('errors::layout')

@section('title', '419 - ' . (app()->getLocale() === 'en' ? 'Page Expired' : 'انتهت صلاحية الصفحة'))
@section('code', '419')
@section('message', app()->getLocale() === 'en' ? 'Page Expired' : 'انتهت صلاحية الصفحة')
@section('description', app()->getLocale() === 'en' 
    ? 'The page has expired due to inactivity. Please refresh and try again.'
    : 'انتهت صلاحية الصفحة بسبب عدم النشاط. يرجى تحديث الصفحة والمحاولة مرة أخرى.')
