<div class="panel panel-default" id="" >
  <div class="panel-body">
    <table class="" id="dtble">
      <thead>
        <tr>
          <th style="width:10%; text-align:center;">{{trans('package.tracking')}}</th>
          <th style="width:50%; text-align:center;">{{trans('package.type')}}</th>
          <th style="width:25%; text-align:center;">{{trans('package.invoice')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($packages as $package)
        <tr item="">
          <td><a class="infoRd" href="javascript:detailspackagedash('{{$package->id}}')">{{$package->tracking}}</a></td>
          <td>{{$package->getType != null ? $package->getType->getName() : ''}}</td>
          <td>@if($package->invoice == 0)<i class="fa fa-times" aria-hidden="true"></i>@else<i class="fa fa-check" aria-hidden="true"></i>@endif</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
