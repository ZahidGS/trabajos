@extends('layouts.app')

@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.3/css/medium-editor.min.css"
    integrity="sha512-zYqhQjtcNMt8/h4RJallhYRev/et7+k/HDyry20li5fWSJYSExP9O07Ung28MUuXDneIFg0f2/U3HJZWsTNAiw=="
    crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css"
    integrity="sha512-3g+prZHHfmnvE1HBLwUnVuunaPOob7dpksI7/v6UnF/rnKGwHf/GdEq9K7iEN7qTtW+S0iivTcGpeTBqqB04wA=="
    crossorigin="anonymous" />

@endsection

@section('navegacion')
@include('ui.adminnav')
@endsection

@section('content')
<h1 class="text-2xl text-center mt-10">Nueva Vacante</h1>

<form action="{{ route('vacantes.store')}}" method="post" class="max-w-lg mx-auto my-10">
    @csrf
    <div class="mb-5">
        <label for="titulo" class="block text-teal-700 text-sm mb-2">Título Vacante:</label>

        <input id="titulo" type="titulo" class="p-3 bg-teal-100 rounded form-input w-full
        @error('titulo') border-red-500 border @enderror"
        name="titulo" value="{{ old('titulo')}}">

        @error('titulo')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6"
        role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block">{{ $message }}</span>
        </div>
        @enderror

    </div>

    <div class="mb-5">
        <label for="categoria" class="block text-teal-700 text-sm mb-2">Categoria:</label>

        <select name="categoria" id="categoria" class="block appearance-none w-full border border-teal-700 rounded leading-tight
        focus:outline-none focus:bg-white focus:border-teal-500 p-3 bg-teal-100">
            <option disabled selected>Elige una opción</option>

            @foreach ($categorias as $categoria)
            <option
                {{ old('categoria') == $categoria->id ? 'selected' : '' }}
                value="{{ $categoria->id}}">
                {{ $categoria->nombre }}
            </option>
            @endforeach
        </select>


        @error('categoria')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6"
        role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block">{{ $message }}</span>
        </div>
        @enderror

    </div>


    <div class="mb-5">
        <label for="experiencia" class="block text-teal-700 text-sm mb-2">Experiencia:</label>

        <select name="experiencia" id="experiencia" class="block appearance-none w-full border border-teal-700 rounded leading-tight
        focus:outline-none focus:bg-white focus:border-teal-500 p-3 bg-teal-100">
            <option disabled selected>Elige una opción</option>

            @foreach ($experiencias as $experiencia)
            <option
                {{ old('experiencia') == $experiencia->id ? 'selected' : '' }}
                value="{{ $experiencia->id}}">
                {{ $experiencia->nombre }}
            </option>
            @endforeach
        </select>


        @error('experiencia')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6"
        role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block">{{ $message }}</span>
        </div>
        @enderror

    </div>

    <div class="mb-5">
        <label for="ubicacion" class="block text-teal-700 text-sm mb-2">Ubicación:</label>

        <select name="ubicacion" id="ubicacion" class="block appearance-none w-full border border-teal-700 rounded leading-tight
        focus:outline-none focus:bg-white focus:border-teal-500 p-3 bg-teal-100">
            <option disabled selected>Elige una opción</option>

            @foreach ($ubicaciones as $ubicacion)
            <option
                {{ old('ubicacion') == $ubicacion->id ? 'selected' : '' }}
                value="{{ $ubicacion->id}}">
                {{ $ubicacion->nombre }}
            </option>
            @endforeach
        </select>


        @error('ubicacion')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6"
        role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block">{{ $message }}</span>
        </div>
        @enderror

    </div>

    <div class="mb-5">
        <label for="salario" class="block text-teal-700 text-sm mb-2">Salario:</label>

        <select name="salario" class="block appearance-none w-full border border-teal-700 rounded leading-tight
        focus:outline-none focus:bg-white focus:border-teal-500 p-3 bg-teal-100">
            <option disabled selected>Elige una opción</option>

            @foreach ($salarios as $salario)
            <option
                {{ old('salario') == $salario->id ? 'selected' : '' }}
                value="{{ $salario->id}}">
                {{ $salario->nombre }}
            </option>
            @endforeach
        </select>


        @error('salario')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6"
        role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block">{{ $message }}</span>
        </div>
        @enderror

    </div>


    <div class="mb-5">
        <label for="descripcion" class="block text-teal-700 text-sm mb-2">Descripción del puesto:</label>
        <div class="editable p-3 bg-teal-100 rounded form-input w-full text-teal-700"></div>
        <input type="hidden" name="descripcion" id="descripcion" value="{{ old('descripcion')}}">

        @error('descripcion')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6"
        role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block">{{ $message }}</span>
        </div>
        @enderror

    </div>

    <div class="mb-5">
        <label for="imagen" class="block text-teal-700 text-sm mb-2">Imagen Vacante:</label>
        <div id="dropzoneDevJobs" class="dropzone rounded bg-gray-100"></div>
        <input type="hidden" name="imagen" id="imagen" value="{{old('imagen')}}">

        @error('imagen')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6"
        role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block">{{ $message }}</span>
        </div>
        @enderror

    </div>
    <div id="error"></div>


    <div class="mb-5">
        <label for="skills" class="block text-teal-700 text-sm mb-2">
            Habilidades y Conocimientos: <span class="text-xs">(Elige al menos 3)</span></label>
        @php
        $skills = ['HTML5', 'CSS3', 'CSSGrid', 'Flexbox', 'JavaScript', 'jQuery', 'Node', 'Angular', 'VueJS', 'ReactJS',
        'React Hooks', 'Redux', 'Apollo', 'GraphQL', 'TypeScript', 'PHP', 'Laravel', 'Symfony', 'Python', 'Django',
        'ORM', 'Sequelize', 'Mongoose', 'SQL', 'MVC', 'SASS', 'WordPress', 'Express', 'Deno', 'React Native', 'Flutter',
        'MobX', 'C#', 'Ruby on Rails']
        @endphp
        <lista-skills
        :skills="{{ json_encode($skills) }}"
        :oldskills="{{ json_encode( old('skills') )}}"
        ></lista-skills>

        @error('skills')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-6"
        role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block">{{ $message }}</span>
        </div>
        @enderror

    </div>

    <button type="submit" class="bg-teal-600 w-full hover:bg-teal-700 text-white font-bold
        py-2 px-4 rounded focus:outline-none focus:shadow-outline uppercase">
        Publicar Vacante
    </button>

</form>
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.3/js/medium-editor.min.js"
    integrity="sha512-5D/0tAVbq1D3ZAzbxOnvpLt7Jl/n8m/YGASscHTNYsBvTcJnrYNiDIJm6We0RPJCpFJWowOPNz9ZJx7Ei+yFiA=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.js"
    integrity="sha512-8l10HpXwk93V4i9Sm38Y1F3H4KJlarwdLndY9S5v+hSAODWMx3QcAVECA23NTMKPtDOi53VFfhIuSsBjjfNGnA=="
    crossorigin="anonymous"></script>

<script>
    Dropzone.autoDiscover = false;

    document.addEventListener('DOMContentLoaded', () => {

        //Medium Editor
        const editor = new MediumEditor('.editable', {
            toolbar: {
                buttons: ['bold', 'italic', 'underline', 'anchor', 'h2', 'h3', 'quote', 'justifyLeft', 'justifyCenter','justifyRight','justifyFull','orderedlist','unorderedlist','h2','h3'],
                static: true,
                sticky: true,
            },
            placeholder: {
                text: 'Información de la vacante'
            }
        });

        //agrega al input hidden lo que el usuario escribe en medium editor
        editor.subscribe('editableInput', function(eventObj, editable){
            const contenido = editor.getContent();
            document.querySelector('#descripcion').value= contenido;
        })

        //llena el editor con el contenido del input hidden
        editor.setContent( document.querySelector('#descripcion').value );


        //DropZone -- es el manejador de imagenes del div id="dropzoneDevJobs"
        const dropzoneDevJobs = new Dropzone('#dropzoneDevJobs',{
            url: "/vacantes/imagen", //url que se manda al controler
            dictDefaultMessage: 'Sube aquí tu imagen', //definir el mensaje a mostrar
            acceptedFiles: ".png,.jpg,.jpeg,.gif,.bmp", //formatos que acepta
            addRemoveLinks: true, //que se puedan quitar las imagenes previa
            dictRemoveFile: 'Borrar archivo', //mostrar mensaje para quitar la imagen previa
            maxFiles: 1,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            init: function(){
                if (document.querySelector('#imagen').value.trim()) {
                    let imagenPublicada = {};
                    imagenPublicada.size = 1234;
                    imagenPublicada.name = document.querySelector('#imagen').value;

                    this.options.addedfile.call(this, imagenPublicada); //this se refiere a dropZoneDevJobs
                    this.options.thumbnail.call(this, imagenPublicada, `/storage/vacantes/${imagenPublicada.name}`);

                    imagenPublicada.previewElement.classList.add('dz-success');
                    imagenPublicada.previewElement.classList.add('dz-complete');
                }
            },
            success: function(file,response){
                //console.log(response); //este response es la respuesta que viene desde el controller
                console.log(response.correcto);

                //limpiar div de error
                document.querySelector('#error').textContent = '';

                //coloca la respuesta del servidor en el input
                document.querySelector('#imagen').value = response.correcto;

                //añadir al objeto de archivo el nombre de servidor
                file.nombreServidor = response.correcto;
            },

            maxfilesexceeded: function(file){
                if (this.files[1] != null) {
                    this.removeFile(this.files[0]); //elimina el archivo anterior
                    this.addFile(file); //agrega el nuevo archivo
                }
            },
            removedfile: function(file, response){
                file.previewElement.parentNode.removeChild(file.previewElement);

                params = {
                    imagen: file.nombreServidor ?? document.querySelector('#imagen').value
                }

                axios.post('/vacantes/borrarimagen', params)
                    .then(respuesta => console.log(respuesta))
            }
        });
    })
</script>
@endsection
