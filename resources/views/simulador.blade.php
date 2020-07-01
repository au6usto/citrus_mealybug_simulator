@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="<?= url('/') . '/img/mealybug.png' ?>" alt="" >
        <h2>Simulador de Plantación Invadida por Cochinillas</h2>
    </div>
    <div class="row">
    <div class="col-md-12 order-md-1">
      <h4 class="mb-3">Datos de Plantación</h4>
    </div>
</div>
<form method="POST" action="<?= url('/') . '/resultado_simulador' ?>">
  @csrf
<div class="mb-3">
  <label for="plots">Cantidad de Parcelas</label>
  <div class="input-group">
    <input name="plots" type="number" class="form-control" id="plots" placeholder="" required="">
    <div class="input-group-append">
      <span class="input-group-text">u</span>
  </div>
</div>
</div>

<div class="mb-3">
  <label for="plantsAmount">Cantidad de Plantas por Parcela</label>
  <div class="input-group">
    <input name="plantsAmount" type="number" class="form-control" id="plantsAmount" placeholder="" required="">
    <div class="input-group-append">
      <span class="input-group-text">u</span>
  </div>
</div>
</div>

<div class="mb-3">
  <label for="damageLimit">Porcentaje de Daño dispuesto a Asumir</label>
  <div class="input-group">
    <input name="damageLimit" type="number" class="form-control" id="damageLimit" placeholder="" required="">
    <div class="input-group-append">
      <span class="input-group-text">%</span>
  </div>
</div>
</div>

<hr class="mb-4">
<button class="btn btn-primary btn-lg btn-block" type="submit">Simular</button>
</form>
</div>
</div>
</div>
@endsection
