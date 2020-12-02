@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css"
    integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA=="
    crossorigin="anonymous" />
@endsection


@section('navegacion')
@include('ui.adminnav')
@include('ui.categoriasnav')
@endsection

@section('content')
<h1 class="text-3xl text-center mt-10">{{$vacante->titulo}}</h1>

<div class="mt-10 mb-20 md:flex items-start">
    <div class="md:w-3/5">
        <p class="block text-gray-700 font-bold my-2">
            Publicado: <span class="font-normal">{{$vacante->created_at->diffForHumans()}}</span>
            Por: <span class="font-normal">{{$vacante->reclutador->name}}</span>
        </p>
        <p class="block text-gray-700 font-bold my-2">
            Categoría: <span class="font-normal">{{$vacante->categoria->nombre}}</span>
        </p>
        <p class="block text-gray-700 font-bold my-2">
            Salario: <span class="font-normal">{{$vacante->salario->nombre}}</span>
        </p>
        <p class="block text-gray-700 font-bold my-2">
            Ubicación: <span class="font-normal">{{$vacante->ubicacion->nombre}}</span>
        </p>
        <p class="block text-gray-700 font-bold my-2">
            Experiencia: <span class="font-normal">{{$vacante->experiencia->nombre}}</span>
        </p>

        <h2 class="text-2xl text-center mt-10 text-gray-700 mb-5">Conocimientos y Tecnologías</h2>

        @php
        $arraySkills = explode(",", $vacante->skills)
        @endphp
        @foreach ($arraySkills as $skill)
        <p class="inline-block border border-gray-400 rounded py-2 px-8 text-gray-700 my-2">
            {{$skill}}
        </p>
        @endforeach

        <a href="/storage/vacantes/{{ $vacante->imagen }}" data-lightbox="imagen"
            data-title="Vacante {{ $vacante->titulo}} ">
            <img src="/storage/vacantes/{{ $vacante->imagen }}" alt="imagen vacante" class="w-40 mt-10">
        </a>
        <div class="descripcion mt-10 mb-5">
            {!! $vacante->descripcion !!}
        </div>
    </div>

    @if ($vacante->activa ===1 )
    <div class="md:w-2/5 bg-teal-500 p-5 rounded m-3">
        <h2 class="text-2xl my-5 text-white uppercase font-bold text-center">Contacta al reclutador</h2>

        <form action="{{ route('candidatos.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="nombre" class="block text-white text-sm font-bold mb-4">Nombre:</label>
                <input type="text" name="nombre" id="nombre"
                    class="p-3 bg-gray-100 rounded form-input w-full @error('nombre') border border-red-500 @enderror"
                    placeholder="Tu Nombre" value="{{ old('nombre') }}">

                @error('nombre')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 w-full mt-5" role="alert">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-white text-sm font-bold mb-4">Email:</label>
                <input type="text" name="email" id="email"
                    class="p-3 bg-gray-100 rounded form-input w-full @error('email') border border-red-500 @enderror"
                    placeholder="Tu Email" value="{{ old('email') }}">

                @error('email')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 w-full mt-5" role="alert">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="cv" class="block text-white text-sm font-bold mb-4">Curriculum (PDF):</label>
                <input type="file" name="cv" id="cv"
                    class="p-3 rounded form-input w-full @error('cv') border border-red-500 @enderror"
                    accept="application/pdf">

                @error('cv')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 w-full mt-5" role="alert">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>
            <input type="hidden" name="vacante_id" value="{{$vacante->id}}">
            <input type="submit" value="Contactar"
                class="bg-teal-600 w-full hover:bg-teal-700 text-gray-100 p-3 focus:outline-none focus:shadow-outline uppercase">
        </form>
    </div>

    @endif

</div>
@endsection
