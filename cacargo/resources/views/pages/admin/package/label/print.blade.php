@set('js', ['js/includes/printCtrl.js'])
@section('pageTitle', isset($package) ? $package->code : '')
@include('sections.header')
<div id="wrapper"  style="background-color:white">
  <div id="page-wrapper" class="only">
    <div class="panel-white col-md-6 shadow ics-panel-white">
      <div id="icsPrint">
        <!--Logo-->
        <div class="row" >
          <div class="col-md-12">
            <header class = "pdfHeader">
              <table style="border-bottom: 1px solid lightgray">
                <tr>
                  <td>
                    <img style="idth: 90px;" src="{{isset($configuration) ? ($configuration->logo_ics == '') ? asset('/uploads/logo/005.png') : $configuration->logo_ics : asset('/uploads/logo/005.png')}}" alt="logo" />
                  </td>
                  <td style="text-align: justify; font-size: 11px; padding: 5px">
                    {{isset($configuration) ? $configuration->header_label : '' }}
                  </td>
                </tr>
              </table>
            </header>
          </div>
        </div>
        <!--nombre y origen-->
          <div class="row">
            <div class="col-lg-12">
              <p>
                <span>{{trans('print.From')}}:
                  <!--Nombre-->
                  @if(isset($configuration) && $configuration->option_selected_label == 1)
                    @if (isset($package->getToConsigneUser))
                      {{$package->getToConsigneUser['name']}}
                    @endif
                    <!--Nombre Completo-->
                    @elseif (isset($configuration) && $configuration->option_selected_label == 2 || isset($configuration) && $configuration->option_selected_label == 3)
                      @if (isset($package->to_user))
                        {{$package->getToConsigneUser['name']}} {{$package->getToConsigneUser['last_name']}}
                    @endif
                  @endif
                </span>
                <!--Conuntry Phone (Full)-->
                @if(isset($configuration) && $configuration->option_selected_label == 3)
                <span class="pull-right">{{trans('print.CountryOfOrigin')}} <br>
                  <span class="pull-right" style="font-size: 16px">
                    <b>
                      {{(isset($package->getToConsigneUser)) ? $package->getToConsigneUser['country'] : '' }}
                    </b>
                  </span>
                </span>
                @endif
              </p>
            </div>
          </div>
          <!---->
          <div class="row">
            <div class="col-lg-12">
              <p style="text-align:justify; width: 50%">
                <!--Address (Full)-->
                @if(isset($configuration) && $configuration->option_selected_label == 3)
                <span>{{trans('print.FullAdress')}}:
                  @if (isset($package->getToConsigneUser))
                    {{$package->getToConsigneUser['region']}}, {{$package->getToConsigneUser['city'] }}, {{$package->getToConsigneUser['address']}}, {{$package->getToConsigneUser['postal_code']}}
                  @endif
                </span>
                @endif
              </p>
              <p>
                <!--User Phone (Full)-->
                @if(isset($configuration) && $configuration->option_selected_label == 3)
                  <span class="pull-right" style="">{{trans('print.ContactPhone')}}:
                    @if (isset($package->getToConsigneUser))
                      {{$package->getToConsigneUser['celular']}} / {{$package->getToConsigneUser['local_phone']}}
                    @endif
                  </span>
                @endif
              </p>
            </div>
          </div>
          <!---->
          <div class="row">
            <div class="col-lg-12">
              <div class="ics-print-p" >
                <p style="padding: 10px">
                  <span>
                    <b>{{trans('print.To')}}:</b>
                    @if (isset($package->to_user))
                      @if ($package->to_client == null)
                        <!--Name-->
                        @if(isset($configuration) && $configuration->option_selected_label == 1)
                          {{$package->getToUser['name']}}
                        <!--Name and LastName-->
                        @elseif (isset($configuration) && $configuration->option_selected_label == 2 || isset($configuration) && $configuration->option_selected_label == 3)
                          {{$package->getToUser['name']}} {{$package->getToUser['last_name']}}
                        @endif
                      @else
                        <!--Name-->
                        @if(isset($configuration) && $configuration->option_selected_label == 1)
                          {{$package->getPackage->getToClient->name}}
                        <!--Name and LastName-->
                        @elseif (isset($configuration) && $configuration->option_selected_label == 2 || isset($configuration) && $configuration->option_selected_label == 3)
                          {{$package->getPackage->getToClient->name}} {{$package->getPackage->getToClient->last_name}}
                        @endif
                      @endif
                    @endif
                  </span>
                    <!--Destination Country (Full)-->
                  @if(isset($configuration) && $configuration->option_selected_label == 3)
                    <span class="pull-right">{{trans('print.DestinationCountry')}}: <br> <b style="font-size: 16px">
                      @if (isset($package->to_user))
                          {{$package->getToUser['country']}}
                      @endif</b>
                    </span>
                 @endif
                </p>
                <p style="padding: 10px; width: 50%;">
                 @if(isset($configuration) && $configuration->option_selected_label == 3)
                  <span>
                    <b>{{trans('print.FullAdress')}}:</b>
                    @if (isset($package->to_user))
                        {{$package->getToUser['country']}}, {{$package->getToUser['region']}}, {{$package->getToUser['city']}}, {{$package->getToUser['address']}}, {{$package->getToUser['postal_code']}} @else {{$package->getToUser['direction']}}
                    @endif
                  </span>
                 @endif
                </p>
                <p style="padding: 10px">
                @if(isset($configuration) && $configuration->option_selected_label == 3)
                  <span class="pull-right" >
                    <b>{{trans('print.ContactPhone')}}:</b>
                      @if (isset($package->to_user))
                        @if ($package->to_client == null)
                          {{$package->getToUser['celular']}}/{{$package->getToUser['local_phone']}}
                        @else
                          {{$package->getToUser['phone']}}
                        @endif
                      @endif
                  </span>
                @endif
                </p>
              </div>
            </div>
          </div>
          <!---->
          <br>
          <div class="row">
            <div class="col-md-12">
              <table class="text-center" style="width:100%">
                <thead>
                  <th>{{trans('print.ShipDate')}}</th>
                  <th>{{trans('print.Weight')}}</th>
                  <th>{{trans('print.Piece')}}</th>
                  <th>{{trans('print.Content')}}</th>
                  <th>{{trans('print.Dimensions')}}</th>
                </thead>
                <tbody>
                  <tr>
                    <td>{{(isset($package)) ? $package->created_at->format('Y-m-d') : '' }}</td>
                    <td>{{(isset($package)) ? $package->weight : '' }} lb</td>
                    <td>{{(isset($package)) ? $package->pieces : '' }} </td>
                    <td></td>
                    <td>@if (isset($package)) {{$package->width}}x{{$package->height}}x{{$package->large}}@endif</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!---->
          <div class="row">
            <div class="col-lg-12">
              <span>{{trans('print.Delivered')}}:</span>
              <div data-role="content" style="text-align: center">
                <form id="qrform" >
                  <input type="hidden" name="msg" value="{{(isset($package->code)) ? $package->code : '' }}">
                </form>
              <div id="qr"></div>
              </div>
            </div>
          </div>
          <div><h4>{{isset($package->code) ? $package->code:'' }}</h4></div>
          <div class="row">
            <div class="col-md-12">
              <div style="text-align: justify">
                {{isset($configuration) ? $configuration->footer_label : '' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('sections.footer')
