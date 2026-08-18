@extends('errors.layout')

@section('title', '419 - Sesi Kedaluwarsa')
@section('code', '419')
@section('badge', 'SESI TELAH BERAKHIR')
@section('heading', 'Sesi Keamanan Halaman Telah Berakhir')
@section('message', 'Halaman ini telah terbuka terlalu lama tanpa aktivitas sehingga token keamanan CSRF kedaluwarsa. Silakan refresh halaman dan ulangi tindakan Anda.')
