@extends('layouts.app')

@section('content')
  <div id="app">
    <formulario></formulario>
  </div>
@endsection

@push('scripts')
  <script src="{{ mix('js/app.js') }}"></script>
@endpush
