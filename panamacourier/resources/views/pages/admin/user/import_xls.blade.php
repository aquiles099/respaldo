<form role="form" action="{{asset($path)}}" method="post" enctype="multipart/form-data">
    <label for="">Subir archivo<input id="import_file" name="import_file" type="file"></label><br><br><br>
    <div class="col-md-12">
      <label for="">Especificaciones del archivo</label>
      <p style="font-size: 12px;">- Asegurese de que su archivo cumpla con el siguiente <a href="{{asset('/uploads/formato_users.xlsx')}}">formato.</a></p>
      <p style="font-size: 12px;">- El correo electronico de cada usuario es obligatorio, si este campo esta vacio, el usuario sera ignorado, es decir, no se registrará en la base de datos.</p>
    </div>
  <input type="submit" class="btn btn-primary" name="" value="Procesar">
</form>
