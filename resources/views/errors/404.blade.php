@extends('errors::minimal')

@section('title', __($exception->getMessage()))
@section('code', '404')
@section('message', __($exception->getMessage()))
