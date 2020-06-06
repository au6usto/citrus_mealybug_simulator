@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Mes</th>
                    <th scope="col">Octubre</th>
                    <th scope="col">Noviembre</th>
                    <th scope="col">Diciembre</th>
                    <th scope="col">Enero</th>
                    <th scope="col">Febrero</th>
                    <th scope="col">Marzo</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">Temperatura</th>
                    <td>20°C</td>
                    <td>23°C</td>
                    <td>25°C</td>
                    <td>25°C</td>
                    <td>26°C</td>
                    <td>22°C</td>
                  </tr>
                  <tr>
                      <th scope="row"></th>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr class="table-primary">
                      <th scope="row">Numero de vuelo</th>
                      <td>Primer Vuelo</td>
                      <td colspan="2">Segundo Vuelo</td>
                      <td>Tercer Vuelo</td>
                      <td>Cuarto Vuelo</td>
                      <td>Reducción de la problación</td>
                  </tr>
                  <tr>
                      <th scope="row">Cantidad de <br>Machos Atrapados</th>
                      <td>308.47</td>
                      <td colspan="2">1690.73</td>
                      <td>1323.12</td>
                      <td>433.36</td>
                      <td>223.65</td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection
