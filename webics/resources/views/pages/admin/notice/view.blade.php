<div class="panel panel-default">
  <div class="panel-heading">
    <p>
      Publicado Por: <strong>{{$notice->getAdmin->name}}</strong>
    </p>
  </div>
  <div class="panel-body">
    <!---->
    <p>
      <strong>Titulo: </strong> {{$notice->title}}
    </p>
    <!---->
    <p>
     <strong>Extracto: </strong> {{$notice->extract}}
    </p>
    <!---->
    <p>
     <strong>Descripcion: </strong>
     <div class="panel panel-default">
       <div class="panel-body">
           <span id="icsDescription">{{$notice->description}}</span>
       </div>
     </div>
    </p>
    <!---->
    <p>
      <strong>Imagen:</strong>
    </p>
    <!---->
    <img src="{{$notice->img}}" alt="" style="width:170px "/>
  </div>
</div>
