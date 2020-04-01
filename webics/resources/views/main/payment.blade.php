@section('title-page', trans('messages.payment'))
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
    <h4>{{trans('messages.payment')}}</h4>
  	<div class="row">
  		<div class="span12">
        <div class="row">
          <div class="col-md-8">
            @include('sections.messages')
            <!--Info-->
            <div class="" style="padding-bottom: 1%">
              <h5>
                <!--Header-->
                <span class="icstitle">
                  Ha solicitado un pago para
                    <strong>
                      @if ($solicitude->profile == '1') {{trans('messages.basicICS')}}  @endif  @if ($solicitude->profile == '2') {{trans('messages.profesionalICS')}} @endif
                    </strong>
                </span>
                <!--Other Payment Button-->
                {{--
                  <span class="icsotherpay">
                    <a onclick="icsOthersPayment()">Otras formas de pago
                      <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </a>
                  </span>
                --}}
              </h5>
            </div>
            <!--Form-->
            <div class="cform" id="contact-form">
              <div class="form">
                <form action="{{asset("payment?p=$client->remember_token")}}" method="post" id="icsformserialize" enctype="multipart/form-data" onsubmit="icsGeneralLoad('sendButton')">
                  <div class="">
                    <fieldset >
                      <input type="hidden" name="p" id="p" value="{{$client->remember_token}}">
                      <!--Time-->
                      <div class="field subject form-group @include('errors.field-class', ['field' => 'years'])" style="margin-bottom: 45px">
                        <label for="years">
                          <i class="fa fa-clock-o" aria-hidden="true"></i>
                          {{trans('messages.timecontract')}} <small>(solo si no ha contratado)</small>
                        </label>
                        <select class="form-control" name="years" id="years" required="true">
                          <option value="0">{{trans('messages.selectoption')}}</option>
                          @foreach($time as $key => $value)
                            <option item="{{$value->toJson()}}" {{Input::get('years') == ($key + 1) ? 'selected' : ''}} value="{{$key + 1}}">{{$key + 1}} {{trans('messages.year')}}/s {{$value->annual}} {{env('CURRENCY')}}</option>
                          @endforeach
                        </select>
                        @include('errors.field', ['field' => 'years'])
                      </div>
                      <!--Amount-->
                      <div class="field your-email form-group @include('errors.field-class', ['field' => 'amount'])">
                        <label for="amount" style="text-align: left">
                          <i class="fa fa-money" aria-hidden="true"></i>
                          {{trans('messages.amount')}}
                        </label>
                        <input type="text" id="amount"  name="amount" class="form-control"  value="{{Input::get('amount')}}"  placeholder="{{trans('messages.amount')}}" required="true"/>
                        @include('errors.field', ['field' => 'amount'])
                      </div>
                      <!--Bank-->
                      <div class="field your-email form-group @include('errors.field-class', ['field' => 'bank'])">
                        <label for="bank" style="text-align: left">
                          <i class="fa fa-university" aria-hidden="true"></i>
                          {{trans('messages.bank')}}
                        </label>
                        <input type="text" id="bank"  name="bank" class="form-control"  value="{{Input::get('bank')}}"  placeholder="{{trans('messages.bank')}}" required="true" />
                        @include('errors.field', ['field' => 'bank'])
                      </div>
                      <!--Transaction-->
                      <div class="field your-email form-group @include('errors.field-class', ['field' => 'transaction'])">
                        <label for="transaction" style="text-align: left">
                          <i class="fa fa-hashtag" aria-hidden="true"></i>
                          {{trans('messages.transaction')}}
                        </label>
                        <input type="text" id="transaction"  name="transaction" class="form-control"  value="{{Input::get('transaction')}}"  placeholder="{{trans('messages.transaction')}}" required="true" />
                        @include('errors.field', ['field' => 'transaction'])
                      </div>
                      <!--observation-->
                      <div class="field your-email form-group @include('errors.field-class', ['field' => 'observation'])">
                        <label for="observation" style="text-align: left">
                          <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                          {{trans('messages.observation')}}
                        </label>
                        <textarea name="observation" id="observation" class="form-control icstextarea">{{Input::get('observation')}}</textarea>
                        @include('errors.field', ['field' => 'observation'])
                      </div>
                      <!--Attachment-->
                      <div class="field your-email form-group @include('errors.field-class', ['field' => 'attachment'])">
                        <label for="attachment" style="text-align: left">
                          <i class="fa fa-file" aria-hidden="true"></i>
                          {{trans('messages.attachment')}}
                        </label>
                        <input type="file" id="attachment"  name="attachment" class="file" required="true" />
                        @include('errors.field', ['field' => 'attachment'])
                      </div>
                      <!--Action-->
                      <div class="" style="text-align: right">
                        <button type="submit" class="btn btn-default btn-xs" id="sendButton">{{trans('messages.send')}}</button>
                      </div>
                      <!--Total-->
                      <input type="hidden" id="total" name="total" value="{{Input::get('total')}}">
                    </fieldset>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4" style="padding-top: 6%;">
            <!---->
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-money" aria-hidden="true"></i>
                {{trans('messages.remaining')}}
              </div>
              <div class="panel-body" style="height: 150px">
                <div class="">
                  <div class="portfolio-item grid print photography">
                    <div class="portfolio ">
                      <h4 class="icstitle">
                        <span id="debt">{{!is_null($billing) ? $billing->debt : ''}}</span> {{env('CURRENCY')}}
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!---->
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-usd" aria-hidden="true"></i>
                {{trans('messages.prices')}}
              </div>
              <div class="panel-body">
                <!-- portfolio item -->
                <div class="portfolio-item grid print photography" >
                  <div class="portfolio icscircle" style="border-radius: 170px;">
                    <a href="{{asset('dist/img/b5.jpg')}}" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
                    <img  src="{{asset('dist/img/icon/money.png')}}" alt="" />
                    <div class="portfolio-overlay">
                      <div class="thumb-info">
                        <h5>{{trans('messages.seemore')}}</h5>
                        <i class="fa fa-eye fa-fw icon-2x"></i>
                      </div>
                    </div>
                    </a>
                  </div>
                  <div style="text-align: center">
                    <h2 class="icstitle" style="font-size: 28px" >{{trans('messages.prices')}}</h2>
                    <h5 class="icstitle">{{trans('messages.ICS')}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
