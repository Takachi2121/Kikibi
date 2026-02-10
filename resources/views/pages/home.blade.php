@extends('layouts.app')

@section('content')
@if (session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Peringatan',
                text: '{{ session('error') }}',
            });
        });
    </script>
@endif

    @include('parts.hero')
    @include('parts.rekomendasi')
    @include('parts.cta')
    @include('parts.testimoni')
@endsection
