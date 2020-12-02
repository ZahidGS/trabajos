<?php

namespace App\Http\Controllers;

use DateTime;
use App\Salario;
use App\Vacante;
use App\Categoria;
use App\Ubicacion;
use App\Experiencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VacanteController extends Controller
{

    public function __construct()
    {
        //revisar usuario autenticado y verificado
        //$this->middleware(['auth', 'verified']); YA SE CUBRE EN EL ROUTE WEB.PHP
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacantes = Vacante::where('user_id', auth()->user()->id)->latest()->simplePaginate(3);

        return view('vacantes.index', compact('vacantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //consultas
        $categorias = Categoria::all();
        $experiencias = Experiencia::all();
        $ubicaciones = Ubicacion::all();
        $salarios = Salario::all();

        return view('vacantes.create', compact('categorias','experiencias','ubicaciones','salarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validacion
        $data = $request->validate([
            'titulo' => 'required|min:8',
            'categoria' => 'required',
            'experiencia' => 'required',
            'ubicacion' => 'required',
            'salario' => 'required',
            'descripcion' => 'required|min:50',
            'imagen' => 'required',
            'skills' => 'required'
        ]);

        //return $data['salario'];
        //return $request->all();
        //almacenar en la BD


        auth()->user()->vacantes()->create([
            'titulo' => $request->titulo,
            'imagen' => $request->imagen,
            'descripcion' => $request->descripcion,
            'skills' => $request->skills,
            'categoria_id' => $request->categoria,
            'salario_id' => $request->salario,
            'experiencia_id' => $request->experiencia,
            'ubicacion_id' => $request->ubicacion
        ]);
/*         auth()->user()->vacantes()->create([
            'titulo' => $data['titulo'],
            'imagen' => $data['imagen'],
            'descripcion' => $data['descripcion'],
            'skills' => $data['skills'],
            'categoria_id' => $data['categoria'],
            'salario_id' => $data['salario'],
            'experiencia_id' => $data['experiencia'],
            'ubicacion_id' => $data['ubicacion'],
        ]);
 */
        return redirect()->action('VacanteController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function show(Vacante $vacante)
    {
        //con este se aborta si la vacante esta inactiva y manda al 404
        //if($vacante->activa === 0) return abort(404);

        return view('vacantes.show')->with('vacante', $vacante);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacante $vacante)
    {
        //usar policy para revisar si el usuario que esta viendo es
        // el usuario que la creó. Antes creé la policy
        $this->authorize('view', $vacante);


        //consultas
        $categorias = Categoria::all();
        $experiencias = Experiencia::all();
        $ubicaciones = Ubicacion::all();
        $salarios = Salario::all();

        return view('vacantes.edit', compact('categorias','experiencias','ubicaciones','salarios','vacante'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacante $vacante)
    {
        //usar policy para revisar si el usuario que esta actualizando es
        // el usuario que la creó. Antes creé la policy
        $this->authorize('update', $vacante);

                //validacion
                $data = $request->validate([
                    'titulo' => 'required|min:8',
                    'categoria' => 'required',
                    'experiencia' => 'required',
                    'ubicacion' => 'required',
                    'salario' => 'required',
                    'descripcion' => 'required|min:50',
                    'imagen' => 'required',
                    'skills' => 'required'
                ]);

        $vacante->titulo = $data['titulo'];
        $vacante->skills = $data['skills'];
        $vacante->imagen = $data['imagen'];
        $vacante->descripcion = $data['descripcion'];
        $vacante->categoria_id = $data['categoria'];
        $vacante->experiencia_id = $data['experiencia'];
        $vacante->ubicacion_id = $data['ubicacion'];
        $vacante->salario_id = $data['salario'];

        $vacante->save();

        return redirect()->action('VacanteController@index');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacante $vacante)
    {
                //usar policy para revisar si el usuario que esta eliminando es
        // el usuario que la creó. Antes creé la policy
        $this->authorize('delete', $vacante);


        //revisar datos que recibe hasta aqui
        //return response()->json($vacante);


        $vacante->delete();

        return response()->json(['mensaje' => 'Se eliminó la vacante ' . $vacante->titulo]);
    }

    public function imagen(Request $request){

        $imagen = $request->file('file');
        $nombreImagen = date("Ymd") . '-' . time() . '.' . $imagen->extension();
        $imagen->move(public_path('storage/vacantes'),$nombreImagen );

        return response()->json(['correcto' =>  $nombreImagen]);
    }

    public function borrarimagen(Request $request)
    {
        if($request->ajax())
        {
            $imagen = $request->get('imagen');

            if (File::exists( 'storage/vacantes/' . $imagen )) {
                File::delete( 'storage/vacantes/' . $imagen );
            }

            return response('Imagen eliminada', 200);
        }
    }

    public function estado(Request $request, Vacante $vacante)
    {
        //leer nuevo estados y asignarlo
        $vacante->activa = $request->estado;

        //guardarlo en la BD
        $vacante->save();

        return response()->json(['respuesta' => 'Correcto']);
    }

    public function buscar(Request $request)
    {

        //validar
        $data = $request->validate([
            'categoria' => 'required',
            'ubicacion' => 'required'
        ]);

        //asignar valores recibidos del request
        $categoria = $data['categoria'];
        $ubicacion = $data['ubicacion'];

       //ES LO MISMO QUE LA BUSQUEDA DE ABAJO
           $vacantes = Vacante::latest()
            ->where('categoria_id', $categoria)
            ->where('ubicacion_id', $ubicacion)
            ->get();

        //ES LO MISMO QUE LA BUSQUEDA DE ARRIBA SIN EL OR
/*         $vacantes = Vacante::where([
            'categoria_id' => $categoria,
            'ubicacion_id' => $ubicacion
        ])->get(); */

        return view('buscar.index', compact('vacantes'));

    }

    public function resultados(){

    }
}
