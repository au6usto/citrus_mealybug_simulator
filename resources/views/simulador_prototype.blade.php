@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="Interfaz_archivos/Asian-Citrus-Psyllid.png" alt="" >
        <h2>Simulador de Plantación</h2>
    </div>
    <div class="row">
        <!-- <div class="col-md-4 order-md-2 mb-4"> -->
      <!-- <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Resultados</span>
        <span class="badge badge-secondary badge-pill">3</span>
    </h4> -->
      <!-- <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Producción de limones</h6>
            <small class="text-muted">por hectárea</small>
          </div>
          <span class="text-muted">XXXX</span>
        </li>
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Producción de limones perdida</h6>
            <small class="text-muted">por hectárea</small>
          </div>
          <span class="text-muted">XXXX</span>
        </li>
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Población de cochinillas</h6>
            <small class="text-muted"> por hectárea</small>
          </div>
          <span class="text-muted">XXXX</span>
        </li>
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Cantidad de pesticida</h6>
            <small class="text-muted">por hectárea</small>
          </div>
          <span class="text-muted">XXXX</span>
        </li>
    </ul> -->
    <!-- </div> -->
    <div class="col-md-12 order-md-1">
      <h4 class="mb-3">Datos de Entrada</h4>
      <form class="needs-validation" novalidate="">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">Desde</label>
            <input type="date" class="form-control" id="firstName" placeholder="" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
        </div>
        <div class="col-md-6 mb-3">
            <label for="lastName">Hasta</label>
            <input type="date" class="form-control" id="lastName" placeholder="" required="">
        </div>
    </div>

    <div class="mb-3">
      <label for="username">Temperatura Ambiente</label>
      <div class="input-group">
        <input type="number" class="form-control" id="username" placeholder="" required="">
        <div class="input-group-append">
          <span class="input-group-text">°C</span>
      </div>
  </div>
</div>

<div class="mb-3">
  <label for="username">Humedad Ambiente</label>
  <div class="input-group">
    <input type="number" class="form-control" id="username" placeholder="" required="">
    <div class="input-group-append">
      <span class="input-group-text">%</span>
  </div>
</div>
</div>

<div class="mb-3">
  <label for="username">Área a analizar</label>
  <div class="input-group">
    <input type="number" class="form-control" id="username" placeholder="" required="">
    <div class="input-group-append">
      <span class="input-group-text">ha</span>
  </div>
</div>
</div>

<div class="mb-3">
  <label for="username">Cantidad de Plantas</label>
  <div class="input-group">
    <input type="number" class="form-control" id="username" placeholder="" required="">
    <div class="input-group-append">
      <span class="input-group-text">u/ha</span>
  </div>
</div>
</div>

<div class="mb-3">
  <label for="username">Cantidad de autos <div class="text-muted">promedio que ingresa a la ciudad</div></label>
  <div class="input-group">
    <input type="number" class="form-control" id="username" placeholder="" required="">
    <div class="input-group-append">
      <span class="input-group-text">u</span>
  </div>
</div>
</div>
<div class="mb-3">
  <label for="username">Insecticida</label>
  <div class="input-group">
    <select class="custom-select" multiple>
      <option value="1" selected>Insecticida 1</option>
      <option value="2" selected>Insecticida 2</option>
      <option value="3">Insecitcida 3</option>
  </select>
</div>
</div>
<hr class="mb-4">
<button class="btn btn-primary btn-lg btn-block" type="submit">Simular</button>
</form>
</div>
</div>
</div>
@endsection
