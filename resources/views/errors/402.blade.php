@extends('errors::layout')

@section('title', '402 - ' . (app()->getLocale() === 'en' ? 'Payment Required' : 'الدفع مطلوب'))
@section('code', '402')
@section('message', app()->getLocale() === 'en' ? 'Payment Required' : 'الدفع مطلوب')
@section('description', app()->getLocale() === 'en' 
    ? 'Payment is required to access this resource.'
    : 'يتطلب الدفع للوصول إلى هذا المورد.')
