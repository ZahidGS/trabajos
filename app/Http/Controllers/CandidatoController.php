<?php

namespace App\Http\Controllers;

use App\Vacante;
use App\Candidato;
use Illuminate\Http\Request;
use App\Notifications\NuevoCandidato;

class CandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //obtener ID actual
        $id_vacante = $request->route('id');

        //obtener los candidatos y la vacante
        $vacante = Vacante::findOrFail( $id_vacante );

        //usar policy para revisar si el usuario que esta viendo es
        // el usuario que la creó. Antes creé la policy
        $this->authorize('view', $vacante);

        //dd($vacante->candidatos);

        return view('candidatos.index', compact('vacante'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nombre' => 'required',
            'email' => 'required|email',
            'cv' => 'required|mimes:pdf|max:1000',
            'vacante_id' => 'required',
        ]);

/*

        //UAN FORMA DE GUARDAR DATOS - INSTANCIANDO EL MODELO Y ACTUALIZANDO CAMPOS
        $candidato = new Candidato();
        $candidato->nombre = $data['nombre'];
        $candidato->email = $data['email'];
        $candidato->vacante_id = $data['vacante_id'];
        $candidato->cv = '123.pdf';
        $candidato->save();




        //segunda FORMA - INSTANCIANDO Y PASANDO OBJETO, ACTUALIZANDO UN CAMPO
        //ESTO REQUIERE QUE SE APLIQUE EN EL MODELO EL FILLABLE DE LOS CAMPOS A GUARDAR
        $candidato = new Candidato($data);
        $candidato->cv = '123.pdf';
        $candidato->save();




        //TERCERA FORMA, tambien REQUIERE QUE SE APLIQUE EN EL MODELO EL
        //FILLABLE DE LOS CAMPOS A GUARDAR
        $candidato = new Candidato();
        $candidato->fill($data);
        $candidato->cv = '123.pdf';
        $candidato->save();

 */

        //CUARTA FORMA, REQUIERE CREAR RELACION EN EL MODELO PADRE
        //RECOMENDADA POR EL USO DE RELACIONES
        $vacante = Vacante::find($data['vacante_id']);


        if ($request->file('cv')) {
            $archivo = $request->file('cv');
            $nombreArchivo = time() . "." . $request->file('cv')->extension();
            $ubicacion = public_path('/storage/cv');
            $archivo->move($ubicacion,$nombreArchivo);
        }

        $vacante->candidatos()->create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'cv' => $nombreArchivo
        ]);

        $reclutador = $vacante->reclutador;
        $reclutador->notify( new NuevoCandidato( $vacante->titulo, $vacante->id ) );

        return back()->with('estado', 'Tus datos se enviaron correctamente. ¡suerte!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function show(Candidato $candidato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidato $candidato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidato $candidato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidato $candidato)
    {
        //
    }
}
