<div class="panel panel-default">
    <div class="panel-heading text-center"><i class="fa fa-user" aria-hidden="true"></i> Confirmacion de pago para el usuario: <strong> {{ucfirst($user->name)}} {{$user->last_name}} - {{$user->email}}</strong></div>
    <div class="panel-body">
        <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! URL::route('payment.create', [$pickup->id]) !!}" >
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="text-center">
                  <i class="fa fa-file" aria-hidden="true"></i>
                  Informacion General
                </div>
              </div>
              <div class="panel-body">
                <!--Orden-->
                 <div class="form-group">
                     <div class="text-center">
                         <p>Orden: <strong>{{$pickup->code}}</strong></p>
                     </div>
                 </div>
                 <!--Total-->
                 <div class="form-group">
                     <div class="text-center">
                         <p>Total: <strong>{{$pickup->price}} {{env('ICS_CURRENCY')}} {{env('ICS_CURRENCY_SIMBOL')}}</strong></p>
                     </div>
                 </div>
                 <!--AddCharge-->
                 <div class="form-group">
                   <div class="text-center">
                     <p>Cargos Adicionales : <strong>{{isset($pickup->getAddCharge->value) ? $pickup->getAddCharge->value : ''}} {{env('ICS_CURRENCY')}} {{env('ICS_CURRENCY_SIMBOL')}} ({{isset($pickup->getAddCharge->name) ? $pickup->getAddCharge->name : 'Sin cargos Adicionales'}})</strong></p>
                   </div>
                 </div>
              </div>
            </div>
            <!---->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="text-center">
                      <i class="fa fa-cubes" aria-hidden="true"></i>
                        Carga agregada en el pickup
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-responsive table-hover">
                        <thead>
                          <tr>
                            <th># item</th>
                            <th>largo</th>
                            <th>ancho</th>
                            <th>alto</th>
                            <th>peso</th>
                            <th>precio</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($items as $key => $item)
                            <tr class="text-center">
                              <td># {{$key + 1}}</td>
                              <td>{{$item->large}}</td>
                              <td>{{$item->width}}</td>
                              <td>{{$item->height}}</td>
                              <td>{{$item->weight}}</td>
                              <td>{{$item->price}}</td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!---->
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-paypal" aria-hidden="true"></i>
                      Pagar con paypal
                    </button>
                </div>
            </div>
            <input type="hidden" name="amount" value="{{ $pickup->price }}">
        </form>
    </div>
</div>
